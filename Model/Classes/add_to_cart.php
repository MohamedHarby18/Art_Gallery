<?php
// For development: display all errors. Remove/comment out for production.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Path Configuration ---
// add_to_cart.php is in Model/Classes/
// __DIR__ is Art_Gallery/Model/Classes

// To get to Controller/DBController.php (which is in Art_Gallery/Controller/)
require_once __DIR__ . '/../../Controller/DBController.php';

// Artwork.php and Cart.php are in the SAME directory (Model/Classes/) as add_to_cart.php
require_once __DIR__ . '/Artwork.php';
require_once __DIR__ . '/Cart.php';

// --- Response Setup ---
header('Content-Type: application/json');
$response = [
    'success' => false,
    'message' => 'An unexpected error occurred.',
    'cartCount' => 0, // Initialize cart count
    // 'debug' => [] // Optional: for adding debug messages
];

try {
    // --- 1. User Authentication Check ---
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401); // Unauthorized
        $response['message'] = 'User not authenticated. Please login to add items to cart.';
        // $response['redirect'] = 'login.php'; // Optional: client-side can use this
        echo json_encode($response);
        exit;
    }
    $userId = (int)$_SESSION['user_id'];
    // $response['debug'][] = "User ID: {$userId}";

    // --- 2. Input Validation ---
    if (!isset($_POST['artwork_id'])) {
        http_response_code(400); // Bad Request
        $response['message'] = 'Artwork ID not provided.';
        echo json_encode($response);
        exit;
    }
    if (!filter_var($_POST['artwork_id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
        http_response_code(400); // Bad Request
        $response['message'] = 'Invalid Artwork ID specified.';
        echo json_encode($response);
        exit;
    }
    $artworkId = (int)$_POST['artwork_id'];
    // $response['debug'][] = "Artwork ID: {$artworkId}";

    // --- 3. Fetch Artwork Details ---
    $artwork = Artwork::getArtworkById($artworkId);
    if (!$artwork) {
        http_response_code(404); // Not Found
        $response['message'] = "Artwork with ID {$artworkId} not found.";
        echo json_encode($response);
        exit;
    }
    // $response['debug'][] = "Artwork found: " . $artwork->getTitle();

    // --- 4. Stock Validation ---
    $currentStock = $artwork->getNumberInStock();
    if ($currentStock < 1) {
        http_response_code(409); // Conflict (or 400 Bad Request)
        $response['message'] = 'This artwork "' . htmlspecialchars($artwork->getTitle()) . '" is currently out of stock.';
        echo json_encode($response);
        exit;
    }
    // $response['debug'][] = "Current stock: {$currentStock}";

    // --- 5. Cart Operations ---
    $cart = new Cart($userId); // Initialize cart for the user
    // $response['debug'][] = "Cart initialized. Current items in memory: " . count($cart->listArtworks());

    // Check current quantity in cart for this item to avoid exceeding stock
    $quantityInCart = 0;
    $cartItems = $cart->listArtworks();
    foreach ($cartItems as $item) {
        if (isset($item['ArtworkID']) && $item['ArtworkID'] == $artworkId) {
            $quantityInCart = (int)($item['Quantity'] ?? 0);
            break;
        }
    }
    // $response['debug'][] = "Quantity of this item already in cart: {$quantityInCart}";

    $quantityToAdd = 1; // Assuming we add one at a time from product page
    if (($quantityInCart + $quantityToAdd) > $currentStock) {
        http_response_code(409); // Conflict
        $response['message'] = 'Cannot add more "' . htmlspecialchars($artwork->getTitle()) . '" to cart. Requested quantity exceeds available stock. In cart: ' . $quantityInCart . ', Stock: ' . $currentStock;
        echo json_encode($response);
        exit;
    }

    // Prepare artwork data for the cart's addArtwork method
    $artworkDataForCart = [
        'ArtworkID'     => $artwork->getArtworkID(),
        'Title'         => $artwork->getTitle(),
        'Price'         => $artwork->getPrice(),
        'Image'         => $artwork->getImage(),
        'numberInStock' => $currentStock // Pass current stock for validation within Cart class
    ];

    if ($cart->addArtwork($artworkDataForCart, $quantityToAdd)) {
        $response['success'] = true;
        $response['message'] = '"' . htmlspecialchars($artwork->getTitle()) . '" has been added to your cart.';
        $response['cartCount'] = count($cart->listArtworks()); // Get updated cart count
        // $response['debug'][] = "Artwork added/updated in cart successfully.";
    } else {
        // If Cart::addArtwork returns false without throwing an exception
        // (It should ideally throw for clearer error handling)
        http_response_code(500); // Internal Server Error
        $response['message'] = 'Failed to add artwork to cart due to an internal issue.';
        $lastCartError = $cart->getLastDbError(); // Assuming Cart class has this
        if ($lastCartError) {
            $response['message'] .= " Error: " . $lastCartError;
            // error_log("Add to cart failed for user {$userId}, artwork {$artworkId}: " . $lastCartError); // Log for admin
        }
    }

} catch (Exception $e) {
    // Determine appropriate HTTP status code
    $statusCode = $e->getCode();
    if ($statusCode < 400 || $statusCode > 599 || !is_int($statusCode)) { // Ensure valid HTTP code range
        $statusCode = 500; // Default to Internal Server Error
    }
    http_response_code($statusCode);

    $response['message'] = $e->getMessage();
    // error_log("Exception in add_to_cart.php: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile()); // Log for admin
    // $response['debug'][] = "Exception caught: " . $e->getMessage();
    // $response['debug'][] = "File: " . $e->getFile() . " Line: " . $e->getLine();

    // You might want to provide a 'redirect' field for specific error codes (like 401)
    // if ($e->getCode() === 401) {
    //     $response['redirect'] = 'login.php';
    // }
}

// --- 6. Send JSON Response ---
echo json_encode($response);
exit;
?>