<?php
// Ensure error reporting is configured for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Prevent errors from breaking JSON/output
ini_set('log_errors', 1);
// ini_set('error_log', '/path/to/your/php-error.log'); // Uncomment and set path if needed

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assuming DBController.php handles database connections and operations
require_once __DIR__ . '/../Controller/DBController.php';
// Assuming egiftClass.php is updated as you provided (no RecipientName property/param, save method matches DB schema)
require_once __DIR__ .'/../Model/Classes/egiftClass.php';


// Initialize variables
$db = null;
$error = '';
$success = '';
$customerID = null; // Will hold the logged-in user's ID

// --- DB Initialization ---
try {
    $db = new DBController();
} catch (Throwable $e) {
    $error = "Error initializing database connection: " . $e->getMessage();
    // Log this critical error
    error_log("Egift DB Init Error: " . $e->getMessage() . " Trace: " . $e->getTraceAsString());
    // In a production site, you might show a generic error or redirect if DB is essential for the page
}


// --- Check User Login Status ---
// Check if user is logged in via session. Assuming your login sets 'user_id'.
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $customerID = $_SESSION['user_id'];
} else {
    // User is not logged in. Handle this by setting an error message.
    // The form submission logic below will check $customerID and prevent processing.
    $error = "You must be logged in to send an e-gift. Please <a href='login.php'>login</a>.";
    // Note: The form itself is still visible, but submission is blocked server-side.
    // You could add frontend checks or hide the form if $customerID is null if preferred.
}


// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['egiftSend'])) {

    // Re-check conditions necessary for processing
    if ($customerID === null) {
        // Error already set above if not logged in
        // Add specific handling if submitted via AJAX without session (less likely with full page load form)
    } elseif (!$db) {
        // Error already set during DB initialization
    } else {
        // --- Validation and Sanitization ---
        $recipientEmail = filter_var(trim($_POST['recipientEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
        $senderName = htmlspecialchars(trim($_POST['senderName'] ?? '')); // Sender name is kept from form
        $giftMessage = htmlspecialchars(trim($_POST['giftMessage'] ?? '')); // Gift message is kept from form
        $deliveryDate = $_POST['deliveryDate'] ?? ''; // Delivery date is kept from form
        $amount = filter_var($_POST['amount'] ?? 0, FILTER_VALIDATE_FLOAT);

        // Basic validation of delivery date format if provided (optional but good practice)
        // if (!empty($deliveryDate) && !DateTime::createFromFormat('Y-m-d', $deliveryDate)) {
        //     $error = "Invalid delivery date format.";
        // } elseif (!empty($deliveryDate) && new DateTime($deliveryDate) < new DateTime('today')) {
        //     $error = "Delivery date cannot be in the past.";
        // }


        // Validate required fields
        if (empty($error)) { // Only proceed if no previous errors (like not logged in or DB error)
             if (empty($recipientEmail)) {
                 $error = "Recipient email is required.";
             } elseif (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                 $error = "Please enter a valid recipient email address.";
             } elseif (empty($senderName)) { // Assuming sender name is required
                 $error = "Your name (sender) is required.";
             } elseif (!$amount || $amount <= 0) {
                 $error = "Please enter a valid amount.";
             } elseif ($amount < 10 || $amount > 1500) {
                 $error = "Amount must be between $10 and $1500.";
             }
        }


        // --- Process Gift Card Creation if no errors ---
        if (empty($error)) {
            // Generate unique gift card ID
            $giftID = 'GC-' . uniqid() . '-' . time();

            // Start transaction
            $db->beginTransaction();
            try {
                // Create EGift object
                // !! THIS CALL MATCHES THE CONSTRUCTOR IN THE EGift CLASS YOU PROVIDED !!
                // public function __construct(DBController $db, $ID, $customerSenderID, $receiverEmail = '', $value = 0)
                // It only passes the parameters the constructor expects and stores.
                $egift = new EGift(
                    $db,              // 1. DBController instance
                    $giftID,          // 2. Card ID (maps to $ID in constructor)
                    $customerID,      // 3. Sender UserID (maps to $customerSenderID)
                    $recipientEmail,  // 4. Recipient Email (maps to $receiverEmail)
                    $amount           // 5. Gift amount (maps to $value)
                    // Note: $senderName, $giftMessage, $deliveryDate are NOT passed to the constructor
                    // as per the provided EGift class definition. If you need these within the EGift
                    // object (e.g., for sending an email later), the EGift class constructor and
                    // properties need to be updated to accept and store them.
                );

                // Save the gift card to the database (using the save() method from EGift class)
                // The save() method in EGift class is assumed to be corrected to only insert
                // into columns that exist: CardID, UserID, Amount, RecipientEmail.
                if ($egift->save()) {
                    // --- Success ---
                    // At this point, the record is in the 'egiftcards' table.
                    // Additional actions should happen here:
                    // 1. Send email notification to $recipientEmail.
                    //    You'll need $giftID, $amount, $senderName, $giftMessage, $deliveryDate for the email.
                    //    Since $senderName, $giftMessage, $deliveryDate weren't passed to the EGift object,
                    //    use the local variables collected from $_POST:
                    //    sendGiftCardEmail($recipientEmail, $amount, $giftID, $senderName, $giftMessage, $deliveryDate);
                    // 2. Process Payment (integration with a payment gateway).
                    // 3. Log the transaction details (consider a separate 'transactions' or 'orders' table).


                    $db->commit(); // Commit the database transaction if everything is successful so far

                    $success = "Gift card for " . htmlspecialchars($recipientEmail) . " created successfully! Please proceed to payment.";
                    // You would typically redirect to a payment page or display payment options here
                    // header("Location: payment.php?giftID=" . urlencode($giftID));
                    // exit;

                    // Clearing POST data for simple refresh behaviour (less common with payment redirect)
                    $_POST = array();

                } else {
                    // --- Save Failed (Database Error in save() method) ---
                    $saveError = "Failed to save gift card to database.";
                    // Attempt to get a more specific error message from DBController
                    if ($db && method_exists($db, 'getLastError')) {
                        $specificError = $db->getLastError();
                        if (!empty($specificError)) {
                            $saveError = "Database error: " . $specificError;
                        }
                    }
                    throw new Exception($saveError); // Throw exception to be caught below for rollback
                }
            } catch (Exception $e) {
                // --- Transaction Rollback ---
                $db->rollback();
                // --- Error Handling ---
                $error = "Error processing your request: " . $e->getMessage();
                // Log the detailed error for backend debugging
                error_log("Egift processing error for customerID $customerID: " . $e->getMessage() . " - Exception Trace: " . $e->getTraceAsString());
            }
        }
    }
}

// --- Handle Potential Redirect After Success ---
// If redirected with success parameter (only happens if you uncommented and used the redirect logic)
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Gift card created successfully!";
    // Note: This GET parameter approach doesn't carry recipient email easily.
    // Using session flash messages or a redirect to a confirmation page with ID is better.
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
    <link href="css/index.css" rel="stylesheet"> <!-- Assuming this is for general styles -->
    <link href="css/egift.css" rel="stylesheet"> <!-- Specific styles for this page -->
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
</head>
<body>
<div class="main clearfix position-relative">
    <div class="main_1 clearfix position-absolute top-0 w-100">
        <section id="header">
            <nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
                <div class="container-xl">
                    <a class="navbar-brand fs-2 p-0 fw-bold text-white" href="index.php"> <!-- Changed to index.php -->
                        <i class="fa fa-pencil col_pink me-1 align-middle"></i> art <span class="col_pink span_1">WEB</span> <br> <span class="font_12 span_2">DIGITAL ART</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-0 ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a> <!-- Changed to index.php -->
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
                                    <li><a class="dropdown-item" href="egift.php">E-Gift Cards</a></li> <!-- Changed to egift.php -->
                                    <li><a class="dropdown-item border-0" href="physical-gifts.html">Physical Cards</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contact</a>
                            </li>
                            <!-- Login/Logout Link -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <?php endif; ?>
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
                            <p class="text-white mt-4">Give the gift of art with our customizable e-gift cards. Let them choose their perfect piece from our curated collection.</p>
                            <h6 class="mt-4 mb-0"><a class="button" href="#gift-cards-form"><i class="fa fa-gift bg-white col_pink p-3"> </i> <span class="ps-3 pe-3">View Gift Options</span></a></h6>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/2.jpg" class="d-block w-100" alt="Gift Cards">
                        <div class="carousel-caption d-md-block">
                            <h1 class="text-white font_60">Instant Delivery</h1>
                            <h4 class="text-white mt-3">Send Anytime, Anywhere</h4>
                            <p class="text-white mt-4">Our e-gift cards are delivered instantly via email, perfect for last-minute gifts or special occasions.</p>
                            <h6 class="mt-4 mb-0"><a class="button" href="#gift-cards-form"><i class="fa fa-bolt bg-white col_pink p-3"> </i> <span class="ps-3 pe-3">Send Today</span></a></h6>
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

<section id="gift-cards-form" class="gift-section p_4"> <!-- Changed ID to be unique -->
    <div class="container-xl">
        <div class="row port_1 text-center mb-4">
            <div class="col-md-12">
                <h1 class="font_60">ART E-GIFT CARDS</h1>
                <p>Give the perfect gift - let them choose their favorite artwork.</p>
                <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div> <!-- Allow HTML for login link -->
        <?php endif; ?>

        <?php if ($customerID !== null): // Only show options and form if logged in ?>
            <div class="row gift-options">
                <!-- Gift card selection boxes -->
                <div class="col-md-4">
                    <div class="gift-card" data-amount="50" data-image="img/5.jpg">
                        <div class="gift-card-img" style="background-image: url('img/5.jpg')">
                            <div class="gift-card-overlay"><h4 class="text-white">SELECT THIS CARD</h4></div>
                        </div>
                        <div class="gift-card-body">
                            <h3>Starter Collection</h3><p>Perfect for prints and small works</p>
                            <div class="gift-card-price">$50</div><button class="btn btn-outline-dark">Select</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gift-card" data-amount="150" data-image="img/6.jpg">
                        <div class="gift-card-img" style="background-image: url('img/6.jpg')">
                            <div class="gift-card-overlay"><h4 class="text-white">SELECT THIS CARD</h4></div>
                        </div>
                        <div class="gift-card-body">
                            <h3>Curator's Choice</h3><p>For original paintings and photographs</p>
                            <div class="gift-card-price">$150</div><button class="btn btn-outline-dark">Select</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gift-card" data-amount="500" data-image="img/7.jpg">
                        <div class="gift-card-img" style="background-image: url('img/7.jpg')">
                            <div class="gift-card-overlay"><h4 class="text-white">SELECT THIS CARD</h4></div>
                        </div>
                        <div class="gift-card-body">
                            <h3>Collector's Edition</h3><p>For premium artworks and sculptures</p>
                            <div class="gift-card-price">$500</div><button class="btn btn-outline-dark">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gift-customize mt-5" id="customizePanel" style="<?= (isset($_POST['egiftSend']) && empty($error) && empty($success)) || (!empty($error) && isset($_POST['egiftSend'])) ? 'display:block;' : 'display:none;' ?>">
            <!-- Logic to keep panel open on error, or if it was just submitted without success -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="gift-preview mb-3" id="giftPreview" style="background-image: url('<?= isset($_POST['previewImage']) ? htmlspecialchars($_POST['previewImage']) : 'img/5.jpg' ?>');"></div>
                        <input type="hidden" name="previewImage" id="hiddenPreviewImage" value="<?= isset($_POST['previewImage']) ? htmlspecialchars($_POST['previewImage']) : 'img/5.jpg' ?>">

                        <div class="form-group mb-3">
                            <label>Choose Design</label>
                            <div class="row mt-2">
                                <div class="col-3">
                                    <div class="design-option" data-image="img/5.jpg" style="background-image: url('img/5.jpg');"></div>
                                </div>
                                <div class="col-3">
                                    <div class="design-option" data-image="img/6.jpg" style="background-image: url('img/6.jpg');"></div>
                                </div>
                                <div class="col-3">
                                    <div class="design-option" data-image="img/7.jpg" style="background-image: url('img/7.jpg');"></div>
                                </div>
                                <div class="col-3">
                                    <div class="design-option" data-image="img/8.jpg" style="background-image: url('img/8.jpg');"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-4">Personalize Your E-Gift</h3>
                        <form method="POST" action="egift.php#customizePanel"> <!-- Action to return to the form section -->
                            <!-- RECIPIENT NAME INPUT REMOVED -->

                            <div class="form-group mb-3">
                                <label for="recipientEmail">Recipient's Email *</label>
                                <input type="email" class="form-control" id="recipientEmail" name="recipientEmail"
                                       placeholder="Enter recipient's email" required
                                       value="<?= isset($_POST['recipientEmail']) ? htmlspecialchars($_POST['recipientEmail']) : '' ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="senderName">Your Name (Sender) *</label>
                                <input type="text" class="form-control" id="senderName" name="senderName"
                                       placeholder="Enter your name" required
                                       value="<?= isset($_POST['senderName']) ? htmlspecialchars($_POST['senderName']) : '' ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="giftMessage">Message (Optional)</label>
                                <textarea class="form-control" id="giftMessage" name="giftMessage" rows="3"
                                          placeholder="Add a personal message (max 250 characters)" maxlength="250"><?= isset($_POST['giftMessage']) ? htmlspecialchars($_POST['giftMessage']) : '' ?></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="deliveryDate">Delivery Date (Optional)</label>
                                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate"
                                       value="<?= isset($_POST['deliveryDate']) ? htmlspecialchars($_POST['deliveryDate']) : '' ?>">
                                <small class="form-text text-muted">Leave blank for instant delivery.</small>
                            </div>
                            <div class="form-group mb-5">
                                <label for="giftAmount">Gift Amount ($10 - $1500) *</label>
                                <input type="number" name="amount" min="10" max="1500" step="1" class="form-control" id="giftAmount"
                                       placeholder="Enter gift amount" required
                                       value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>">
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-primary btn-lg" id="checkoutBtn" type="submit" name="egiftSend">Send E-Gift</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php else: // Show login message if not logged in ?>
            <div class="text-center py-5">
                <p class="lead">You must be logged in to purchase an e-gift card.</p>
                <a href="login.php" class="btn btn-lg bg_pink text-white">Login or Register</a>
            </div>
        <?php endif; ?>

        <div class="row gift-features text-center mt-5 pt-4">
            <div class="col-md-4">
                <div class="gift-feature-icon"><i class="fa fa-gift"></i></div>
                <h4>Flexible Gifting</h4>
                <p>Let your recipient choose their perfect artwork.</p>
            </div>
            <div class="col-md-4">
                <div class="gift-feature-icon"><i class="fa fa-bolt"></i></div>
                <h4>Instant Delivery</h4>
                <p>Email delivery for immediate gifting.</p>
            </div>
            <div class-="col-md-4">
                <div class="gift-feature-icon"><i class="fa fa-calendar"></i></div>
                <h4>Schedule Delivery</h4>
                <p>Send on a special date.</p>
            </div>
        </div>
    </div>
</section>

<footer class="p_3 bg-dark text-white"> <!-- Simplified footer -->
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0">© <?php echo date("Y"); ?> Art Web. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const giftCards = document.querySelectorAll('.gift-card');
    const customizePanel = document.getElementById('customizePanel');
    const giftPreview = document.getElementById('giftPreview');
    const hiddenPreviewImageInput = document.getElementById('hiddenPreviewImage'); // For retaining preview image on POST
    const giftAmountInput = document.getElementById('giftAmount');
    const checkoutBtn = document.getElementById('checkoutBtn');


    giftCards.forEach(card => {
        card.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image');
            giftPreview.style.backgroundImage = `url('${imageUrl}')`;
            if(hiddenPreviewImageInput) hiddenPreviewImageInput.value = imageUrl;

            const amount = this.getAttribute('data-amount');
            giftAmountInput.value = amount;

            // Ensure the customize panel is shown
            customizePanel.style.display = 'block';

            // Scroll to panel
            customizePanel.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Optional: Add 'selected' class for visual feedback
            giftCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    const designOptions = document.querySelectorAll('.design-option');
    designOptions.forEach(option => {
        // Apply base styles via JS if not reliably in CSS
        option.style.height = '60px';
        option.style.backgroundSize = 'cover';
        option.style.cursor = 'pointer';
        option.style.border = '2px solid #ddd'; // Default border
        // Add click listener
        option.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image');
            giftPreview.style.backgroundImage = `url('${imageUrl}')`;
            if(hiddenPreviewImageInput) hiddenPreviewImageInput.value = imageUrl;

            // Optional: Add 'selected' border to design options
             designOptions.forEach(d => d.style.border = '2px solid #ddd');
             this.style.border = '2px solid #f50057'; // Highlight selected design
        });
    });
     // Highlight initial/posted design option on load
    const initialPreviewImage = giftPreview.style.backgroundImage.replace('url("', '').replace('")', '');
    designOptions.forEach(option => {
         if (option.getAttribute('data-image') === initialPreviewImage) {
              option.style.border = '2px solid #f50057';
         }
    });


    const deliveryDateInput = document.getElementById('deliveryDate');
    if (deliveryDateInput) {
        const today = new Date();
        const yyyy = today.getFullYear();
        let mm = today.getMonth() + 1; // Months start at 0!
        let dd = today.getDate();
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        const formattedToday = yyyy + '-' + mm + '-' + dd;
        deliveryDateInput.setAttribute('min', formattedToday);
    }

     // Disable submit button if not logged in (redundant with server-side but good UX)
    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    if (!isLoggedIn && checkoutBtn) {
        checkoutBtn.disabled = true;
        // Optionally change text or show tooltip
        // checkoutBtn.textContent = 'Login to Send';
    }


    // Sticky navbar logic
    var navbar_sticky = document.getElementById("navbar_sticky");
    if (navbar_sticky) {
        var sticky = navbar_sticky.offsetTop;
        var navbar_height = navbar_sticky.offsetHeight; // Use the element's calculated height

        window.onscroll = function() { stickyNavbarFunction() };

        function stickyNavbarFunction() {
          if (window.pageYOffset >= sticky) {
            navbar_sticky.classList.add("sticky");
            // Only add padding if the navbar wasn't sticky on page load
            if (document.body.style.paddingTop === '' || document.body.style.paddingTop === '0px') {
                 document.body.style.paddingTop = navbar_height + 'px';
            }

          } else {
            navbar_sticky.classList.remove("sticky");
            document.body.style.paddingTop = '0';
          }
        }
        // Call on load in case page is already scrolled
        if (window.pageYOffset >= sticky) {
            stickyNavbarFunction();
        }
    }

});
</script>

</body>
</html>