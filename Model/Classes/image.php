<?php
// image.php
require_once '../Controller/DBController.php';
require_once '../Model/Classes/Artwork.php';

$artworkId = $_GET['id'] ?? 0;
$artwork = Artwork::getArtworkById($artworkId);

if ($artwork && $artwork->getImage()) {
    header("Content-type: image/jpg"); // Adjust based on your image type
    echo $artwork->getImage();
    exit;
} else {
    // Fallback to default image
    readfile('../Images/default-artwork.jpg');
}