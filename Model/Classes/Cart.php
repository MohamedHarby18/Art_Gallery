<?php
class Cart {
    public $artworks = [];
    public $cartID;
    public $userID;

    public function __construct($cartID = null, $userID = null) {
        $this->cartID = $cartID;
        $this->userID = $userID;
    }

    public function addArtwork($artwork) {
        $this->artworks[] = $artwork;
    }

    public function removeArtwork($artworkID) {
        foreach ($this->artworks as $index => $artwork) {
            if ($artwork['id'] == $artworkID) {
                unset($this->artworks[$index]);
                $this->artworks = array_values($this->artworks); // Re-index the array
                return true;
            }
        }
        return false;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->artworks as $artwork) {
            $total += $artwork['price'];
        }
        return $total;
    }

    public function listArtworks() {
        return $this->artworks;
    }

    public function clearCart() {
        $this->artworks = [];
    }
}
