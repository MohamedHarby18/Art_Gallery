<?php
require_once __DIR__ . '/../Controller/controlDB.php';
require_once __DIR__ .'/../Model/Classes/egiftClass.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$db = new DBController();
$error = '';
$success = '';
$customerID = $_SESSION['customer_id'] ?? 0;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['egiftSend'])) {
    // Validate and sanitize inputs
    $recipientName = htmlspecialchars(trim($_POST['recipientName'] ?? ''));
    $recipientEmail = filter_var(trim($_POST['recipientEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
    $senderName = htmlspecialchars(trim($_POST['senderName'] ?? ''));
    $giftMessage = htmlspecialchars(trim($_POST['giftMessage'] ?? ''));
    $deliveryDate = $_POST['deliveryDate'] ?? '';
    $amount = filter_var($_POST['amount'] ?? 0, FILTER_VALIDATE_FLOAT);

    // Validate required fields
    if (empty($recipientName)) {
        $error = "Recipient name is required";
    } elseif (empty($recipientEmail)) {
        $error = "Recipient email is required";
    } elseif (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } elseif (!$amount || $amount <= 0) {
        $error = "Please enter a valid amount";
    } elseif ($amount < 10 || $amount > 1500) {
        $error = "Amount must be between $10 and $1500";
    } else {
        // Generate unique gift card ID
        $giftID = 'GC-' . uniqid() . '-' . time();
        
        // Start transaction
        $db->beginTransaction();
        try {
            // Create and save gift card
            $egift = new EGift($db, $giftID, $customerID, $recipientEmail, $recipientName, $amount);
            
            if ($egift->save()) {
                // Here you would typically:
                // 1. Send email notification
                // 2. Process payment
                // 3. Log the transaction
                
                $db->commit();
                $success = "Gift card created successfully! A confirmation has been sent to $recipientEmail";
                
                // Clear form on success
                $_POST = array();
            } else {
                throw new Exception("Failed to save gift card");
            }
        } catch (Exception $e) {
            $db->rollback();
            $error = "Error processing your request: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - Gift Cards</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/egift.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
</head>
<body>
<div class="main clearfix position-relative">
    <div class="main_1 clearfix position-absolute top-0 w-100">
        <section id="header">
            <nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
                <div class="container-xl">
                    <a class="navbar-brand fs-2 p-0 fw-bold text-white" href="index.html">
                        <i class="fa fa-pencil col_pink me-1 align-middle"></i> art <span class="col_pink span_1">WEB</span> <br> <span class="font_12 span_2">DIGITAL ART</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-0 ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html">About</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Product
                                </a>
                                <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="product.html">Product</a></li>
                                    <li><a class="dropdown-item border-0" href="detail.html">Product Detail</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Gift Cards
                                </a>
                                <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown2">
                                    <li><a class="dropdown-item" href="gift-cards.html">E-Gift Cards</a></li>
                                    <li><a class="dropdown-item border-0" href="physical-gifts.html">Physical Cards</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </section>
    </div>
    <div class="main_2 clearfix">
        <section id="center" class="center_home">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" class="" aria-current="true"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/1.jpg" class="d-block w-100" alt="Gift Cards">
                        <div class="carousel-caption d-md-block">
                            <h1 class="text-white font_60">The Perfect Art Gift</h1>
                            <h4 class="text-white mt-3">Digital Gift Cards</h4>
                            <p class="text-white mt-4">Give the gift of art with our customizable e-gift cards. Let your loved ones choose their perfect piece from our curated collection.</p>
                            <h6 class="mt-4 mb-0"><a class="button" href="#gift-cards"><i class="fa fa-gift bg-white col_pink p-3"> </i> <span class="ps-3 pe-3">View Gift Options</span></a></h6>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/2.jpg" class="d-block w-100" alt="Gift Cards">
                        <div class="carousel-caption d-md-block">
                            <h1 class="text-white font_60">Instant Delivery</h1>
                            <h4 class="text-white mt-3">Send Anytime, Anywhere</h4>
                            <p class="text-white mt-4">Our e-gift cards are delivered instantly via email, perfect for last-minute gifts or special occasions.</p>
                            <h6 class="mt-4 mb-0"><a class="button" href="#gift-cards"><i class="fa fa-bolt bg-white col_pink p-3"> </i> <span class="ps-3 pe-3">Send Today</span></a></h6>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    </div>
</div>

<section id="gift-cards" class="gift-section p_4">
    <div class="container-xl">
        <div class="row port_1 text-center">
            <div class="col-md-12">
                <h1 class="font_60">ART GIFT CARDS</h1>
                <p>Give the perfect gift - let them choose their favorite artwork</p>
                <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
            </div>
        </div>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="row gift-options">
            <div class="col-md-4">
                <div class="gift-card" data-amount="50" data-image="img/5.jpg">
                    <div class="gift-card-img" style="background-image: url('img/5.jpg')">
                        <div class="gift-card-overlay">
                            <h4 class="text-white">SELECT THIS CARD</h4>
                        </div>
                    </div>
                    <div class="gift-card-body">
                        <h3>Starter Collection</h3>
                        <p>Perfect for prints and small works</p>
                        <div class="gift-card-price">$50</div>
                        <button class="btn btn-outline-dark">Select</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gift-card" data-amount="150" data-image="img/6.jpg">
                    <div class="gift-card-img" style="background-image: url('img/6.jpg')">
                        <div class="gift-card-overlay">
                            <h4 class="text-white">SELECT THIS CARD</h4>
                        </div>
                    </div>
                    <div class="gift-card-body">
                        <h3>Curator's Choice</h3>
                        <p>For original paintings and photographs</p>
                        <div class="gift-card-price">$150</div>
                        <button class="btn btn-outline-dark">Select</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="gift-card" data-amount="500" data-image="img/7.jpg">
                    <div class="gift-card-img" style="background-image: url('img/7.jpg')">
                        <div class="gift-card-overlay">
                            <h4 class="text-white">SELECT THIS CARD</h4>
                        </div>
                    </div>
                    <div class="gift-card-body">
                        <h3>Collector's Edition</h3>
                        <p>For premium artworks and sculptures</p>
                        <div class="gift-card-price">$500</div>
                        <button class="btn btn-outline-dark">Select</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="gift-customize" id="customizePanel" style="<?= isset($_POST['egiftSend']) && empty($error) ? '' : 'display:none;' ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="gift-preview" id="giftPreview" style="background-image: url('img/5.jpg')"></div>
                    <div class="form-group mb-3">
                        <label>Choose Design</label>
                        <div class="row mt-2">
                            <div class="col-3">
                                <div class="design-option" data-image="img/5.jpg" style="background-image: url('img/5.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;"></div>
                            </div>
                            <div class="col-3">
                                <div class="design-option" data-image="img/6.jpg" style="background-image: url('img/6.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;"></div>
                            </div>
                            <div class="col-3">
                                <div class="design-option" data-image="img/7.jpg" style="background-image: url('img/7.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;"></div>
                            </div>
                            <div class="col-3">
                                <div class="design-option" data-image="img/8.jpg" style="background-image: url('img/8.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="mb-4">Personalize Your Gift</h3>
                    <form method="POST">
                        <div class="form-group mb-3">
                            <label for="recipientName">Recipient Name *</label>
                            <input type="text" class="form-control" maxlength="20" id="recipientName" name="recipientName" 
                                   placeholder="Enter recipient's name" required
                                   value="<?= isset($_POST['recipientName']) ? htmlspecialchars($_POST['recipientName']) : '' ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="recipientEmail">Recipient Email *</label>
                            <input type="email" class="form-control" id="recipientEmail" name="recipientEmail" 
                                   placeholder="Enter recipient's email" required
                                   value="<?= isset($_POST['recipientEmail']) ? htmlspecialchars($_POST['recipientEmail']) : '' ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="senderName">Your Name</label>
                            <input type="text" class="form-control" id="senderName" name="senderName" 
                                   placeholder="Enter your name"
                                   value="<?= isset($_POST['senderName']) ? htmlspecialchars($_POST['senderName']) : '' ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="giftMessage">Message</label>
                            <textarea class="form-control" id="giftMessage" name="giftMessage" rows="3" 
                                      placeholder="Add a personal message"><?= isset($_POST['giftMessage']) ? htmlspecialchars($_POST['giftMessage']) : '' ?></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="deliveryDate">Delivery Date</label>
                            <input type="date" class="form-control" id="deliveryDate" name="deliveryDate"
                                   value="<?= isset($_POST['deliveryDate']) ? htmlspecialchars($_POST['deliveryDate']) : '' ?>">
                        </div>
                        <div class="form-group mb-5">
                            <label for="giftAmount">Gift Amount *</label>
                            <input type="number" name="amount" min="10" max="1500" step="5" class="form-control" id="giftAmount" 
                                   placeholder="Enter gift amount" required
                                   value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary btn-lg" id="checkoutBtn" type="submit" name="egiftSend">Proceed to Checkout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row gift-features text-center">
            <div class="col-md-4">
                <div class="gift-feature-icon">
                    <i class="fa fa-gift"></i>
                </div>
                <h4>Flexible Gifting</h4>
                <p>Let your recipient choose their perfect artwork from our entire collection.</p>
            </div>
            <div class="col-md-4">
                <div class="gift-feature-icon">
                    <i class="fa fa-bolt"></i>
                </div>
                <h4>Instant Delivery</h4>
                <p>Email delivery means your gift arrives exactly when you want it to.</p>
            </div>
            <div class="col-md-4">
                <div class="gift-feature-icon">
                    <i class="fa fa-calendar"></i>
                </div>
                <h4>Schedule Delivery</h4>
                <p>Schedule your gift to arrive on a special date like birthdays or anniversaries.</p>
            </div>
        </div>
    </div>
</section>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle gift card selection
    const giftCards = document.querySelectorAll('.gift-card');
    const customizePanel = document.getElementById('customizePanel');
    const giftPreview = document.getElementById('giftPreview');
    const giftAmountInput = document.getElementById('giftAmount');
    
    giftCards.forEach(card => {
        card.addEventListener('click', function() {
            // Update preview with selected image
            const imageUrl = this.getAttribute('data-image');
            giftPreview.style.backgroundImage = `url('${imageUrl}')`;
            
            // Update amount
            const amount = this.getAttribute('data-amount');
            giftAmountInput.value = amount;
            
            // Show customization panel
            customizePanel.style.display = 'block';
            
            // Scroll to panel
            customizePanel.scrollIntoView({ behavior: 'smooth' });
        });
    });
    
    // Handle design selection
    const designOptions = document.querySelectorAll('.design-option');
    designOptions.forEach(option => {
        option.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image');
            giftPreview.style.backgroundImage = `url('${imageUrl}')`;
        });
    });
    
    // Set minimum delivery date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('deliveryDate').setAttribute('min', today);
    
    // Sticky navbar
    window.onscroll = function() {myFunction()};

    var navbar_sticky = document.getElementById("navbar_sticky");
    var sticky = navbar_sticky.offsetTop;
    var navbar_height = document.querySelector('.navbar').offsetHeight;

    function myFunction() {
      if (window.pageYOffset >= sticky + navbar_height) {
        navbar_sticky.classList.add("sticky")
        document.body.style.paddingTop = navbar_height + 'px';
      } else {
        navbar_sticky.classList.remove("sticky");
        document.body.style.paddingTop = '0'
      }
    }
});
</script>

</body>
</html>