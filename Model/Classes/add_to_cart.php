<?php
session_start();
require_once '../Controller/DBController.php';
require_once '../Model/Classes/Cart.php'; // Make sure this path and filename are correct (case-sensitive)

// Optional debug: confirm Cart class loaded
if (!class_exists('Cart')) {
    echo json_encode([
        'success' => false,
        'message' => 'Cart class not found. Check file path and class definition.'
    ]);
    exit;
}

$response = ['success' => false, 'message' => ''];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'Please login to add items to cart';
    $response['redirect'] = 'login.php';
    echo json_encode($response);
    exit;
}

// Check if artwork ID was provided
if (!isset($_POST['artwork_id'])) {
    $response['message'] = 'No artwork specified';
    echo json_encode($response);
    exit;
}

$artworkId = intval($_POST['artwork_id']);
$userId = $_SESSION['user_id'];

try {
    $cart = new Cart($userId);
    if ($cart->addArtwork($artworkId, 1)) {
        $response['success'] = true;
        $response['message'] = 'Item added to cart';
    } else {
        $response['message'] = 'Failed to add item to cart';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?>
