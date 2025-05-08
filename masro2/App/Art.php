<?php

namespace App;

class Art{

    private int $ID;

    private string $Title;

    private string $Description;

    private string $Image;

    private string $Category;
    private float $price;
    private  float $rate;

    public function __construct($ID, $Title, $Description, $Image, $Category, $price, $rate=0)
    {
        $this->ID = $ID;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Image = $Image;
        $this->Category = $Category;
        $this->price = $price;
        $this->rate = $rate;
    }

    // Getters
    public function getID(): int {
        return $this->ID;
    }

    public function getTitle(): string {
        return $this->Title;
    }

    public function getDescription(): string {
        return $this->Description;
    }

    public function getImage(): string {
        return $this->Image;
    }

    public function getCategory(): string {
        return $this->Category;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getRate() {
        return $this->rate;
    }

    // Setters
    public function setID(int $ID) {
        $this->ID = $ID;
    }

    public function setTitle(string $Title) {
        $this->Title = $Title;
    }

    public function setDescription(string $Description) {
        $this->Description = $Description;
    }

    public function setImage(string $Image) {
        $this->Image = $Image;
    }

    public function setCategory(string $Category) {
        $this->Category = $Category;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setRate($rate) {
        $this->rate = $rate;
    }


}

