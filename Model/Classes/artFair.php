<?php
class ArtFair {
    public int $ID;
    public string $owner;
    private string $location;

    public function getID(): int {
        return $this->ID;
    }

    public function setID(int $ID): void {
        $this->ID = $ID;
    }

    public function getOwner(): string {
        return $this->owner;
    }

    public function setOwner(string $owner): void {
        $this->owner = $owner;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function setLocation(string $location): bool {
        $this->location = $location;
        return true;
    }
}
