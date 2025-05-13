<?php

 $mysqli = require __DIR__ . "/../Controller/controlDBauth.php";
 require_once '../Controller/DBController.php';
require_once '../Controller/DBArtworkManager.php'; // Include the new file
// Start session ONCE at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in via session
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}


// Get user data from the database
$userID = $_SESSION["user_id"];
$sql = "SELECT Artist, Advisor FROM users WHERE UserID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // User ID not found in DB
    header("Location: registration.php");
    exit;
}

$user = $result->fetch_assoc();

// Role-based redirection
if ($user["Advisor"] !== 1) {
    header("Location: index.php");
    exit;
}

$db = new DBController();
 
// --- Handle Messages from other pages (e.g., after adding/editing artwork) ---
$success_message = '';
$error_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message after displaying
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the message
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/artistprofile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../View/includes/header.php'; // Ensure this path is correct ?>

    <div class="main_2 clearfix">
        <section id="center" class="center_home">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/1.jpg" class="d-block w-100" alt="Artist Virtual gallery" style="max-height: 70vh;">
                        <div class="carousel-caption d-md-block">
                            <h1 class="text-white font_60">Best of the week🌟</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Artist Profile Section -->
    <section id="artist-profile" class="artist-section p_4">
        <div class="container-xl">
            <div class="artist-header text-center">
                <?php
                    $avatarPath = '..\Images\n\artist.png'; // Default avatar
                        
                ?>

                <div class="artist-social">
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-pinterest"></i></a>
                    <a href="#"><i class="fa fa-globe"></i></a>
                </div>
            
                <div class="artist-stats">
                  
                     <!-- <div class="stat-item">
                        <div class="stat-number"><?php echo $avgRating; ?></div>
                        <div class="stat-label">Average Rating</div>
                    </div> -->
                    
                </div>
                <div class="mt-4">
                    <a href="../Controller/manage_artwork.php" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add to the virtual gallery</a>
                    <!-- <a href="edit_artist_profile.php" class="btn btn-outline-primary ms-2">Edit My Profile</a> -->
                </div>
            </div>

            <!-- Display Success/Error Messages -->
            <?php if ($success_message): ?>
                <div class="alert alert-success mt-4"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="alert alert-danger mt-4"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>


            <h2 class="text-center mt-5 mb-4">My Artworks</h2>
            <div class="tab-content" id="artistTabContent">
                <div class="tab-pane fade show active" id="artwork" role="tabpanel" aria-labelledby="artwork-tab">
                    <div class="row">
                        <?php
                        $artworks = null;
                        try {
                            $artworks = $db->select("
                                SELECT ArtworkID, Title, Description, Catagory, Price, Image, numberInStock
                                FROM artworks
                                WHERE ArtistID = ?
                                ORDER BY created_at DESC
                            ", [$artistId]);
                        } catch (Exception $e) {
                            error_log("Database error fetching artworks: " . $e->getMessage());
                        }

                        if ($artworks && count($artworks) > 0) {
                            foreach ($artworks as $artwork_item) { // Renamed to avoid conflict
                                $imagePath = '../Images/artworks/default-artwork.jpg'; // Default
                                if (!empty($artwork_item['Image'])) {
                                    $potentialImagePath = '../Images/artworks/' . htmlspecialchars($artwork_item['Image']);
                                    if (file_exists(dirname(__DIR__) . '/Images/artworks/' . $artwork_item['Image'])) {
                                        $imagePath = $potentialImagePath;
                                    } else {
                                         error_log("Artwork image not found for ArtistID {$artistId}, ArtworkID {$artwork_item['ArtworkID']}: " . dirname(__DIR__) . '/Images/artworks/' . $artwork_item['Image']);
                                    }
                                }

                                $category = htmlspecialchars($artwork_item['Catagory'] ?? 'Uncategorized');
                                $stock = ($artwork_item['numberInStock'] > 0)
                                    ? '<span class="badge bg-success">In Stock</span>'
                                    : '<span class="badge bg-danger">Sold Out</span>';
                                $description = !empty($artwork_item['Description'])
                                    ? (strlen($artwork_item['Description']) > 100 ? substr(htmlspecialchars($artwork_item['Description']), 0, 100) . '...' : htmlspecialchars($artwork_item['Description']))
                                    : 'No description available';

                                echo '
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 artwork-card">
                                        <img src="' . $imagePath . '"
                                             alt="' . htmlspecialchars($artwork_item['Title']) . '"
                                             class="card-img-top artwork-img-custom">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title artwork-title text-dark">' . htmlspecialchars($artwork_item['Title']) . '</h5>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="artwork-price fw-bold">$' . number_format($artwork_item['Price'], 2) . '</div>
                                                ' . $stock . '
                                            </div>
                                            <div class="artwork-category small text-muted mb-2">' . $category . '</div>
                                            <p class="artwork-desc text-dark small flex-grow-1">' . $description . '</p>
                                            <div class="mt-auto artwork-actions">
                                                <a href="artwork_detail.php?id=' . htmlspecialchars($artwork_item['ArtworkID']) . '" class="btn btn-sm btn-outline-info me-1">View</a>
                                                <a href="../Controller/manage_artwork.php?action=edit&id=' . htmlspecialchars($artwork_item['ArtworkID']) . '" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                                <a href="../Controller/manage_artwork.php?action=delete&id=' . htmlspecialchars($artwork_item['ArtworkID']) . '" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this artwork?\');">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '../includes/footer.php'; ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.onscroll = function() {
                myFunction()
            };

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