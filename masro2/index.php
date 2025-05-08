<?php

require __DIR__ . '/mailer/autoload.php';

use App\Customer;
use App\Art;

try {

    $con = require_once('App/connection.php');
} catch (Exception $e) {
    // echo 'Connection failed '. $e->getMessage();
} finally {
    // echo ' connection succed';
}


// Select the special collection of the last 7 days
$specialCollectionResult = $con->query("SELECT a.ArtworkID, a.Title, a.Price, a.Image
FROM artworks AS a
JOIN (
    SELECT pr.product_id
    FROM ProductUserRating AS pr
    JOIN artworks AS a ON pr.product_id = a.ArtworkID
    WHERE pr.rate >= 4 AND a.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    GROUP BY pr.product_id
    ORDER BY MAX(pr.rate) DESC
) AS pr ON a.ArtworkID = pr.product_id;
");
$specialCollectionCount = $specialCollectionResult->num_rows;
$specialCollection = [];
while ($row = $specialCollectionResult->fetch_assoc()) {
    $specialCollection[] = $row;
}
// Select Events

// if(session_status() !== PHP_SESSION_ACTIVE){ 
//     session_start();
// }


$eventQuery = "SELECT * FROM events LIMIT 3;";
$customer;
if (isset($_SESSION["userId"])) {
    $userId = $_SESSION["userId"];


    $userQuery = "SELECT * FROM users WHERE UserID = $userId;";
    $userResult = $con->query($userQuery);
    $user = $userResult->fetch_assoc();


    $customer = new Customer();
    $customer->setAll($user["Fname"], $user["Lanme"], $user["Email"], $user["Password"], $user["phoneNumber"], $user["Address"], $user["City"], $user["Geneder"],);
    $city = $customer->getCity();

    $eventQuery = "SELECT * FROM events WHERE City = '{$city}' LIMIT 3;";
}

$eventsResult = $con->query($eventQuery);
$eventsCount = $eventsResult->num_rows;
$events = [];
while ($row = $eventsResult->fetch_assoc()) {
    $events[] = $row;
}

$artworksResult = $con->query("SELECT * FROM artworks LIMIT 10;");
$artworksCount = $artworksResult->num_rows;
$artworks = [];
while ($row = $artworksResult->fetch_assoc()) {
    $artworks[] = $row;
}
// redirect to 

?>

<?php require_once("./Partials/head.php") ?>

<body class="bg-main">
    <?php require_once("./Partials/Header.php") ?>
    <main>
        <section class="hero -mt-[68px]">
            <div class="hero-slider swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide bg-cover bg-center bg-[url('./Images/hero-bg01.jpg')] relative h-screen">
                        <div class="hero-content absolute h-full transition w-[100%] px-3 lg:w-[50%] xl:w-[40%] flex items-center justify-center flex-col text-center bg-gray-900 mix-blend-hard-light opacity-75 left-0">
                            <h1 class="text-3xl splt md:text-5xl font-bold text-white mb-5 isolate">Welcome to
                                ArtGallery</h1>
                            <p class="text-white splt isolate">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam, voluptates.</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-cover bg-center bg-[url('./Images/hero-bg02.jpg')] h-screen">
                        <div class="hero-content absolute h-full w-[100%] px-3 lg:w-[50%] xl:w-[40%] flex items-center justify-center flex-col text-center bg-gray-900 mix-blend-hard-light opacity-75 left-0">
                            <h1 class="text-3xl splt md:text-5xl font-bold text-white mb-5 isolate">Welcome to
                                ArtGallery</h1>
                            <p class="text-white splt isolate">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam, voluptates.</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-cover bg-center bg-[url('./Images/hero-bg03.jpg')] h-screen">
                        <div class="hero-content absolute h-full w-[100%] px-3 lg:w-[50%] xl:w-[40%] flex items-center justify-center flex-col text-center bg-gray-900 mix-blend-hard-light opacity-75 left-0">
                            <h1 class="text-3xl splt md:text-5xl font-bold text-white mb-5 isolate">Welcome to
                                ArtGallery</h1>
                            <p class="text-white splt isolate">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam, voluptates.</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-cover bg-center bg-[url('./Images/hero-bg04.jpg')] h-screen">
                        <div class="hero-content absolute h-full w-[100%] px-3 lg:w-[50%] xl:w-[40%] flex items-center justify-center flex-col text-center bg-gray-900 mix-blend-hard-light opacity-75 left-0">
                            <h1 class="text-3xl splt md:text-5xl font-bold text-white mb-5 isolate">Welcome to
                                ArtGallery</h1>
                            <p class="text-white splt isolate">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam, voluptates.</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-cover bg-center bg-[url('./Images/hero-bg05.jpg')] h-screen">
                        <div class="hero-content absolute h-full w-[100%] px-3 lg:w-[50%] xl:w-[40%] flex items-center justify-center flex-col text-center bg-gray-900 mix-blend-hard-light opacity-75 left-0">
                            <h1 class="text-3xl splt md:text-5xl font-bold text-white mb-5 isolate">Welcome to
                                ArtGallery</h1>
                            <p class="text-white splt isolate">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quisquam, voluptates.</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </section>
        <?php if ($specialCollectionCount !== 0) : ?>
            <section class="best-collection py-16 ">
                <div class="container">
                    <h2 class="font-bold text-gray-950 mb-8 text-2xl md:text-3xl">Special Collection For You</h2>
                    <div class="shop-slider swiper text-center mySwiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($specialCollection as $product) : ?>
                                <div class="swiper-slide">
                                    <div class="product">
                                        <div class="product-image overflow-hidden">
                                            <img class="hover:scale-110 hover:rotate-6 transition object-cover w-full h-full" src="./Images/artworks/<?= $product['Image'] ?>" alt="<?php echo $product['Title'] ?>">
                                        </div>
                                        <div class="product-content">
                                            <h3 class="product-title mt-2 text-xl font-bold text-gray-900">
                                                <?php echo $product['Title'] ?></h3>
                                            <p class="product-price my-3 font-bold text-gray-800">
                                                $<?php echo $product['Price'] ?></p>
                                            <a href="./Pages/ProductPreview.php?product_id=<?php echo $product['ArtworkID'] ?>" class="btn py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold ">View</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <a class="go-to transition overflow-hidden hover:text-white isolate relative block my-10 bg-transparent border-2 border-gray-900 text-gray-900 font-bold text-sm rounded-lg w-fit px-10 py-3 mx-auto text-center" href="/art_gallery/Pages/products.php">Go to Shop</a>
                </div>
            </section>
        <?php endif; ?>
        <?php if ($eventsCount !== 0) : ?>
            <section class="events py-16">
                <div class="container">
                    <h2 class="font-bold text-gray-950 mb-8 text-2xl md:text-3xl">Events</h2>

                    <div class="">
                        <?php foreach ($events as $event) : ?>
                            <!-- <?php var_dump($event); ?> -->
                            <div class="border-b-2 border-b-gray-950 flex gap-8 lg:gap-14  flex-col-reverse md:flex-row justify-between items-center py-14">
                                <div class="info w-10/12">
                                    <h3 class="font-bold text-gray-900 text-xl"><?= $event["Title"] ?></h3>
                                    <div class="flex items-center justify-between font-bold text-gray-500 text-sm">
                                        <h4>City: <?= $event["City"] ?></h4>
                                        <p><?= $event["Date"] ?></p>
                                    </div>
                                    <p class="text-gray-500 my-6 font-bold"><?= $event["Description"] ?></p>

                                    <a href="./Pages/event.php?event_id=<?php echo $event['EventID'] ?>" class="btn mx-auto md:mx-0 w-fit py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold ">Details</a>
                                </div>
                                <div class="img">
                                    <img class="object-cover w-full" src="Images/events/<?= $event["Image"] ?>" alt="" />
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="go-to transition overflow-hidden hover:text-white isolate relative block my-10 bg-transparent border-2 border-gray-900 text-gray-900 font-bold text-sm rounded-lg w-fit px-10 py-3 mx-auto text-center" href="/art_gallery/Pages/events.php">Go to Events</a>

                </div>
            </section>
        <?php endif; ?>
        <section class="refferal py-16 bg-cover bg-center bg-[url('./Images/refferal-image.jpg')]" id="ref">
            <div class="container">
                <div class="w-1/2 text-white">
                    <h2 class="font-bold text-2xl md:text-3xl">Refer a friend for winning a coupon</h2>
                    <p class="my-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa nisi assumenda quis,
                        ab alias dolor iure corporis minus quia non.</p>
                    <form action="App/testmail.php" method="post">
                        <input type="email" placeholder="Enter your email" class="w-full py-2 px-4 rounded-lg my-4 text-black" require name="emailrefer" />
                        <input type="submit" value="Submit" class="btn py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold " name="refer">
                        <p class="text-red-500 text-xs italic"><?php
                                                                if (isset($_SESSION['refermsg'])) {
                                                                    echo $_SESSION['refermsg'];
                                                                    unset($_SESSION['refermsg']);
                                                                }
                                                                ?></p>
                    </form>
                </div>
            </div>
        </section>
        <?php if ($artworksCount !== 0) : ?>
            <section class="shop py-16 ">
                <div class="container">
                    <h2 class="font-bold text-gray-950 mb-8 text-2xl md:text-3xl">Shop</h2>
                    <div class="shop-slider swiper text-center mySwiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($artworks as $product) : ?>
                                <div class="swiper-slide">
                                    <div class="product">
                                        <div class="product-image overflow-hidden">
                                            <img class="hover:scale-110 hover:rotate-6 transition object-cover w-full h-full" src="./Images/artworks/<?= $product['Image'] ?>" alt="<?php echo $product['Title'] ?>">
                                        </div>
                                        <div class="product-content">
                                            <h3 class="product-title mt-2 text-xl font-bold text-gray-900">
                                                <?php echo $product['Title'] ?></h3>
                                            <p class="product-price my-3 font-bold text-gray-800">
                                                $<?php echo $product['Price'] ?></p>
                                            <a href="./Pages/ProductPreview.php?product_id=<?php echo $product['ArtworkID'] ?>" class="btn py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold ">View</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <a class="go-to transition overflow-hidden hover:text-white isolate relative block my-10 bg-transparent border-2 border-gray-900 text-gray-900 font-bold text-sm rounded-lg w-fit px-10 py-3 mx-auto text-center" href="/art_gallery/Pages/products.php">Go to Shop</a>

                </div>
            </section>
        <?php endif; ?>

    </main>

    <?php require_once("./Partials/Footer.php") ?>
    <?php require_once("./Partials/scripts.php") ?>
    <script src="./JS/home.js"></script>

</body>

</html>