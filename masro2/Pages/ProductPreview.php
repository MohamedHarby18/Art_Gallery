<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$base = $root . '/art_Gallery';
require $base . '/vendor/autoload.php';
if(!isset($_SESSION['userId']) && !isset($_COOKIE['userid']))
{
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html>
<?php require_once '../Partials/head.php'; ?>

<body>
    <?php require_once '../Partials/Header.php'; ?>
    <?php
    require_once '../App/connection.php';
   
    $userid = isset($_SESSION['userId']) ? $_SESSION['userId'] : $_COOKIE['userid'];
    $product_id = $_GET['product_id'];

    $result = mysqli_query($con, "select * from `artworks` WHERE ArtworkID=$product_id");
    $row = mysqli_fetch_assoc($result);
    $Title = $row['Title'];
    $Description = $row['Description'];
    $price = $row['Price'];
    $Category = $row['Catagory'];
    $image = $row['Image'];
    $totalReview = $row['total_reviews'];
    $artistId = mysqli_query($con, "SELECT ArtistID FROM `artworks`where ArtworkID=$product_id");
    $row = mysqli_fetch_assoc($artistId);

    $ID = $row['ArtistID'];

    // Query to get artist name
    $artistQuery = "SELECT Fname FROM users WHERE UserID = $ID AND Artist = 1 AND Advisor = 0";
    $artistResult = mysqli_query($con, $artistQuery);

    $Artist = "Unknown Artist"; // Default value

    if ($artistResult && ($artistRow = mysqli_fetch_assoc($artistResult))) {
        // Check if $artistRow is not null before accessing its elements
        if (isset($artistRow['Fname'])) {
            $Artist = $artistRow['Fname'];
        }
    }

    // getting average rating
    $ratingQuery = "SELECT AVG(rate) as avg FROM ProductUserRating WHERE product_id = $product_id";
    $ratingResult = mysqli_query($con, $ratingQuery);
    $ratingRow = mysqli_fetch_assoc($ratingResult);
    $rating = $ratingRow['avg'];
    $rating = number_format((float)$rating, 1);





    ?>
    <main class="bg-main">
        <section class="text-gray-700 body-font overflow-hidden ">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-4/5 mx-auto flex flex-wrap">
                    <img alt="ecommerce" class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200" src="../Images/artworks/<?= $image ?>">
                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">Artwork NAME</h2>
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1"><?= $Title ?> </h1>
                        <h2 class="text-sm title-font text-gray-500 tracking-widest">BY:<?= $Artist ?></h2>
                        <div class="flex mb-4">
                            <span class="flex items-center">
                                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-gray-800" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                                <span class="text-gray-600 ml-3"><span><?= $rating ?></span></span>
                                <span class="text-gray-800 ml-3"><?= $totalReview ?> Reviews</span>

                            </span>

                        </div>
                        <p class="leading-relaxed"><?= $Description ?></p>
                        <div class="flex">
                            <span class="title-font font-medium text-2xl text-gray-800">$<?= $price ?></span>

                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value=<?= $product_id ?>>
                                <input type="hidden" name="user_id" value=<?= $userid ?> >
                                <input class="rounded border appearance-none border-gray-400 py-2 focus:outline-none focus:border-red-500 text-base pl-3 pr-10" type="number" value="1" min="1" max="10" name="quantity"> 
                                <input type="submit" value="Add To Cart">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- rating  -->
        <form action="update_rating.php" method="POST" class="container flex items-center space-x-4">
            <input type="range" min="1" max="5" value="0" name="rating" class="text-gray-800 appearance-none w-64 h-4 rounded-lg bg-gray-200 outline-none">
            <input type="hidden" value="<?= $product_id ?>" name="product_id">
            <input type="hidden" value="<?= $userId ?>" name="user_id">
            <input type="submit" value="Submit Rating" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 cursor-pointer">
        </form>


        <!-- <h3 class="Related-products-head">
        Related Products
    </h3>
    <div class="related-products">
        <?php
        $result = mysqli_query($con, "SELECT * FROM `artworks` WHERE `Catagory` LIKE '$Category' ");
        while ($row = mysqli_fetch_assoc($result)) {
            $PID = $row['ArtworkID'];
            $Title = $row['Title'];
            $Description = $row['Description'];
            $Category = $row['Catagory'];
            $price = $row['Price'];
            $image = $row['Image'];
            $ArtistID = $row['ArtistID'];
            // Query to get artist name
            $artistQuery = "SELECT Fname FROM users WHERE UserID = $ArtistID AND Artist = 1 AND Advisor = 0";
            $artistResult = mysqli_query($con, $artistQuery);

            // Check if the artist query was successful
            if ($artistResult) {
                $artistRow = mysqli_fetch_assoc($artistResult);
                $Artist = $artistRow['Fname'];
            } else {
                // Handle error if artist query fails
                $Artist = "Unknown Artist";
            }

            // html devs will be in side this echo '';

            echo <<<END
            
                <div class = 'product-details'> 
                    <div class='Product'>
                        <img src='../Images/artworks/$image'alt='unavailable'>
                            <div class='Product-body'>
                                <h5 class ='Product-title'> $Title </h5>
                                <p class = 'Product-text'> $Description </p>
                                <P class = 'Product-Price' > $price </p>
                                <p class = 'Artist-name'> $Artist</p>
                                <a href='ProductPreview.php?product_id=$PID'>Preview</a>
                            </div>
                    </div>
                </div> 
            END;
        }
        ?>

    </div> -->

        <h3 class="Egift-header">
            Buy an Egift
        </h3>

        <div class="Egift-Section">

            <!-- 
            Egift here not displayed from DB but there's an Avialable Egift in our art_gallery
            10% -> discount
            20% -> discount 
            30% -> discount
            only avialable discounts in the Egift cards 
            
            -->
            <?php








            ?>
        </div>
    </main>
    <?php require_once '../Partials/Footer.php'; ?>
    <?php require_once '../Partials/Scripts.php'; ?>
</body>

</html>