<?php

class Cart {
    private $db;
    public $artworks = [];
    public $userID;

    public function __construct($userID = null) {
        $this->db = new DBController();
        $this->userID = $userID;
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($this->userID) {
            $this->loadFromDatabase();
            $this->mergeSessionCartIntoDatabase();
        } elseif (isset($_SESSION['cart'])) {
            $this->artworks = $_SESSION['cart'];
        }
    }

    private function loadFromDatabase() {
        $query = "SELECT a.ArtworkID, a.Title, a.Price, a.Image, c.Quantity, a.Stock 
                  FROM cart c 
                  JOIN artworks a ON c.ArtworkID = a.ArtworkID 
                  WHERE c.UserID = ?";
        $result = $this->db->select($query, [$this->userID]);
        
        if ($result) {
            $this->artworks = $result;
            $this->saveToSession();
        }
    }

    private function saveToDatabase($artworkID, $quantity = 1) {
        $query = "INSERT INTO cart (UserID, ArtworkID, Quantity, DateAdded) 
                  VALUES (?, ?, ?, NOW()) 
                  ON DUPLICATE KEY UPDATE Quantity = VALUES(Quantity)";
        return $this->db->execute($query, [
            $this->userID, 
            $artworkID, 
            $quantity
        ]);
    }

    private function updateQuantityInDatabase($artworkID, $quantity) {
        $query = "UPDATE cart SET Quantity = ? WHERE UserID = ? AND ArtworkID = ?";
        return $this->db->execute($query, [
            $quantity,
            $this->userID,
            $artworkID
        ]);
    }

    private function removeFromDatabase($artworkID) {
        $query = "DELETE FROM cart WHERE UserID = ? AND ArtworkID = ?";
        return $this->db->execute($query, [$this->userID, $artworkID]);
    }

    public function mergeSessionCartIntoDatabase() {
        if (!$this->userID || empty($_SESSION['cart'])) {
            return;
        }

        foreach ($_SESSION['cart'] as $artwork) {
            $exists = false;
            foreach ($this->artworks as $item) {
                if ($item['ArtworkID'] == $artwork['ArtworkID']) {
                    $exists = true;
                    break;
                }
            }
            if (!$exists) {
                $this->addArtwork($artwork);
            }
        }

        unset($_SESSION['cart']);
    }

    // NEW METHOD: updateQuantity
    public function updateQuantity($artworkID, $quantity) {
        if ($quantity <= 0) {
            return $this->removeArtwork($artworkID);
        }

        foreach ($this->artworks as &$item) {
            if ($item['ArtworkID'] == $artworkID) {
                $item['Quantity'] = $quantity;
                
                if ($this->userID) {
                    $this->updateQuantityInDatabase($artworkID, $quantity);
                }
                
                $this->saveToSession();
                return true;
            }
        }
        
        return false;
    }

    public function addArtwork($artwork, $quantity = 1) {
        if (empty($artwork['ArtworkID'])) {
            throw new Exception("Artwork ID is required.");
        }

        foreach ($this->artworks as &$item) {
            if ($item['ArtworkID'] == $artwork['ArtworkID']) {
                $newQuantity = ($item['Quantity'] ?? 0) + $quantity;
                return $this->updateQuantity($artwork['ArtworkID'], $newQuantity);
            }
        }
        
        $this->artworks[] = [
            'ArtworkID' => $artwork['ArtworkID'],
            'Title' => $artwork['Title'],
            'Price' => $artwork['Price'],
            'Image' => $artwork['Image'],
            'Quantity' => $quantity,
            'Stock' => $artwork['Stock'] ?? null
        ];
        
        if ($this->userID) {
            $this->saveToDatabase($artwork['ArtworkID'], $quantity);
        }
        
        $this->saveToSession();
        return true;
    }

    public function removeArtwork($artworkID) {
        foreach ($this->artworks as $index => $artwork) {
            if ($artwork['ArtworkID'] == $artworkID) {
                unset($this->artworks[$index]);
                $this->artworks = array_values($this->artworks);
                
                if ($this->userID) {
                    $this->removeFromDatabase($artworkID);
                }
                
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->artworks as $artwork) {
            $total += $artwork['Price'] * ($artwork['Quantity'] ?? 1);
        }
        return $total;
    }

    public function listArtworks() {
        return $this->artworks;
    }

    public function clearCart() {
        if ($this->userID) {
            $query = "DELETE FROM cart WHERE UserID = ?";
            $this->db->execute($query, [$this->userID]);
        }
        
        $this->artworks = [];
        $this->saveToSession();
        return true;
    }

    public function checkout() {
        if (empty($this->artworks)) {
            return false;
        }

        if (!$this->userID) {
            throw new Exception("User ID is required for checkout");
        }

        $this->db->beginTransaction();
        try {
            $date = date('Y-m-d H:i:s');
            
            foreach ($this->artworks as $artwork) {
                // Verify stock is available
                $stockQuery = "SELECT Stock FROM artworks WHERE ArtworkID = ?";
                $stockResult = $this->db->select($stockQuery, [$artwork['ArtworkID']]);
                
                if (!$stockResult || $stockResult[0]['Stock'] < $artwork['Quantity']) {
                    throw new Exception("Not enough stock for artwork ID: " . $artwork['ArtworkID']);
                }

                // Record purchase
                $query = "INSERT INTO purchases (UserID, ArtworkID, Quantity, Date) 
                         VALUES (?, ?, ?, ?)";
                $success = $this->db->execute($query, [
                    $this->userID,
                    $artwork['ArtworkID'],
                    $artwork['Quantity'],
                    $date
                ]);
                
                if (!$success) {
                    throw new Exception("Failed to record purchase");
                }

                // Update stock
                $updateStock = "UPDATE artworks SET Stock = Stock - ? WHERE ArtworkID = ?";
                $this->db->execute($updateStock, [
                    $artwork['Quantity'],
                    $artwork['ArtworkID']
                ]);
                
                // Remove from cart
                $this->removeFromDatabase($artwork['ArtworkID']);
            }
            
            $this->db->commit();
            $this->clearCart();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Checkout failed: " . $e->getMessage());
            return false;
        }
    }

    private function saveToSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['cart'] = $this->artworks;
    }
}