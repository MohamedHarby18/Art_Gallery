<?php
class Cart{
    public $artworks = [];
    public $cartID;
    public $userID;

    public function __construct($cartID = null, $userID = null) {
        $this->cartID = $cartID;
        $this->userID = $userID;
    }

}