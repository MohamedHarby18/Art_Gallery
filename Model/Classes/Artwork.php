<?php

class Artwork
{
    public int $ID;
    public string $Type;
    public int $Price;
    public int $QuantityAvailable;
    public string $Owner;

    public function __construct(int $ID, string $Type, int $Price, int $QuantityAvailable, string $Owner) {
        $this->ID = $ID;
        $this->Type = $Type;
        $this->Price = $Price;
        $this->QuantityAvailable = $QuantityAvailable;
        $this->Owner = $Owner;
    }

    public function addArtwork(): bool {
        return false;
    }

    public function updateArtwork(): bool {
        // Placeholder for updating artwork logic
        return false;
    }

    public function getId(): int {
        return $this->ID;
    }

    public function getType(): string {
        return $this->Type;
    }

    public function getPrice(): int {
        return $this->Price;
    }

    public function getQuantityAvailable(): int {
        return $this->QuantityAvailable;
    }

    public function getOwner(): string {
        return $this->Owner;
    }

    public function setType(string $Type): void {
        $this->Type = $Type;
    }

    public function setPrice(int $Price): void {
        $this->Price = $Price;
    }

    public function setQuantityAvailable(int $Quantity): void {
        $this->QuantityAvailable = $Quantity;
    }

    public function setOwner(string $Owner): void {
        $this->Owner = $Owner;
    }
}
?>
