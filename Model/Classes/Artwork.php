<?php
require_once '/xampp/htdocs/Art_Gallery/Controller/DBController.php';

class Artwork
{
    private $dbController;
    public int $ArtworkID;
    public string $Title;
    public string $Description;
    public string $Category;
    public int $Price;
    public string $Image;
    public int $ArtistID;
    public string $created_at;
    public int $total_reviews;
    public int $numberinStock;

    public function __construct(
        int $ArtworkID = 0,
        string $Title = '',
        string $Description = '',
        string $Category = '',
        int $Price = 0,
        string $Image = '',
        int $ArtistID = 0,
        string $created_at = '',
        int $total_reviews = 0,
        int $numberinStock = 0
    ) {
        $this->dbController = new DBController();
        $this->ArtworkID = $ArtworkID;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Category = $Category;
        $this->Price = $Price;
        $this->Image = $Image;
        $this->ArtistID = $ArtistID;
        $this->created_at = $created_at;
        $this->total_reviews = $total_reviews;
        $this->numberinStock = $numberinStock;
    }

    public function addArtwork(): bool {
        $query = "INSERT INTO artworks (Title, Description, Category, Price, Image, ArtistID, created_at, total_reviews, numberinStock) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
        $params = [
            $this->Title,
            $this->Description,
            $this->Category,
            $this->Price,
            $this->Image,
            $this->ArtistID,
            $this->total_reviews,
            $this->numberinStock
        ];
        
        $result = $this->dbController->insert($query, $params);
        if ($result !== false) {
            $this->ArtworkID = $result;
            return true;
        }
        return false;
    }

    public function updateArtwork(): bool {
        $query = "UPDATE artworks SET 
                    Title = ?, 
                    Description = ?, 
                    Category = ?, 
                    Price = ?, 
                    Image = ?, 
                    ArtistID = ?, 
                    total_reviews = ?, 
                    numberinStock = ? 
                  WHERE ArtworkID = ?";
        $params = [
            $this->Title,
            $this->Description,
            $this->Category,
            $this->Price,
            $this->Image,
            $this->ArtistID,
            $this->total_reviews,
            $this->numberinStock,
            $this->ArtworkID
        ];
        
        return $this->dbController->execute($query, $params);
    }

    public static function getArtworkById(int $id): ?Artwork {
        $dbController = new DBController();
        $query = "SELECT * FROM artworks WHERE ArtworkID = ?";
        $result = $dbController->select($query, [$id]);
        
        if ($result && count($result) > 0) {
            $artworkData = $result[0];
            return new Artwork(
                $artworkData['ArtworkID'],
                $artworkData['Title'],
                $artworkData['Description'],
                $artworkData['Category'],
                $artworkData['Price'],
                $artworkData['Image'],
                $artworkData['ArtistID'],
                $artworkData['created_at'],
                $artworkData['total_reviews'],
                $artworkData['numberinStock']
            );
        }
        return null;
    }

    public static function getAllArtworks(): array {
        $dbController = new DBController();
        $query = "SELECT * FROM artworks";
        $result = $dbController->select($query);
        
        $artworks = [];
        if ($result) {
            foreach ($result as $artworkData) {
                $artworks[] = new Artwork(
                    $artworkData['ArtworkID'],
                    $artworkData['Title'],
                    $artworkData['Description'],
                    $artworkData['Catagory'],
                    $artworkData['Price'],
                    $artworkData['Image'],
                    $artworkData['ArtistID'],
                    $artworkData['created_at'],
                    $artworkData['total_reviews'],
                    $artworkData['numberInStock']
                );
            }
        }
        return $artworks;
    }

    public function deleteArtwork(): bool {
        $query = "DELETE FROM artworks WHERE ArtworkID = ?";
        return $this->dbController->execute($query, [$this->ArtworkID]);
    }

    // Getters
    public function getArtworkID(): int {
        return $this->ArtworkID;
    }

    public function getTitle(): string {
        return $this->Title;
    }

    public function getDescription(): string {
        return $this->Description;
    }

    public function getCategory(): string {
        return $this->Category;
    }

    public function getPrice(): int {
        return $this->Price;
    }

    public function getImage(): string {
        return $this->Image;
    }

    public function getArtistID(): int {
        return $this->ArtistID;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function getTotalReviews(): int {
        return $this->total_reviews;
    }

    public function getNumberInStock(): int {
        return $this->numberinStock;
    }

    // Setters
    public function setTitle(string $Title): void {
        $this->Title = $Title;
    }

    public function setDescription(string $Description): void {
        $this->Description = $Description;
    }

    public function setCategory(string $Category): void {
        $this->Category = $Category;
    }

    public function setPrice(int $Price): void {
        $this->Price = $Price;
    }

    public function setImage(string $Image): void {
        $this->Image = $Image;
    }

    public function setArtistID(int $ArtistID): void {
        $this->ArtistID = $ArtistID;
    }

    public function setTotalReviews(int $total_reviews): void {
        $this->total_reviews = $total_reviews;
    }

    public function setNumberInStock(int $numberinStock): void {
        $this->numberinStock = $numberinStock;
    }
}
?>