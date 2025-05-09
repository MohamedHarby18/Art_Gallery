<?php
// Enable error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base paths
define('BASE_DIR', __DIR__);
define('APP_ROOT', dirname(BASE_DIR));

// Database Connection and Artwork handling
try {
    $dbPath = APP_ROOT . '/Controller/DBController.php';
    $artworkPath = APP_ROOT . '/Model/Classes/Artwork.php';

    if (!file_exists($dbPath)) {
        throw new Exception("DBController not found at: $dbPath");
    }
    if (!file_exists($artworkPath)) {
        throw new Exception("Artwork class not found at: $artworkPath");
    }

    require_once $dbPath;
    require_once $artworkPath;

    // Get artworks using the Artwork class
    $artworks = Artwork::getAllArtworks();

    // Convert Artwork objects to array for compatibility with existing view code
    $artworksArray = [];
    foreach ($artworks as $artwork) {
        $artworksArray[] = [
            'ArtworkID' => $artwork->getArtworkID(),
            'Title' => $artwork->getTitle(),
            'Description' => $artwork->getDescription(),
            'Category' => $artwork->getCategory(),
            'Price' => $artwork->getPrice(),
            'Image' => $artwork->getImage(),
            'ArtistID' => $artwork->getArtistID(),
            'created_at' => $artwork->getCreatedAt(),
            'total_reviews' => $artwork->getTotalReviews(),
            'numberinStock' => $artwork->getNumberInStock(),
            'average_rating' => $artwork->getTotalReviews() > 0 ?
                min(5, max(0, $artwork->getTotalReviews() / 20)) : 4.5 // Example rating calculation
        ];
    }
} catch (Exception $e) {
    die("<div class='alert alert-danger'>System Error: " . htmlspecialchars($e->getMessage()) . "</div>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/product.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <section id="center" class="center_o bg_gray pt-2 pb-2">
        <div class="container-xl">
            <div class="row center_o1">
                <div class="col-md-5">
                    <div class="center_o1l">
                        <h2 class="mb-0">Our Art Collection</h2>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="center_o1r text-end">
                        <h6 class="mb-0"><a href="index.php">Home</a> <span class="me-2 ms-2"><i
                                    class="fa fa-caret-right"></i></span> Products</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="product" class="p_4">
        <div class="container-xl">
            <div class="row product_1">
                <div class="col-md-9">
                    <div class="product_1l">
                        <p class="mb-0 mt-2">
                            Showing <?php echo count($artworksArray) > 0 ? '1' : '0'; ?>–<?php echo count($artworksArray); ?> of <?php echo count($artworksArray); ?> results
                        </p>
                    </div>
                </div>
            </div>

            <div class="row product_2 mt-4">
                <?php if (!empty($artworksArray)): ?>
                    <?php foreach ($artworksArray as $artwork): ?>
                        <div class="col-md-3 mb-4">
                            <div class="prod_main p-1 bg-white clearfix h-100">
                                <div class="product_2im clearfix position-relative">
                                    <div class="product_2imi clearfix">
                                        <div class="grid clearfix">
                                            <figure class="effect-jazz mb-0">
                                                <a href="/artwork/<?php echo htmlspecialchars($artwork['ArtworkID']); ?>">
                                                    <img src="../Images/artworks/<?php echo htmlspecialchars($artwork['Image']); ?>"
                                                        class="w-100"
                                                        alt="<?php echo htmlspecialchars($artwork['Title']); ?>"
                                                        loading="lazy">
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="product_2imi1 position-absolute clearfix w-100 top-0 text-center">
                                        <ul class="mb-0">
                                            <?php if ($artwork['numberinStock'] > 0): ?>
                                                <li class="d-inline-block">
                                                    <a class="bg_pink text-white d-block add-to-cart"
                                                        data-id="<?php echo htmlspecialchars($artwork['ArtworkID']); ?>">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li class="d-inline-block">
                                                <a class="bg_pink text-white d-block add-to-wishlist"
                                                    data-id="<?php echo htmlspecialchars($artwork['ArtworkID']); ?>">
                                                    <i class="fa fa-heart-o"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php if ($artwork['numberinStock'] <= 0): ?>
                                        <div class="sold-out-overlay">
                                            <span>Sold Out</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="product_2im1 position-relative clearfix">
                                    <div class="clearfix product_2im1i text-center pt-3 pb-4">
                                        <h5 class="font_14 text-uppercase">
                                            <a class="col_dark" href="/artwork/<?php echo htmlspecialchars($artwork['ArtworkID']); ?>">
                                                <?php echo htmlspecialchars($artwork['Title']); ?>
                                            </a>
                                        </h5>
                                        <p class="font_12 text-muted mb-1"><?php echo htmlspecialchars($artwork['Category']); ?></p>
                                        <span class="font_12 col_yell">
                                            <?php
                                            $rating = $artwork['average_rating'] ?? 0;
                                            $fullStars = floor($rating);
                                            $hasHalfStar = ($rating - $fullStars) >= 0.5;

                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $fullStars) {
                                                    echo '<i class="fa fa-star"></i>';
                                                } elseif ($i == $fullStars + 1 && $hasHalfStar) {
                                                    echo '<i class="fa fa-star-half-o"></i>';
                                                } else {
                                                    echo '<i class="fa fa-star-o"></i>';
                                                }
                                            }
                                            ?>
                                            <small class="text-muted">(<?php echo $artwork['total_reviews']; ?>)</small>
                                        </span>
                                        <h6 class="col_dark mt-2 mb-0">
                                            $<?php echo number_format($artwork['Price'], 2); ?>
                                            <?php if ($artwork['numberinStock'] > 0): ?>
                                                <small class="text-success">(<?php echo $artwork['numberinStock']; ?> in stock)</small>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <h4>No artworks found</h4>
                        <p>Please check back later or explore our other collections</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="footer" class="pt-3 pb-3">
        <div class="container-fluid">
            <div class="row footer_1">
                <div class="col-md-3">
                    <div class="footer_1i">
                        <hr class="line_1">
                        <h5 class="mb-3">ABOUT</h5>
                        <p>Phasellus et nisl tellus. Etiam facilisis eu nisi scelerisque faucibus. Proin semper suscipit
                            magna, nec imperdiet lacus semper vitae. Sed hendrerit enim non justo posuere placerat eget
                            purus mauris.</p>
                        <p>Etiam facilisis eu nisi scelerisque faucibus. Proin semper suscipit magna, nec imperdiet
                            lacus semper.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer_1i">
                        <hr class="line_1">
                        <h5 class="mb-3">RECENT WORKS</h5>
                        <div class="footer_1i1 row">
                            <div class="col-md-4 col-4 p-0">
                                <div class="footer_1i1i">
                                    <div class="grid clearfix">
                                        <figure class="effect-jazz mb-0">
                                            <a href="#"><img src="img/30.jpg" class="w-100" alt="abc"></a>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer_1i1 row">
                            <div class="col-md-4 col-4 p-0">
                                <div class="footer_1i1i">
                                    <div class="grid clearfix">
                                        <figure class="effect-jazz mb-0">
                                            <a href="#"><img src="img/33.jpg" class="w-100" alt="abc"></a>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-4 p-0">
                                <div class="footer_1i1i">
                                    <div class="grid clearfix">
                                        <figure class="effect-jazz mb-0">
                                            <a href="#"><img src="img/34.jpg" class="w-100" alt="abc"></a>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-4 p-0">
                                <div class="footer_1i1i">
                                    <div class="grid clearfix">
                                        <figure class="effect-jazz mb-0">
                                            <a href="#"><img src="img/35.jpg" class="w-100" alt="abc"></a>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer_1i">
                        <hr class="line_1">
                        <h5 class="mb-3">TAG CLOUD</h5>
                        <ul class="mb-0">
                            <li class="d-inline-block"><a class="d-block" href="#">Analyze</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Audio</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Blog</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Business</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Creative</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Design</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Experiment</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">News</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Expertize</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Express</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Share</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Sustain</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Video</a></li>
                            <li class="d-inline-block"><a class="d-block" href="#">Youtube</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer_1i">
                        <hr class="line_1">
                        <h5 class="mb-3">RECENT NEWS</h5>
                        <p class="font_14 mb-2"><a href="#">INTEGER AT DIAM GRAVIDA FRINGILLA NIBH PRETI PURUS</a></p>
                        <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> May 18 <a
                                class="col_light" href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
                        <hr>
                        <p class="font_14 mb-2"><a href="#">DONEC QUIS EX VEL TINCIDUNT</a></p>
                        <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> July 19 <a
                                class="col_light" href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
                        <hr>
                        <p class="font_14 mb-2"><a href="#">PRAESENT IACULIS TORTOR VIVERRA</a></p>
                        <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> June 17 <a
                                class="col_light" href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
                    </div>
                </div>
            </div>
            <div class="row footer_2 mt-4 text-center">
                <div class="col-md-12">
                    <ul>
                        <li class="d-inline-block me-3 font_14"><a href="#">CONTACT</a></li>
                        <li class="d-inline-block me-3 font_14"><a href="#">PRIVACY POLICY</a></li>
                        <li class="d-inline-block me-3 font_14"><a href="#">TERMS OF USE</a></li>
                        <li class="d-inline-block font_14"><a href="#">FAQ</a></li>
                    </ul>
                    <p class="mb-0">© 2013 Your Website Name. All Rights Reserved | Design by <a class="col_pink"
                            href="http://www.templateonweb.com">TemplateOnWeb</a></p>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Update the cart AJAX code in product.php
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const artworkId = this.getAttribute('data-id');

                fetch('../Model/Classes/add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `artwork_id=${artworkId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count in navbar if exists
                            const cartCount = document.querySelector('.cart-count');
                            if (cartCount) {
                                const currentCount = parseInt(cartCount.textContent) || 0;
                                cartCount.textContent = currentCount + 1;
                            }

                            // Show feedback to user
                            alert('Item added to cart!');
                        } else {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                alert('Error: ' + data.message);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while adding to cart');
                    });
            });
        });
    </script>

</body>

</html>