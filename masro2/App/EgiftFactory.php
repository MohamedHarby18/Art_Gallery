<?php
namespace App;
use App\Egift;
use App\ProductFactory;

class EgiftFactory extends ProductFactory
{
    public function create_Prodcut($product_type, $Title, $Description, $price, $param = [])
    {
        $code=$param["code"]??null;
        $value=$param["value"]??null;
        $RecipientEmail=$param["RecipientEmail"]??null;
        return new Egift($code,$value,$Title,$Description,$RecipientEmail,$price);
    }
}