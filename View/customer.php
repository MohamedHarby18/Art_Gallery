<?php

require_once __DIR__ . '/../Model/Classes/customer.php';
require_once __DIR__ . "/../Controller/DBController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize DBController
$db = new DBController();

// Get current user ID from session
$userId = $_SESSION["user_id"] ?? null;
//$userId = 8;
// Initialize variables
$userData = null;
$purchases = [];
$recommendedArtworks = [];
$totalOrders = 0;
$wishlistItems = 0;
$favoriteArtists = 0;

if ($userId) {
  try {
        // Get user info
    $userData = $db->selectSingle("SELECT * FROM users WHERE UserID = ?", [$userId]);
        
        // Get user purchases
    $purchases = $db->select(
      "SELECT p.PurchaseID, p.Date, p.Quantity, 
      a.Title, a.Price, a.Image
      FROM purchases p 
      JOIN artworks a ON p.ArtworkID = a.ArtworkID 
      WHERE p.UserID = ?
      ORDER BY p.Date DESC",
     [$userId] ) ?? [];
        
        // Get total orders count
        // In your data fetching section
    $totalOrdersResult = $db->selectSingle(
      "SELECT COUNT(*) as count FROM purchases WHERE UserID = ?",
      [$userId]  );
        
    $totalOrders = $totalOrdersResult['count'] ?? 0;
        // Get recommended artworks (simple recommendation based on random items not purchased)
    $recommendedArtworks = $db->select(
    "SELECT a.ArtworkID, a.Title, a.Catagory, a.Price, a.Image 
     FROM artworks a 
     WHERE a.ArtworkID NOT IN (
         SELECT ArtworkID FROM purchases WHERE UserID = ?
     )
     AND a.numberInStock > 0
     ORDER BY RAND()
     LIMIT 3",
    [$userId]
  ) ?? []; // Ensure this returns array of arrays
        
        // Get wishlist items count (placeholder - would need a wishlist table)
    $wishlistItems = 0;
        
        // Get favorite artists count (placeholder - would need a favorites table)
    $favoriteArtists = 0;

    } catch (Exception $e) {
        error_log("Error fetching user data: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Profile | Art Web</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/global.css" rel="stylesheet">
  <link href="css/customer.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php include './includes/header.php'; ?>

  <section id="profile-header" class="p_4">
    <div class="container-xl">
      <div class="row">
        <div class="col-md-12">
          <div class="profile-header-container">
            <div class="profile-cover" style="background-image: url('img/customer-cover.jpg')"></div>
            <div class="profile-info">
              <div class="profile-avatar">
                <img src="img/customer-avatar.jpg" alt="Customer Avatar">
              </div>
              <div class="profile-details">
                <h1 class="customer-name">
                  <?php echo isset($userData['Fname']) ? htmlspecialchars($userData['Fname']) . ' ' . htmlspecialchars($userData['Lname']) : 'Guest'; ?>
                </h1>
                <p class="customer-title">Art Collector & Enthusiast</p>
                <div class="customer-location">
                  <i class="fa fa-map-marker col_pink me-1"></i> 
                  <?php echo isset($userData['City']) ? htmlspecialchars($userData['City']) : 'Unknown Location'; ?>
                </div>
                <div class="customer-meta">
                  <?php if (isset($userData['created_at'])): ?>
                    <span><i class="fa fa-star col_pink me-1"></i> Member since <?php echo date('Y', strtotime($userData['created_at'])); ?></span>
                  <?php endif; ?>
                  <span class="ms-3"><i class="fa fa-check-circle col_pink me-1"></i> Verified Collector</span>
                </div>
              </div>
              <div class="profile-actions">
                <<button class="btn btn-outline-pink me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                  <i class="fa fa-cog me-1"></i> Edit Profile
                </button>
                <?php if (isset($_SESSION["user_id"])): ?>
                  <a href="logout.php" class="btn btn-pink">
                    <i class="fa fa-sign-out me-1"></i> Logout
                  </a>
                <?php else: ?>
                  <a href="login.php" class="btn btn-pink">
                    <i class="fa fa-sign-in me-1"></i> Login
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="profile-content" class="p_4 pt-0">
    <div class="container-xl">
      <div class="row">
        <div class="col-lg-3">
          <div class="profile-sidebar">
            <div class="sidebar-section">
              <h4 class="sidebar-title">My Account</h4>
              <ul class="sidebar-menu">
                <li class="active"><a href="#"><i class="fa fa-user col_pink me-2"></i> Profile Overview</a></li>
                <li><a href="#"><i class="fa fa-shopping-bag col_pink me-2"></i> Orders & Purchases</a></li>
                <li><a href="#"><i class="fa fa-heart col_pink me-2"></i> Wishlist</a></li>
                <li><a href="#"><i class="fa fa-map-marker col_pink me-2"></i> Address Book</a></li>
                <li><a href="#"><i class="fa fa-credit-card col_pink me-2"></i> Payment Methods</a></li>
                <li><a href="#"><i class="fa fa-bell col_pink me-2"></i> Notifications</a></li>
                <li><a href="#"><i class="fa fa-lock col_pink me-2"></i> Security</a></li>
              </ul>
            </div>

            <div class="sidebar-section preferences-section">
              <h4 class="sidebar-title">Preferences</h4>
              <div class="preference-item">
                <label>Art Preferences</label>
                <div class="preference-tags">
                  <span class="preference-tag">Abstract</span>
                  <span class="preference-tag">Contemporary</span>
                  <span class="preference-tag">Photography</span>
                </div>
              </div>
              <div class="preference-item">
                <label>Favorite Artists</label>
                <div class="artist-tags">
                  <span class="artist-tag">Sarah Johnson</span>
                  <span class="artist-tag">Michael Chen</span>
                  <span class="artist-tag">Emily Davis</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-9">
    <div class="profile-main">
        <div class="welcome-message">
            <h3>Welcome back, <?php echo isset($userData['Fname']) ? htmlspecialchars($userData['Fname']) : 'Guest'; ?>!</h3>
            <p>
                <?php if ($totalOrders > 0): ?>
                    You have <?php echo $totalOrders; ?> total <?php echo ($totalOrders === 1) ? 'order' : 'orders'; ?>.
                    <?php if (!empty($purchases)): ?>
                        (Showing <?php echo count($purchases); ?> recent <?php echo (count($purchases) === 1) ? 'purchase' : 'purchases'; ?>)
                    <?php endif; ?>
                <?php else: ?>
                    You have no purchases yet.
                <?php endif; ?>
            </p>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="card-content">
                    <div class="card-number"><?php echo $totalOrders; ?></div>
                    <div class="card-label">Total Orders</div>
                </div>
            </div>
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-heart"></i>
                </div>
                <div class="card-content">
                  <div class="card-number"><?php echo $wishlistItems; ?></div>
                  <div class="card-label">Wishlist Items</div>
                </div>
              </div>
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-star"></i>
                </div>
                <div class="card-content">
                  <div class="card-number"><?php echo $favoriteArtists; ?></div>
                  <div class="card-label">Favorite Artists</div>
                </div>
              </div>
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-trophy"></i>
                </div>
                <div class="card-content">
                  <div class="card-number">
                    <?php 
                      if ($totalOrders >= 10) echo 'Platinum';
                      elseif ($totalOrders >= 5) echo 'Gold';
                      else echo 'Silver';
                    ?>
                  </div>
                  <div class="card-label">Collector Tier</div>
                </div>
              </div>
            </div>

            <?php if (!empty($purchases) && is_array($purchases)): ?>
    <div class="profile-section">
        <div class="section-header">
            <h4>Recent Orders</h4>
            <a href="#" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="orders-table">
            <div class="order-header">
                <div class="header-item">Order #</div>
                <div class="header-item">Date</div>
                <div class="header-item">Items</div>
                <div class="header-item">Total</div>
                <div class="header-item">Status</div>
                <div class="header-item">Action</div>
            </div>
            
            <?php foreach ($purchases as $purchase): ?>
                <?php if (is_array($purchase) && !empty($purchase['PurchaseID'])): ?>
                    <div class="order-row">
                        <div class="order-item">#<?= $purchase['PurchaseID'] ?></div>
                        <div class="order-item">
                            <?= ($purchase['Date'] && $purchase['Date'] !== '0000-00-00') 
                                ? date('M j, Y', strtotime($purchase['Date'])) 
                                : 'Pending' ?>
                        </div>
                        <div class="order-item"><?= $purchase['Quantity'] ?? 1 ?></div>
                        <div class="order-item">
                            $<?= number_format(($purchase['Price'] ?? 0) * ($purchase['Quantity'] ?? 1), 2) ?>
                        </div>
                        <div class="order-item"><span class="status shipped">Shipped</span></div>
                        <div class="order-item">
                            <a href="#" class="btn btn-sm btn-outline-pink">Track</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="order-row error">
                        <div class="order-item" colspan="6">
                            Could not load purchase details
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info mt-3">No purchases found</div>
  <?php endif; ?>

            <?php if (!empty($recommendedArtworks) && is_array($recommendedArtworks)): ?>
    <div class="profile-section">
        <div class="section-header">
            <h4>Recommended For You</h4>
            <a href="#" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="recommended-items">
            <?php foreach ($recommendedArtworks as $artwork): ?>
                <?php if (is_array($artwork) && isset($artwork['ArtworkID'])): ?>
                    <div class="recommended-item">
                        <?php if (!empty($artwork['Image'])): ?>
                            <img src="<?= htmlspecialchars($artwork['Image']) ?>" 
                                 alt="<?= htmlspecialchars($artwork['Title'] ?? 'Artwork') ?>">
                        <?php endif; ?>
                        <div class="recommended-info">
                            <h5><?= htmlspecialchars($artwork['Title'] ?? 'Untitled') ?></h5>
                            <?php if (isset($artwork['Catagory'])): ?>
                                <p class="artist"><?= htmlspecialchars($artwork['Catagory']) ?></p>
                            <?php endif; ?>
                            <?php if (isset($artwork['Price'])): ?>
                                <p class="price">$<?= number_format((float)$artwork['Price'], 2) ?></p>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-pink">Add to Cart</button>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Debug output for invalid artwork data -->
                    <div style="display:none">
                        Invalid artwork data: <?= var_export($artwork, true) ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No recommendations available at this time</div>
  <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="footer" class="pt-3 pb-3">
    <?php include './includes/footer.php'; ?>
  </section>
<!-- Edit Profile Modal -->
  <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controller/update_profile.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" 
                               value="<?php echo htmlspecialchars($userData['Fname'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" 
                               value="<?php echo htmlspecialchars($userData['Lname'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" 
                               value="<?php echo htmlspecialchars($userData['phoneNumber'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" 
                               value="<?php echo htmlspecialchars($userData['City'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address"><?php echo htmlspecialchars($userData['Address'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-pink">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>