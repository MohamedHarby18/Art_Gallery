<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assuming cart.php is in a directory like 'pages/' or 'View/'
// relative to the project root.
// DBController is included by Cart.php if Cart.php uses relative path for it.
// require_once __DIR__ . '/../Controller/DBController.php'; 
require_once __DIR__ . '/../Model/Classes/Cart.php';
require_once __DIR__ . '/../Model/Classes/Artwork.php'; // Needed for stock checks if Cart::updateQuantity fetches live stock

$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
$cart = new Cart($userId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actionSuccess = false;
    try {
        if (isset($_POST['remove_item'])) {
            if (!isset($_POST['artwork_id']) || !filter_var($_POST['artwork_id'], FILTER_VALIDATE_INT)) {
                throw new Exception("Invalid artwork ID for removal.");
            }
            $artworkID = (int)$_POST['artwork_id'];
            if ($cart->removeArtwork($artworkID)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Item removed successfully.'];
                $actionSuccess = true;
            } else {
                 $_SESSION['message'] = ['type' => 'warning', 'text' => 'Could not remove item. It might have already been removed.'];
            }
        } 
        elseif (isset($_POST['update_quantity'])) {
            if (!isset($_POST['artwork_id']) || !filter_var($_POST['artwork_id'], FILTER_VALIDATE_INT) ||
                !isset($_POST['quantity']) || !filter_var($_POST['quantity'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]])) {
                 throw new Exception("Invalid artwork ID or quantity for update.");
            }
            $artworkID = (int)$_POST['artwork_id'];
            $quantity = (int)$_POST['quantity'];

            if ($cart->updateQuantity($artworkID, $quantity)) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Quantity updated successfully.'];
                $actionSuccess = true;
            } else {
                 // updateQuantity might throw an exception for stock issues, or return false if item not found.
                 $_SESSION['message'] = ['type' => 'warning', 'text' => 'Could not update quantity. Item might not be in cart or other issue.'];
            }
        } 
        elseif (isset($_POST['checkout'])) {
            if ($userId) {
                if ($cart->checkout()) { // checkout method handles clearing cart on success
                    $_SESSION['message'] = ['type' => 'success', 'text' => 'Checkout successful! Your order has been placed.'];
                    // Redirect to a success page or order confirmation page
                    header("Location: checkout_success.php"); 
                    exit();
                }
                // If checkout fails, an exception is typically thrown and caught below.
            } else {
                $_SESSION['message'] = ['type' => 'warning', 'text' => 'Please login to checkout.'];
                header("Location: login.php?redirect=" . urlencode('cart.php'));
                exit();
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Error: ' . $e->getMessage()];
    }
    
    // Redirect back to cart page to show messages and updated state,
    // only if an action was attempted.
    if ($_POST) { // Checks if any POST data was sent
        header("Location: cart.php");
        exit();
    }
}

// Get cart data for display
try {
    $cartItems = $cart->listArtworks();
    $totalPrice = $cart->getTotalPrice();
} catch (Exception $e) {
    // This catch is for errors during listing, less common
    $_SESSION['message'] = ['type' => 'danger', 'text' => "Error loading cart: " . $e->getMessage()];
    $cartItems = [];
    $totalPrice = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Art Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        .cart-item-image { max-height: 150px; width: auto; object-fit: cover; }
        .stock-warning { color: red; font-size: 0.9em; }
    </style>
</head>
<body>

    <div class="container py-5">
        <h1 class="mb-4">Shopping Cart</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['message']['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['message']['text']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($errorMessage) && $errorMessage): // For critical errors loading cart ?>
             <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div class="text-center py-5">
                <img src="../Images/empty-cart.png" alt="Empty Cart" style="max-width: 200px; margin-bottom: 20px;"> <!-- Example image -->
                <h4 class="mb-3">Your cart is empty</h4>
                <p>Looks like you haven't added any artworks to your cart yet.</p>
                <a href="product.php" class="btn btn-primary">Browse Artworks</a> <!-- Make sure product.php is the correct link -->
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="card mb-3 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-3 d-flex justify-content-center align-items-center p-2">
                                    <img src="../Images/artworks/<?= htmlspecialchars($item['Image'] ?? 'default_artwork.jpg') ?>" 
                                         class="img-fluid rounded-start cart-item-image"
                                         alt="<?= htmlspecialchars($item['Title'] ?? 'Artwork') ?>">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($item['Title'] ?? 'Untitled Artwork') ?>
                                        </h5>
                                        <p class="card-text text-muted">
                                            Unit Price: $<?= number_format($item['Price'] ?? 0, 2) ?>
                                        </p>
                                        
                                        <?php 
                                            $itemStock = $item['numberInStock'] ?? 0;
                                            $itemQuantity = $item['Quantity'] ?? 1;
                                        ?>
                                        <?php if ($itemStock < $itemQuantity && $itemStock > 0): ?>
                                            <p class="stock-warning">
                                                Attention: Only <?= $itemStock ?> available in stock. Your quantity has been adjusted or needs adjustment.
                                            </p>
                                        <?php elseif ($itemStock <= 0): ?>
                                             <p class="stock-warning">This item is currently out of stock.</p>
                                        <?php endif; ?>

                                        <form method="post" action="cart.php" class="d-inline-block align-middle mb-2">
                                            <input type="hidden" name="artwork_id" 
                                                   value="<?= htmlspecialchars($item['ArtworkID']) ?>">
                                            <label for="quantity-<?= htmlspecialchars($item['ArtworkID']) ?>" class="form-label visually-hidden">Quantity</label>
                                            <div class="input-group" style="max-width: 150px;">
                                                <input type="number" id="quantity-<?= htmlspecialchars($item['ArtworkID']) ?>" name="quantity" 
                                                       value="<?= htmlspecialchars($itemQuantity) ?>" 
                                                       min="0" <?php // min="0" allows removal via quantity update ?>
                                                       max="<?= htmlspecialchars($itemStock) ?>" 
                                                       class="form-control form-control-sm"
                                                       aria-describedby="update-btn-<?= htmlspecialchars($item['ArtworkID']) ?>">
                                                <button type="submit" name="update_quantity" 
                                                        id="update-btn-<?= htmlspecialchars($item['ArtworkID']) ?>"
                                                        class="btn btn-outline-primary btn-sm">
                                                    Update
                                                </button>
                                            </div>
                                        </form>

                                        <form method="post" action="cart.php" class="d-inline-block align-middle ms-2 mb-2">
                                            <input type="hidden" name="artwork_id" 
                                                   value="<?= htmlspecialchars($item['ArtworkID']) ?>">
                                            <button type="submit" name="remove_item" 
                                                    class="btn btn-outline-danger btn-sm">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <dl class="row">
                                <dt class="col-6">Subtotal:</dt>
                                <dd class="col-6 text-end">$<?= number_format($totalPrice, 2) ?></dd>
                                <dt class="col-6">Shipping:</dt>
                                <dd class="col-6 text-end">
                                    <?php $shippingCost = 0.00; // Example, could be dynamic ?>
                                    <?= ($shippingCost > 0) ? '$' . number_format($shippingCost, 2) : 'Free' ?>
                                </dd>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dt class="col-6 fs-5">Total:</dt>
                                <dd class="col-6 text-end fs-5 fw-bold">$<?= number_format($totalPrice + $shippingCost, 2) ?></dd>
                            </dl>
                            
                            <?php if ($userId): ?>
                                <form method="post" action="cart.php">
                                    <button type="submit" name="checkout" 
                                            class="btn btn-primary w-100" <?= empty($cartItems) ? 'disabled' : '' ?>>
                                        Proceed to Checkout
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="login.php?redirect=<?= urlencode('cart.php') ?>" 
                                   class="btn btn-success w-100">
                                    Login to Checkout
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="product.php" class="btn btn-link">Continue Shopping</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>