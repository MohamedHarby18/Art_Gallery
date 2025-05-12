<?php
// Enable error reporting (remove/adjust for production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Controller/DBController.php';
require_once __DIR__ . '/../Model/Classes/Artwork.php';

// Initialize filter variables from GET parameters
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$priceMinFilter = isset($_GET['price_min']) ? floatval($_GET['price_min']) : null;
$priceMaxFilter = isset($_GET['price_max']) ? floatval($_GET['price_max']) : null;
$inStockFilter = isset($_GET['in_stock']) ? true : false;

$artworksObjects = []; // Initialize
$allArtworks = []; // Store all artworks for filter options
try {
    // Get all artworks first
    $allArtworks = Artwork::getAllArtworks();
    
    // Apply filters if any are set
    $artworksObjects = array_filter($allArtworks, function($artwork) use ($categoryFilter, $priceMinFilter, $priceMaxFilter, $inStockFilter) {
        $matches = true;
        
        if ($categoryFilter && $artwork->getCategory() != $categoryFilter) {
            $matches = false;
        }
        
        if ($priceMinFilter && $artwork->getPrice() < $priceMinFilter) {
            $matches = false;
        }
        
        if ($priceMaxFilter && $artwork->getPrice() > $priceMaxFilter) {
            $matches = false;
        }
        
        if ($inStockFilter && $artwork->getNumberInStock() <= 0) {
            $matches = false;
        }
        
        return $matches;
    });
    
} catch (Exception $e) {
    error_log("Error fetching artworks: " . $e->getMessage());
    $pageErrorMessage = "Sorry, we couldn't load the artworks at this time. Please try again later.";
}

// Get unique categories for filter dropdown
$categories = [];
if (!empty($allArtworks)) {
    $categories = array_unique(array_map(function($artwork) {
        return $artwork->getCategory();
    }, $allArtworks));
}

$baseUrl = "/Art_Gallery/";
if ($_SERVER['DOCUMENT_ROOT'] === '/xampp/htdocs') {
    // Common XAMPP setup
} else {
    // Adjust base URL if needed for other environments
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Collection - Art Web</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/product.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <style>
        .prod_main {
            display: flex;
            flex-direction: column;
        }

        .product_2im1 {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product_2imi img {
            aspect-ratio: 3 / 4;
            object-fit: cover;
        }

        .sold-out-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(128, 128, 128, 0.7);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            font-weight: bold;
        }

        .add-to-cart,
        .add-to-wishlist {
            cursor: pointer;
        }
        
        /* New styles for filter sidebar */
        .filter-sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .filter-group {
            margin-bottom: 20px;
        }
        
        .filter-title {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .price-range-inputs {
            display: flex;
            gap: 10px;
        }
        
        .price-range-inputs input {
            width: 100px;
        }
        
        .filter-reset {
            margin-top: 20px;
        }
    </style>
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
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= htmlspecialchars($_SESSION['message']['type']) ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['message']['text']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (isset($pageErrorMessage)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($pageErrorMessage) ?></div>
            <?php endif; ?>

            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-md-3">
                    <div class="filter-sidebar">
                        <form method="get" action="">
                            <div class="filter-group">
                                <div class="filter-title">Categories</div>
                                <select class="form-select" name="category">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= htmlspecialchars($category) ?>" <?= $categoryFilter == $category ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <div class="filter-title">Price Range</div>
                                <div class="price-range-inputs">
                                    <input type="number" class="form-control" name="price_min" placeholder="Min" 
                                           value="<?= $priceMinFilter ? htmlspecialchars($priceMinFilter) : '' ?>">
                                    <input type="number" class="form-control" name="price_max" placeholder="Max" 
                                           value="<?= $priceMaxFilter ? htmlspecialchars($priceMaxFilter) : '' ?>">
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock" 
                                           <?= $inStockFilter ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="in_stock">
                                        In Stock Only
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="product.php" class="btn btn-outline-secondary filter-reset">Reset</a>
                        </form>
                    </div>
                </div>
                
                <!-- Product Listing -->
                <div class="col-md-9">
                    <div class="row product_1">
                        <div class="col-md-9">
                            <div class="product_1l">
                                <p class="mb-0 mt-2">
                                    Showing <?= count($artworksObjects) > 0 ? '1' : '0'; ?>–<?= count($artworksObjects); ?> of <?= count($artworksObjects); ?> results
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Sorting/filter options can go here -->
                        </div>
                    </div>

                    <div class="row product_2 mt-4">
                        <?php if (!empty($artworksObjects)): ?>
                            <?php foreach ($artworksObjects as $artwork): ?>
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                    <div class="prod_main p-1 bg-white clearfix h-100 shadow-sm rounded">
                                        <div class="product_2im clearfix position-relative">
                                            <div class="product_2imi clearfix">
                                                <div class="grid clearfix">
                                                    <figure class="effect-jazz mb-0">
                                                        <!-- Link to product detail page, adjust path as needed -->
                                                        <a href="<?= htmlspecialchars($baseUrl) ?>artwork_detail.php?id=<?= $artwork->getArtworkID() ?>">
                                                            <img src="<?= htmlspecialchars($baseUrl) ?>Images/artworks/<?= htmlspecialchars($artwork->getImage()) ?>"
                                                                class="w-100"
                                                                alt="<?= htmlspecialchars($artwork->getTitle()) ?>"
                                                                loading="lazy">
                                                        </a>
                                                    </figure>
                                                </div>
                                            </div>
                                            <div class="product_2imi1 position-absolute clearfix w-100 top-0 text-center p-2" style="background: rgba(255,255,255,0.1);">
                                                <ul class="list-inline mb-0">
                                                    <?php if ($artwork->getNumberInStock() > 0): ?>
                                                        <li class="list-inline-item">
                                                            <button class="btn btn-sm btn-primary add-to-cart"
                                                                data-id="<?= $artwork->getArtworkID() ?>" title="Add to Cart">
                                                                <i class="fa fa-shopping-cart"></i>
                                                            </button>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li class="list-inline-item">
                                                        <button class="btn btn-sm btn-outline-danger add-to-wishlist"
                                                            data-id="<?= $artwork->getArtworkID() ?>" title="Add to Wishlist">
                                                            <i class="fa fa-heart-o"></i>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php if ($artwork->getNumberInStock() <= 0): ?>
                                                <div class="sold-out-overlay">
                                                    <span>Sold Out</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product_2im1 position-relative clearfix">
                                            <div class="clearfix product_2im1i text-center pt-3 pb-3 px-2">
                                                <h5 class="font_14 text-uppercase">
                                                    <a class="col_dark text-decoration-none" href="<?= htmlspecialchars($baseUrl) ?>artwork_detail.php?id=<?= $artwork->getArtworkID() ?>">
                                                        <?= htmlspecialchars($artwork->getTitle()) ?>
                                                    </a>
                                                </h5>
                                                <p class="font_12 text-muted mb-1"><?= htmlspecialchars($artwork->getCategory()) ?></p>
                                                <span class="font_12 col_yell">
                                                    <?php
                                                    // Example rating calculation, adjust as needed
                                                    $totalReviews = $artwork->getTotalReviews();
                                                    // This rating logic is placeholder, replace with actual average rating if available
                                                    $average_rating = $totalReviews > 0 ? min(5, max(0, $totalReviews / 5)) : 3.5;
                                                    $fullStars = floor($average_rating);
                                                    $hasHalfStar = ($average_rating - $fullStars) >= 0.5;

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
                                                    <small class="text-muted">(<?= $totalReviews ?> reviews)</small>
                                                </span>
                                                <h6 class="col_dark mt-2 mb-0">
                                                    $<?= number_format($artwork->getPrice(), 2) ?>
                                                    <?php if ($artwork->getNumberInStock() > 0): ?>
                                                        <small class="text-success d-block">(<?= $artwork->getNumberInStock(); ?> in stock)</small>
                                                    <?php else: ?>
                                                        <small class="text-danger d-block">(Out of stock)</small>
                                                    <?php endif; ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php if (!isset($pageErrorMessage)): // Show only if no other critical error displayed 
                            ?>
                                <div class="col-12 text-center py-5">
                                    <h4>No artworks found</h4>
                                    <p>Please check back later or explore our other collections.</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="footer" class="pt-3 pb-3 bg-dark text-light">
        <!-- Footer content from your original file, ensure paths for images/links are correct -->
        <div class="container-fluid">
            <!-- ... (Your existing footer HTML) ... -->
            <div class="row footer_2 mt-4 text-center">
                <div class="col-md-12">
                    <p class="mb-0">© <?php echo date("Y"); ?> Art Gallery. All Rights Reserved | Design by <a class="col_pink"
                            href="http://www.templateonweb.com">TemplateOnWeb</a> (Adapted)</p>
                </div>
            </div>
        </div>
    </section>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const artworkId = this.getAttribute('data-id');

                    // Adjust fetch path if add_to_cart.php is elsewhere
                    // e.g., if product.php is in pages/ and add_to_cart.php is in api/
                    // fetch('../api/add_to_cart.php', {
                    // If product.php and add_to_cart.php are in the same directory:
                    // fetch('add_to_cart.php', { 
                    // Using root-relative path based on $baseUrl for consistency
                    const fetchUrl = `<?= htmlspecialchars($baseUrl) ?>Model/Classes/add_to_cart.php`;

                    fetch(fetchUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest' // Often good to send for server-side detection
                            },
                            body: `artwork_id=${artworkId}`
                        })
                        .then(response => {
                            if (!response.ok) {
                                // Try to get error message from JSON if server sends it despite non-200 status
                                return response.json().then(errData => {
                                    throw new Error(errData.message || `HTTP error ${response.status}`);
                                }).catch(() => { // If parsing JSON fails or no JSON body
                                    throw new Error(`HTTP error ${response.status}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Update cart count in navbar (example selector, adjust to your HTML)
                                const cartCountElement = document.querySelector('.cart-nav-count'); // You'll need this element in your header
                                if (cartCountElement && data.cartCount !== undefined) {
                                    cartCountElement.textContent = data.cartCount;
                                }

                                // Show feedback (simple alert, or use a nicer toast/modal)
                                alert(data.message || 'Item added to cart!');

                                // Optional: update stock display on page if necessary, or button state
                                // For example, if stock reaches 0, disable add to cart button.
                                const stockDisplay = this.closest('.prod_main').querySelector('.text-success small, .text-danger small');
                                if (stockDisplay && data.newStock !== undefined) { // Assuming API returns new stock
                                    if (data.newStock > 0) {
                                        stockDisplay.textContent = `(${data.newStock} in stock)`;
                                        stockDisplay.className = 'text-success d-block';
                                    } else {
                                        stockDisplay.textContent = `(Out of stock)`;
                                        stockDisplay.className = 'text-danger d-block';
                                        this.disabled = true; // Disable button if out of stock
                                    }
                                }


                            } else {
                                // Handle specific error scenarios from server
                                if (data.redirect) { // If server suggests redirect (e.g., to login)
                                    window.location.href = data.redirect;
                                } else {
                                    alert('Error: ' + (data.message || 'Could not add item to cart.'));
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error);
                            alert('An error occurred: ' + error.message);
                        });
                });
            });

            // Placeholder for add-to-wishlist
            document.querySelectorAll('.add-to-wishlist').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const artworkId = this.getAttribute('data-id');
                    alert(`Wishlist functionality for Artwork ID ${artworkId} is not yet implemented.`);
                    // Implement fetch to wishlist API endpoint here
                });
            });
        });
    </script>
</body>

</html>