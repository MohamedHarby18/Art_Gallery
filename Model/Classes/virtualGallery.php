<?php
class VirtualGallery {
    // Properties
    private $id;
    private $title;
    private $description;
    private $theme;
    private $artworks;

    // Constructor
    public function __construct($id, $title, $description, $theme, $artworks = []) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->theme = $theme;
        $this->artworks = $artworks;
    }

    // Method to create the gallery
    public function createGallery() {
        // In this method, you can add code to save the gallery to the database if needed.
        // For now, it just returns true to indicate the gallery is created successfully.
        return true;
    }

    // Method to set gallery information
    public function setInfo($title, $description, $theme) {
        $this->title = $title;
        $this->description = $description;
        $this->theme = $theme;
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function getArtworks() {
        return $this->artworks;
    }

    public function setArtworks($artworks) {
        $this->artworks = $artworks;
    }
}
?>
