<?php
use Model\Classes\users;

class ArtAdvisor extends User {
    
    public array $assignedRequests = [];

    public function giveRecommendation(string $input): string 
    {
        return '';
    }
}