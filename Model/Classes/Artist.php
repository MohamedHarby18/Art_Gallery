<?php
use Model\Classes\users;

class Artist extends User
{
    public string $bio;
    public array $artworks = [];
    public array $galleries = [];
    public function __construct(){
       
    }

    public function addArtwork(Artwork $art): bool 
    {
        return false;
    }

    public function editArtwork(int $artworkID, Artwork $newDetails): bool 
    {
        return false;
    }

    public function deleteArtwork(int $artworkID): bool 
    {
        return false;
    }

    public function editArtGallery(int $galleryID, string $newTheme): bool 
    {
        return false;
    }

    public function setArtGallery(VirtualGallery $gallery): void 
    {
        
    }

    
}