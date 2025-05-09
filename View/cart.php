<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and include required files
session_start();
require_once '../Controller/DBController.php';
require_once '../Model/Classes/Cart.php';

// Always allow cart, regardless of login
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialize cart
$cart = new Cart($userId);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item'])) {
        $artworkID = $_POST['artwork_id'];
        if ($cart->removeArtwork($artworkID)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Item removed successfully'];
            header("Location: cart.php");
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to remove item'];
        }
    } elseif (isset($_POST['update_quantity'])) {
        $artworkID = $_POST['artwork_id'];
        $quantity = intval($_POST['quantity']);
        if ($quantity > 0 && $cart->updateQuantity($artworkID, $quantity)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Quantity updated successfully'];
            header("Location: cart.php");
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to update quantity'];
        }
    } elseif (isset($_POST['checkout'])) {
        if ($userId) {
            if ($cart->checkout()) {
                header("Location: checkout_success.php");
                exit();
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Checkout failed. Please try again.'];
            }
        } else {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Please login to checkout'];
            header("Location: login.php?redirect=cart.php");
            exit();
        }
    }
}

// Get cart items with error handling
try {
    $cartItems = $cart->listArtworks();
    $totalPrice = $cart->getTotalPrice();
} catch (Exception $e) {
    $errorMessage = "Error loading cart: " . $e->getMessage();
    $cartItems = [];
    $totalPrice = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - Shopping Cart</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        .alert {
            margin: 15px 0;
        }
        .cart-item-image {
            max-width: 100px;
            height: auto;
        }
        .quantity-input {
            width: 60px;
            display: inline-block;
        }
        .stock-message {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <!-- Show messages if any -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $_SESSION['message']['type'] ?>">
                <?= $_SESSION['message']['text'] ?>
            </div>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div class="container mt-3">
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        </div>
    <?php endif; ?>

    <section id="center" class="center_o bg_gray pt-2 pb-2">
        <div class="container-xl">
            <div class="row center_o1">
                <div class="col-md-5">
                    <div class="center_o1l">
                        <h2 class="mb-0">Shopping Cart</h2>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="center_o1r text-end">
                        <h6 class="mb-0"><a href="index.php">Home</a> <span class="me-2 ms-2"><i class="fa fa-caret-right"></i></span> Shopping Cart</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cart_page" class="cart pt-4 pb-4">
        <div class="container-xl">
            <div class="cart_2 row">
                <div class="col-md-6">
                    <h5>MY CART</h5>
                </div>
                <div class="col-md-6">
                    <h5 class="text-end text-uppercase"><a href="product.php">Continue Shopping</a></h5>
                </div>
            </div>
            
            <?php if (empty($cartItems)): ?>
                <div class="row mt-4">
                    <div class="col-md-12 text-center py-5">
                        <h4>Your cart is empty</h4>
                        <a href="product.php" class="btn btn-primary mt-3">Browse Artworks</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="cart_3 row mt-3">
                    <div class="col-md-8">
                        <div class="cart_3l">
                            <h6>PRODUCT</h6>
                        </div>
                        
                        <?php foreach ($cartItems as $item): ?>
                        <div class="cart_3l1 mt-3 row ms-0 me-0">
                            <div class="col-md-3 ps-0 col-3">
                                <div class="cart_3l1i">
                                    <a href="artwork.php?id=<?= htmlspecialchars($item['ArtworkID']) ?>">
                                        <img src="../Images/artworks/<?= htmlspecialchars($item['Image']) ?>" alt="<?= htmlspecialchars($item['Title']) ?>" class="w-100 cart-item-image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9 col-9">
                                <div class="cart_3l1i1">
                                    <h6 class="fw-bold">
                                        <a href="artwork.php?id=<?= htmlspecialchars($item['ArtworkID']) ?>">
                                            <?= htmlspecialchars($item['Title']) ?>
                                        </a>
                                    </h6>
                                    <h5 class="col_pink mt-3">$<?= number_format($item['Price'], 2) ?></h5>
                                    <h6 class="font_12 mt-3 mb-3">Quantity</h6>
                                </div>
                                <div class="cart_3l1i2">
                                    <form method="post" class="d-inline">
                                        <input type="hidden" name="artwork_id" value="<?= $item['ArtworkID'] ?>">
                                        <input type="number" name="quantity" min="1" 
                                               value="<?= $item['Quantity'] ?? 1 ?>" 
                                               class="form-control quantity-input">
                                        <button type="submit" name="update_quantity" class="button">UPDATE</button>
                                        <button type="submit" name="remove_item" class="button_1">REMOVE</button>
                                    </form>
                                    <?php if (isset($item['Stock']) && $item['Stock'] < ($item['Quantity'] ?? 1)): ?>
                                        <div class="stock-message text-danger">
                                            Only <?= $item['Stock'] ?> available in stock
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-md-4">
                        <div class="cart_3r">
                            <div class="head_1">
                                <h6 class="mb-0">ORDER SUMMARY</h6>
                            </div>
                            <div class="cart_3r1 mt-3">
                                <h6 class="font_13">Subtotal <span class="float-end">$<?= number_format($totalPrice, 2) ?></span></h6>
                                <hr>
                                <h6 class="font_13">Shipping <span class="float-end">$0.00</span></h6>
                                <hr>
                                <h6 class="font_13">Total <span class="float-end">$<?= number_format($totalPrice, 2) ?></span></h6>
                                <form method="post">
                                    <button type="submit" name="checkout" class="button w-100 mt-3">PROCEED TO CHECKOUT</button>
                                </form>
                                <?php if (!$userId): ?>
                                    <div class="mt-3 text-center">
                                        <a href="login.php?redirect=cart.php" class="btn btn-outline-secondary w-100">Login to Checkout</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>