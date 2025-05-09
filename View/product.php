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
    <title>Art Gallery - Products</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/global.css" rel="stylesheet">
    <link href="/View/css/product.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar section -->
    <!-- <?php include_once 'partials/navbar.php'; ?> -->

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
                        <h6 class="mb-0">
                            <a href="/">Home</a> 
                            <span class="me-2 ms-2"><i class="fa fa-caret-right"></i></span> 
                            Products
                        </h6>
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
                <div class="col-md-3">
                    <div class="product_1r">
                        <select class="form-select bg_gray col_light" onchange="filterArtworks(this.value)">
                            <option value="">Default Sorting</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="newest">Newest Arrivals</option>
                            <option value="most_reviewed">Most Reviewed</option>
                        </select>
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
                                                <img src="<?php echo htmlspecialchars($artwork['Image'] ?: '/images/default-artwork.jpg'); ?>" 
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
            
            <!-- Pagination -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- <?php include_once 'partials/footer.php'; ?> -->

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script>
    // AJAX for cart/wishlist
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const artworkId = this.getAttribute('data-id');
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: artworkId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Added to cart successfully!');
                    // Optional: Update the UI to reflect the change
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    });

    document.querySelectorAll('.add-to-wishlist').forEach(button => {
        button.addEventListener('click', function() {
            const artworkId = this.getAttribute('data-id');
            fetch('/api/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: artworkId })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Added to wishlist successfully!');
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    });

    function filterArtworks(value) {
        let url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        window.location.href = url.toString();
    }
    </script>
</body>
</html>