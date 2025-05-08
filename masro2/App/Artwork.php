<?php
namespace App;
use App\Product;

class ArtWork extends Product
{

    public  $Category;
    public  $rate;
    public  $image;
    public  $ArtistID; 

    public function __construct($Title,$Description,$Category,$Price,$rate,$image,$ArtistID)
    {
        parent::__construct($Title,$Description,$Price);
        $this->Category=$Category;
        $this->rate=$rate;
        $this->image=$image;
        $this->ArtistID=$ArtistID;
    }
    
}