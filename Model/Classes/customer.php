<?php
use Model\Classes\users;

class Customer extends User
{
    public string $address;
    public array $discounts = [];  
    
    public function __construct()
    {
        parent::__construct();  
    }


    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function addDiscount($discount): void
    {
        $this->discounts[] = $discount; 
    }

    public function addToFavorite(int $artID): bool
    {
        return false;  
    }

    public function addToCollections(int $artID): bool
    {
        return false;  
    }

    public function requestRecommendation(): string
    {
        return '';  
    }

    public function sendFeedback(int $artID, string $text, int $userID): void
    {
        // Method implementation
    }

    public function writeComment(string $comment): void
    {
        // Method implementation
    }
}