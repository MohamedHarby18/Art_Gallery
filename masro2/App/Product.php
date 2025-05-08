<?php

namespace App;

declare(restrict_type=1);
require_once 'App/connection.php';

abstract class Product
{
    public  $ID;
    public  $Title;
    public  $Description;
    public  $price;
    public function __construct($Title,$Description,$price)
    {
        $this->Title=$Title;
        $this->Description=$Description;
        $this->price=$price;
    }

}



