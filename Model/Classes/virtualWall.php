<?php

class VirtualGalleryWall
{
    public string $color;
    public float $width;
    public float $highet;

    // Constructor
    public function __construct(string $color = '', float $width = 0.0, float $highet = 0.0) {
        $this->color = $color;
        $this->width = $width;
        $this->highet = $highet;
    }

    // Set the color of the wall
    public function setColor(string $color): void {
        $this->color = $color;
    }

    // Set the width of the wall
    public function setWidth(float $width): void {
        $this->width = $width;
    }

    // Set the height of the wall
    public function setHighet(float $highet): void {
        $this->highet = $highet;
    }

    // Optional getters
    public function getColor(): string {
        return $this->color;
    }

    public function getWidth(): float {
        return $this->width;
    }

    public function getHighet(): float {
        return $this->highet;
    }
}
?>
