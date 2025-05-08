<?php 

namespace App;

class Cart{
    public $items = null;
    public $cartNo;
    public $userId;
    public static int $count = 10;

    function __construct()
    {
        
    }
    
    function factory()
    {
        return new Cart();
    }
}




