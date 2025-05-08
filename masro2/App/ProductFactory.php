<?php
namespace App;
abstract class ProductFactory
{
    abstract public function create_Prodcut($product_type,$Title,$Description,$price,$param=[]);
}
    
