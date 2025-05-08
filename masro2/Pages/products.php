<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$base = $root . '/art_gallery';
require $base . '/vendor/autoload.php';
require_once '../App/connection.php';

use App\Cart;
use App\Art;
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * 
    FROM artworks AS a 
    LEFT OUTER JOIN productuserrating AS pr 
    ON a.ArtworkID = pr.product_id 
    WHERE CONCAT(a.Title, a.Description, a.Catagory) LIKE '%$search%'";
    
    $res = mysqli_query($con, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once '../Partials/head.php'; ?>

<body>
    <?php require_once '../Partials/Header.php'; ?>
    <!-- post -->
    <!-- <div data-elementor-type="wp-post" data-elementor-id="3125" class="outer-con">
        <div class="inner-con">
            <div class="e-con-inner">
                <div clas="">
                    <div class="widget-container">
                        <div >
                            <ol >
                                <li>
                                    <a href="../index.php" class="internal-link">
                                        <span itemprop="name">Main Home</span></a>
                                        
                                </li>
                                <span class="delimiter">/</span>
                                <li >
                                    <span itemprop="name">Shop</span>
                                   
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <main class="bg-main py-20">
        <div class="catagories container ">

            <div class="flex flex-wrap gap-6 mb-6">
                <div class="flex-1">
                    <p class="text-lg font-semibold mb-2">Categories</p>
                    <div class="flex items-center mb-2">
                        <div class="relative flex cursor-pointer items-center rounded-full">
                            <input type="checkbox" id="Typography" name="Typography" class="form-checkbox before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-700 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-gray-800 checked:bg-gray-800 checked:before:bg-gray-800 hover:before:opacity-10">
                            <div class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <label for="Typography" class="ml-2 text-gray-700">Typography</label>
                    </div>
                    <div class="flex items-center mb-2">
                        <div class="relative flex cursor-pointer items-center rounded-full">
                            <input type="checkbox" id="Posters" name="Posters" class="form-checkbox before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-700 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-gray-800 checked:bg-gray-800 checked:before:bg-gray-800 hover:before:opacity-10">
                            <div class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <label for="Posters" class="ml-2 text-gray-700">Posters</label>
                    </div>
                    <div class="flex items-center mb-2">
                        <div class="relative flex cursor-pointer items-center rounded-full">
                            <input type="checkbox" id="Painting" name="Painting" class="form-checkbox before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-700 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-gray-800 checked:bg-gray-800 checked:before:bg-gray-800 hover:before:opacity-10">
                            <div class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <label for="Painting" class="ml-2 text-gray-700">Painting</label>
                    </div>

                </div>
                <div class="flex-1 flex items-center justify-between gap-5">
                    <?php
                    $query = "SELECT MAX(Price) AS max_price FROM artworks";
                    $result = mysqli_query($con, $query);
                    $maxPrice;
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);

                        $maxPrice = $row['max_price'];
                    } else {
                        $maxPrice = 0;
                    }
                    $maxPrice = (int) ceil($maxPrice);
                    ?>
                    <span>0</span>
                    <div class="range-slider">
                        <input value="<?= $maxPrice ?>" min="0" max="<?= $maxPrice ?>" step="1" type="range" />
                        <input value="0" min="0" max="<?= $maxPrice ?>" step="1" type="range" />
                    </div>
                    <span><?= $maxPrice ?></span>
                </div>
            </div>
            <form class="max-w-md mx-auto" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input name="search" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Mockups, Logos..." required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div>






        <?php

        if (isset($_GET['search'])) {
            if (mysqli_num_rows($res) == 0) {
        ?>
                <h2>NO RESULT FOUND</h2>
            <?php
            }
            ?>
            <div class="container flex gap-20 p-10">
                <?php
                while ($roww = mysqli_fetch_assoc($res)) {
                    if($roww['rate'] === null)  
                        $roww['rate'] = 0;
                    $art = new Art($roww['ArtworkID'],$roww['Title'],$roww['Description'],$roww['Image'],$roww['Catagory'],$roww['Price'],$roww['rate']);
                ?>
                    <div class="product w-1/4">
                        <div class="product-image overflow-hidden">
                            <img class="hover:scale-110 hover:rotate-6 transition object-cover w-full h-full" src="../Images/artworks/<?= $art->getImage(); ?>" alt="<?php $art->getTitle() ?>">
                        </div>
                        <div class="product-content">
                            <h3 class="product-title mt-2 text-xl font-bold text-gray-900">
                                <?php echo $art->getTitle(); ?></h3>
                            <p class="product-price my-3 font-bold text-gray-800">
                                $<?php echo $art->getPrice(); ?></p>
                            <a href="ProductPreview.php?id=<?php echo $art->getID(); ?>" class="btn py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold ">View</a>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        <?php
        } else {

            require_once '../App/connection.php';


            $sqlquery = "SELECT * 
            FROM artworks AS a 
            LEFT OUTER JOIN productuserrating AS pr 
            ON a.ArtworkID = pr.product_id ";;

            // first method to excute sql query 

            $result = mysqli_query($con, $sqlquery);
            $artworks = [];
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['rate'] === null)
                    $row['rate'] = 0;
                $art = new Art($row['ArtworkID'],$row['Title'],$row['Description'],$row['Image'],$row['Catagory'],$row['Price'],$row['rate']);
                // $PID = $row['ArtworkID'];
                // $Title = $row['Title'];
                // $Description = $row['Description'];
                // $Category = $row['Catagory'];
                // $price = $row['Price'];
                // $image = $row['Image'];
                $ArtistID = $row['ArtistID'];
                $CreatedDate = $row['created_at'];
                // Query to get artist name
                $artistQuery = "SELECT Fname FROM users WHERE UserID = $ArtistID AND Artist = 1 AND Advisor = 0";
                $artistResult = mysqli_query($con, $artistQuery);

                // Check if the artist query was successful;
                $Artist;
                if ($artistResult) {
                    $artistRow = mysqli_fetch_assoc($artistResult);

                    if ($artistRow === null) {
                        $Artist = "Unknown Artist";
                    } else {
                        $Artist = $artistRow['Fname'];
                    }
                } else {
                    // Handle error if artist query fails
                    $Artist = "Unknown Artist";
                }
                // var_dump($Artist);
                $artwork = [
                    'ArtworkID' => $art->getID(),
                    'Title' => $art->getTitle(),
                    'Description' => $art->getDescription(),
                    'Category' => $art->getCategory(),
                    'Price' => $art->getPrice(),
                    'Image' => $art->getImage(),
                    'ArtistID' => $ArtistID,
                    'CreatedDate' => $CreatedDate,
                    'Artist' => $Artist
                ];


                $artworks[] = $artwork;
            }
        
        ?>

        <div class="container">
            <div class="py-16 flex flex-wrap items-center gap-5 sm:gap-10 md:gap-5 xl:gap-10">
                <?php foreach ($artworks as $artwork) : ?>
                    <div data-price="<?= $artwork['Price'] ?>" data-category="<?= $artwork["Category"] ?>" class="product basis-[calc(50%-10px)] sm:basis-[calc(50%-20px)] md:basis-[calc(33.33333%-20px)] lg:basis-[calc(25%-20px)] xl:basis-[calc(25%-30px)]">
                        <div class="product-image overflow-hidden">
                            <img class="hover:scale-110 hover:rotate-6 transition object-cover w-full h-full" src="../Images/artworks/<?= $artwork['Image'] ?>" alt="<?php echo $artwork['Title'] ?>">
                        </div>
                        <div class="product-content">
                            <h3 class="product-title mt-2 text-lg whitespace-nowrap overflow-ellipsis sm:text-xl font-bold text-gray-900">
                                <?php echo $artwork['Title'] ?></h3>
                            <p  class="product-price my-3 font-bold text-gray-800">
                                $<?php echo $artwork['Price'] ?></p>
                            <a href="/art_gallery/Pages/ProductPreview.php?product_id=<?php echo $artwork['ArtworkID'] ?>" class="btn py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold ">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        }
        ?>
        <a href=""></a>
    </main>
    <?php require_once '../Partials/Footer.php'; ?>
    <?php require_once '../Partials/Scripts.php'; ?>
    <script src="../JS/product.js"></script>
</body>

</html>