
<?php 
namespace App;
use App\ArtWork;
use App\ProductFactory;
class ArtworkFactory extends ProductFactory
{
    public function create_Prodcut($product_type, $Title, $Description, $price, $param = [])
    {
            $Category=$param["Category"]??null;
            $image=$param["image"]??null;
            $ArtistID=$param["ArtistID"];
            return new ArtWork($Title,$Description,$Category,$price,0,$image,$ArtistID);
        
    }
}