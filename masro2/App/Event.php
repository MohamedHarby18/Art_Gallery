<?php
namespace App;
use DateTime;
class Event{
    private int $Id;
    private string $Title;
    private string $Description;
    private string $Location;
    private DateTime $DateTime;
    private string $City;
    private string $Image;
    private int $ArtistId;

    public function __construct(int $Id, string $Title, string $Description, string $Location, DateTime $DateTime, string $City, string $Image, int $ArtistId)
    {
        $this->Id = $Id;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Location = $Location;
        $this->DateTime = $DateTime;
        $this->City = $City;
        $this->Image = $Image;
        $this->ArtistId = $ArtistId;
    }

    public function getId(): int
    {
        return $this->Id;
    }

    public function getTitle(): string
    {
        return $this->Title;
    }

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function getLocation(): string
    {
        return $this->Location;
    }

    public function getDateTime(): DateTime
    {
        return $this->DateTime;
    }

    public function getCity(): string
    {
        return $this->City;
    }

    public function getImage(): string
    {
        return $this->Image;
    }

    public function getArtistId(): int
    {
        return $this->ArtistId;
    }
}