<?php
// Assuming Cart.php is in Model/Classes/ and DBController.php is in Controller/
// relative to the project root. Artwork.php is in the same Model/Classes/ directory.
require_once __DIR__ . '/../../Controller/DBController.php';
require_once __DIR__ . '/Artwork.php'; // Needed for fetching artwork details

class Cart
{
    private $db; // Instance of DBController
    public $artworks = []; // Array of cart items [artwork_id => [details]]
    public $userID;
    private $lastDbError = null;

    public function __construct($userID = null)
    {
        $this->db = new DBController();
        $this->userID = $userID ? (int)$userID : null;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($this->userID) {
            // User is logged in
            $this->loadFromDatabase(); // Load persistent cart from DB into $this->artworks
            $this->mergeSessionCartIntoDatabase(); // Merge any guest session cart items
            // This method will call loadFromDatabase() and saveToSession() at its end.
        } elseif (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            // User is a guest, load from session
            $this->artworks = $this->structureCartItems($_SESSION['cart']);
        } else {
            // No user, no session cart, initialize empty
            $_SESSION['cart'] = [];
            $this->artworks = [];
        }
    }

    /**
     * Ensures cart items are consistently structured, ideally keyed by ArtworkID for easier access.
     * The internal $this->artworks will store items keyed by ArtworkID.
     * listArtworks() will return an indexed array for easier iteration in views.
     */
    private function structureCartItems(array $items): array
    {
        $structuredItems = [];
        foreach ($items as $item) {
            if (isset($item['ArtworkID'])) {
                $structuredItems[(int)$item['ArtworkID']] = $item;
            }
        }
        return $structuredItems;
    }


    private function loadFromDatabase()
    {
        if (!$this->userID) return;

        $query = "SELECT a.ArtworkID, a.Title, a.Price, a.Image, c.Quantity, a.numberInStock 
                  FROM cart c 
                  JOIN artworks a ON c.ArtworkID = a.ArtworkID 
                  WHERE c.UserID = ?";
        $result = $this->db->select($query, [$this->userID]);

        $this->artworks = []; // Reset current in-memory cart
        if ($result !== false && is_array($result)) {
            $this->artworks = $this->structureCartItems($result);
        } else {
            $this->lastDbError = $this->db->getLastError();
            error_log("Cart: Failed to load from database for UserID {$this->userID}. Error: " . $this->lastDbError);
        }
        // Note: saveToSession() will be called after merge or if no merge is needed.
    }

    /**
     * Saves an item to the database cart. Inserts if new, updates quantity if existing.
     */
    private function saveItemToDatabase(int $artworkID, int $quantity)
    {
        if (!$this->userID || $quantity <= 0) return false;

        $checkQuery = "SELECT Quantity FROM cart WHERE UserID = ? AND ArtworkID = ?";
        $existing = $this->db->selectSingle($checkQuery, [$this->userID, $artworkID]);

        $success = false;
        if ($existing) {
            // Item exists, update quantity
            $updateQuery = "UPDATE cart SET Quantity = ?, DateAdded = NOW() WHERE UserID = ? AND ArtworkID = ?";
            $success = $this->db->execute($updateQuery, [$quantity, $this->userID, $artworkID]);
        } else {
            // Item does not exist, insert new
            $insertQuery = "INSERT INTO cart (UserID, ArtworkID, Quantity, DateAdded) VALUES (?, ?, ?, NOW())";
            $success = $this->db->execute($insertQuery, [$this->userID, $artworkID, $quantity]);
        }
        if (!$success) $this->lastDbError = $this->db->getLastError();
        return $success;
    }

    private function updateQuantityInDatabase(int $artworkID, int $quantity)
    {
        // This is essentially the same as saveItemToDatabase if quantity > 0
        if ($quantity <= 0) {
            return $this->removeFromDatabase($artworkID);
        }
        return $this->saveItemToDatabase($artworkID, $quantity);
    }

    private function removeFromDatabase(int $artworkID)
    {
        if (!$this->userID) return false;
        $query = "DELETE FROM cart WHERE UserID = ? AND ArtworkID = ?";
        $success = $this->db->execute($query, [$this->userID, $artworkID]);
        if (!$success) $this->lastDbError = $this->db->getLastError();
        return $success;
    }

    public function mergeSessionCartIntoDatabase()
    {
        if (!$this->userID || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            // No user, or no session cart to merge, or session cart is not an array.
            // If user is logged in but session cart is empty, ensure session is synced with DB.
            if ($this->userID) $this->saveToSession();
            return;
        }

        $sessionCartData = $_SESSION['cart']; // This is likely an indexed array
        unset($_SESSION['cart']); // Clear old session cart immediately to prevent issues on reload

        foreach ($sessionCartData as $sessionItem) {
            if (!isset($sessionItem['ArtworkID'])) continue;

            $sessionArtworkID = (int)$sessionItem['ArtworkID'];
            $sessionQuantity = isset($sessionItem['Quantity']) ? (int)$sessionItem['Quantity'] : 1;
            if ($sessionQuantity <= 0) continue; // Ignore invalid quantities

            // $this->artworks is already populated from loadFromDatabase()
            if (isset($this->artworks[$sessionArtworkID])) {
                // Item from session already exists in user's DB cart.
                // Strategy: Update DB quantity if session quantity is higher AND stock allows.
                // Or, simply let the DB version loaded by loadFromDatabase() be the authority.
                // For now, let's make DB authoritative. If a different quantity is desired,
                // it should be explicitly updated via updateQuantity.
                // So, we do nothing here for items already in $this->artworks from DB load.

            } else {
                // Item from session is NOT in the DB-loaded cart. Try to add it.
                $artworkDetails = Artwork::getArtworkById($sessionArtworkID); // Fetch live details
                if ($artworkDetails) {
                    $artworkDataForCart = [
                        'ArtworkID'     => $artworkDetails->getArtworkID(),
                        'Title'         => $artworkDetails->getTitle(),
                        'Price'         => $artworkDetails->getPrice(),
                        'Image'         => $artworkDetails->getImage(),
                        'numberInStock' => $artworkDetails->getNumberInStock()
                    ];
                    try {
                        // addArtwork handles in-memory update and DB save for new items.
                        // Pass true for skipSaveToSession, as we'll do a final saveToSession later.
                        $this->addArtwork($artworkDataForCart, $sessionQuantity, true);
                    } catch (Exception $e) {
                        error_log("Merge Error: Could not add session item {$sessionArtworkID} for user {$this->userID}. Reason: " . $e->getMessage());
                    }
                }
            }
        }

        // After attempting to merge, $this->artworks may have changed.
        // It's best to reload from the database to ensure $this->artworks accurately reflects
        // what's now persistently stored for the user.
        $this->loadFromDatabase();
        $this->saveToSession(); // Sync the final state of $this->artworks to the session.
    }

    /**
     * Adds an artwork to the cart or updates its quantity if it already exists.
     * @param array $artworkData Artwork details (ArtworkID, Title, Price, Image, numberInStock)
     * @param int $quantity The quantity to add to the existing amount, or the initial quantity if new.
     * @param bool $skipSaveToSession Internal flag to prevent recursive session saves during merge.
     * @return bool True on success, false on failure.
     * @throws Exception If stock is insufficient or other critical error.
     */
    public function addArtwork(array $artworkData, int $quantity = 1, bool $skipSaveToSession = false): bool
    {
        if (!isset($artworkData['ArtworkID']) || !isset($artworkData['numberInStock'])) {
            throw new Exception("Artwork ID and stock information are required for adding to cart.");
        }
        $artworkID = (int)$artworkData['ArtworkID'];
        if ($quantity <= 0) throw new Exception("Quantity to add must be positive.");

        $currentStock = (int)$artworkData['numberInStock'];
        $newTotalQuantity = $quantity; // Assume it's a new item initially

        if (isset($this->artworks[$artworkID])) { // Item already in cart
            $newTotalQuantity = (int)$this->artworks[$artworkID]['Quantity'] + $quantity;
        }

        // Validate against stock AFTER calculating potential new total
        if ($newTotalQuantity > $currentStock) {
            throw new Exception(
                "Not enough stock available for \"" . htmlspecialchars($artworkData['Title'] ?? 'Artwork') .
                    "\". Requested total: {$newTotalQuantity}, Stock: {$currentStock}"
            );
        }

        // Update in-memory cart
        $this->artworks[$artworkID] = [
            'ArtworkID'     => $artworkID,
            'Title'         => $artworkData['Title'] ?? 'N/A',
            'Price'         => $artworkData['Price'] ?? 0.0,
            'Image'         => $artworkData['Image'] ?? 'default.jpg',
            'Quantity'      => $newTotalQuantity,
            'numberInStock' => $currentStock // Store stock with item for quick checks
        ];

        $dbSuccess = true;
        if ($this->userID) {
            $dbSuccess = $this->saveItemToDatabase($artworkID, $newTotalQuantity);
        }

        if ($dbSuccess && !$skipSaveToSession) {
            $this->saveToSession();
        }
        return $dbSuccess;
    }

    /**
     * Updates the quantity of an existing item in the cart.
     * @param int $artworkID
     * @param int $newQuantity The new total quantity for the item.
     * @param bool $skipSaveToSession Internal flag.
     * @return bool
     * @throws Exception
     */
    public function updateQuantity(int $artworkID, int $newQuantity, bool $skipSaveToSession = false): bool
    {
        if ($newQuantity <= 0) {
            return $this->removeArtwork($artworkID, $skipSaveToSession);
        }

        if (!isset($this->artworks[$artworkID])) {
            // Optionally, could try to fetch artwork and add it if not found, but update implies existence.
            throw new Exception("Artwork ID {$artworkID} not found in cart to update quantity.");
        }

        // Use stored stock if available, otherwise fetch live stock (less ideal for performance here)
        $currentStock = $this->artworks[$artworkID]['numberInStock'] ?? null;
        if ($currentStock === null) {
            $artworkDetails = Artwork::getArtworkById($artworkID);
            if (!$artworkDetails) throw new Exception("Could not retrieve details for Artwork ID {$artworkID}.");
            $currentStock = $artworkDetails->getNumberInStock();
            $this->artworks[$artworkID]['numberInStock'] = $currentStock; // Cache it
        }


        if ($newQuantity > $currentStock) {
            throw new Exception(
                "Cannot update quantity for \"" . htmlspecialchars($this->artworks[$artworkID]['Title'] ?? 'Artwork') .
                    "\". Requested: {$newQuantity}, Stock: {$currentStock}"
            );
        }

        $this->artworks[$artworkID]['Quantity'] = $newQuantity;

        $dbSuccess = true;
        if ($this->userID) {
            $dbSuccess = $this->updateQuantityInDatabase($artworkID, $newQuantity);
        }

        if ($dbSuccess && !$skipSaveToSession) {
            $this->saveToSession();
        }
        return $dbSuccess;
    }

    /**
     * Removes an artwork from the cart.
     * @param int $artworkID
     * @param bool $skipSaveToSession Internal flag.
     * @return bool
     */
    public function removeArtwork(int $artworkID, bool $skipSaveToSession = false): bool
    {
        $itemExisted = isset($this->artworks[$artworkID]);
        unset($this->artworks[$artworkID]); // Remove from in-memory cart

        $dbSuccess = true;
        if ($this->userID && $itemExisted) { // Only try to remove from DB if it was there
            $dbSuccess = $this->removeFromDatabase($artworkID);
        }

        if (!$skipSaveToSession) {
            $this->saveToSession();
        }
        return $dbSuccess || !$itemExisted; // Return true if removed or was never there
    }

    public function getTotalPrice(): float
    {
        $total = 0.0;
        foreach ($this->artworks as $item) {
            $total += ($item['Price'] ?? 0) * ($item['Quantity'] ?? 1);
        }
        return $total;
    }

    /**
     * Returns the cart items as an indexed array for easy iteration in views.
     */
    public function listArtworks(): array
    {
        return array_values($this->artworks); // Convert [artwork_id => item] to indexed array
    }

    public function getItemCount(): int
    {
        return count($this->artworks);
    }

    public function clearCart(): bool
    {
        $dbSuccess = true;
        if ($this->userID) {
            $query = "DELETE FROM cart WHERE UserID = ?";
            if (!$this->db->execute($query, [$this->userID])) {
                $this->lastDbError = $this->db->getLastError();
                error_log("Cart: Failed to clear DB cart for UserID {$this->userID}. Error: " . $this->lastDbError);
                $dbSuccess = false; // Indicate failure
            }
        }
        $this->artworks = [];
        $this->saveToSession(); // This will clear $_SESSION['cart']
        return $dbSuccess;
    }

    public function checkout(): bool
    {
        if (empty($this->artworks)) {
            throw new Exception("Cart is empty. Nothing to checkout.");
        }
        if (!$this->userID) {
            throw new Exception("User must be logged in to checkout.");
        }

        $this->db->beginTransaction();
        try {
            $orderDate = date('Y-m-d H:i:s');
            foreach ($this->artworks as $item) {
                $artworkID = (int)$item['ArtworkID'];
                $quantityToPurchase = (int)$item['Quantity'];

                // Critical section: Verify stock again (preferably with row lock: FOR UPDATE)
                $stockQuery = "SELECT numberInStock, Title FROM artworks WHERE ArtworkID = ? FOR UPDATE"; // Added FOR UPDATE
                $artworkDetails = $this->db->selectSingle($stockQuery, [$artworkID]);

                if (!$artworkDetails || $artworkDetails['numberInStock'] < $quantityToPurchase) {
                    throw new Exception(
                        "Not enough stock for \"" . ($artworkDetails['Title'] ?? "Artwork ID $artworkID") .
                            "\". Available: " . ($artworkDetails['numberInStock'] ?? 0) . ", Requested: $quantityToPurchase"
                    );
                }

                // Record purchase (assuming a 'purchases' table)
                $purchaseQuery = "INSERT INTO purchases (UserID, ArtworkID, Amount, PurchaseDate, PriceAtPurchase)
                  VALUES (?, ?, ?, ?, ?)";

                // Update stock
                $updateStockQuery = "UPDATE artworks SET numberInStock = numberInStock - ? WHERE ArtworkID = ?";
                if (!$this->db->execute($updateStockQuery, [$quantityToPurchase, $artworkID]) || $this->db->getAffectedRows() == 0) {
                    throw new Exception("Failed to update stock for Artwork ID $artworkID. DB Error: " . $this->db->getLastError());
                }
            }

            $this->db->commit();

            // Clear the cart from database and session for this user AFTER successful commit
            $this->clearCart(); // This handles DB removal and session update

            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            $this->lastDbError = $this->db->getLastError() ?: $e->getMessage();
            error_log("Checkout failed for UserID {$this->userID}: " . $e->getMessage() . " - DB Error: " . $this->lastDbError);
            throw $e; // Re-throw the exception to be caught by the calling page
        }
    }

    private function saveToSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Should already be started, but as a safeguard
        }
        // Store as an indexed array in session, consistent with how guest cart might be structured
        $_SESSION['cart'] = $this->listArtworks();
    }

    public function getLastDbError(): ?string
    {
        return $this->lastDbError ?: $this->db->getLastError();
    }
}
