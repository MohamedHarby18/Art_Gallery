<?php
require_once '../Controller/DBController.php';
$db = new DBController();

// Get artist ID from URL or default to first artist
$artistId = isset($_GET['id']) ? intval($_GET['id']) : 3;

// Fetch artist data from users table
$artist = $db->select("SELECT * FROM users WHERE UserID = ? AND Artist = 1", [$artistId]);
if (!$artist || count($artist) === 0) {
    die("Artist not found");
}
$artist = $artist[0];

// Count artist's artworks
$artworksCount = $db->select("SELECT COUNT(*) as count FROM artworks WHERE ArtistID = ?", [$artistId]);
$artworksCount = $artworksCount ? $artworksCount[0]['count'] : 0;

// Get average rating if available
$avgRating = $db->select("SELECT AVG(rating) as avg_rating FROM reviews WHERE ArtworkID IN (SELECT ArtworkID FROM artworks WHERE ArtistID = ?)", [$artistId]);
$avgRating = $avgRating ? round($avgRating[0]['avg_rating'], 1) : 'No ratings';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - <?php echo htmlspecialchars($artist['Fname'] . ' ' . $artist['Lname']); ?> Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/artistprofile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
</head>

<body>
    <?php include './includes/header.php'; ?>

    <div class="main_2 clearfix">
        <section id="center" class="center_home">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/1.jpg" class="d-block w-100" alt="Artist Profile">
                        <div class="carousel-caption d-md-block">
                            <h1 class="text-white font_60">Artist Profile</h1>
                            <h4 class="text-white mt-3">Discover the creative journey</h4>
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
                <img src="img/artist.jpg" alt="<?php echo htmlspecialchars($artist['Fname']); ?>" class="artist-avatar">
                <h1 class="artist-name"><?php echo htmlspecialchars($artist['Fname'] . ' ' . $artist['Lname']); ?></h1>
                <div class="artist-location">
                    <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($artist['Address']); ?>
                </div>
                <div class="artist-social">
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-pinterest"></i></a>
                    <a href="#"><i class="fa fa-globe"></i></a>
                </div>
                <p class="artist-bio">
                    <?php echo htmlspecialchars($artist['Fname'] . ' ' . $artist['Lname']); ?> is a talented artist based in <?php echo htmlspecialchars($artist['Address']); ?>.
                    Contact at <?php echo htmlspecialchars($artist['Email']); ?> or <?php echo htmlspecialchars($artist['phoneNumber']); ?>.
                </p>
                <div class="artist-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $artworksCount; ?></div>
                        <div class="stat-label">Artworks</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $avgRating; ?></div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo date('Y', strtotime($artist['created_at'] ?? '2015')); ?></div>
                        <div class="stat-label">Year Started</div>
                    </div>
                </div>
            </div>

            <!-- Artist Tabs -->
            <ul class="nav nav-tabs artist-tabs" id="artistTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="artwork-tab" data-bs-toggle="tab" data-bs-target="#artwork" type="button" role="tab" aria-controls="artwork" aria-selected="true">Artwork</button>
                </li>
            </ul>
            <div class="tab-content" id="artistTabContent">
                <!-- Artwork Tab -->
                <div class="tab-pane fade show active" id="artwork" role="tabpanel" aria-labelledby="artwork-tab">
                    <div class="row">
                        <?php
                        // Fetch artist's artworks with error handling
                        try {
                            $artworks = $db->select("
    SELECT *
    FROM artworks
    WHERE ArtistID = ?
    ORDER BY created_at DESC
", [$artistId]);
                        } catch (Exception $e) {
                            error_log("Database error: " . $e->getMessage());
                            $artworks = false;
                        }

                        if ($artworks && count($artworks) > 0) {
                            foreach ($artworks as $artwork) {
                                // Handle image path
                                $imagePath = !empty($artwork['Image'])
                                    ? '../Images/artworks/' . htmlspecialchars($artwork['Image'])
                                    : '../Images/artworks/default-artwork.jpg';

                                // Handle category display
                                $category = htmlspecialchars(
                                    $artwork['CategoryName'] ??
                                        $artwork['Catagory'] ??
                                        'Uncategorized'
                                );

                                // Handle stock status
                                $stock = ($artwork['numberInStock'] > 0)
                                    ? '<span class="badge bg-success">In Stock</span>'
                                    : '<span class="badge bg-danger">Sold Out</span>';

                                // Truncate description
                                $description = !empty($artwork['Description'])
                                    ? (strlen($artwork['Description']) > 100
                                        ? substr(htmlspecialchars($artwork['Description']), 0, 100) . '...'
                                        : htmlspecialchars($artwork['Description']))
                                    : 'No description available';

                                echo '<div class="col-md-4 mb-4">
            <div class="artwork-card">
                <img src="' . $imagePath . '" 
                     alt="' . htmlspecialchars($artwork['Title']) . '" 
                     class="artwork-img img-fluid">
                <div class="artwork-details mt-2">
                    <h5 class="artwork-title">' . htmlspecialchars($artwork['Title']) . '</h5>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="artwork-price">$' . number_format($artwork['Price'], 2) . '</div>
                        ' . $stock . '
                    </div>
                    <div class="artwork-category small text-muted mb-2">' . 
    htmlspecialchars($artwork['Catagory'] ?? 'Uncategorized') . 
'</div>
                    <p class="artwork-desc small">' . $description . '</p>
                </div>
            </div>
        </div>';
                            }
                        } else {
                            echo '<div class="col-12 text-center py-5"><p>No artworks found for this artist.</p></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . './includes/footer.php'; ?>

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