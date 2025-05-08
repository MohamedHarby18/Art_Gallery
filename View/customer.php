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
  <!-- Navbar section -->
  <div class="main clearfix position-relative">
    <div class="main_1 clearfix position-absolute top-0 w-100">
      <section id="header">
        <nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
          <div class="container-xl">
            <a class="navbar-brand fs-2 p-0 fw-bold text-white" href="../index.php">
              <i class="fa fa-pencil col_pink me-1 align-middle"></i> Arteon 
              <span class="col_pink span_1">WEB</span><br>
              <span class="font_12 span_2">ARTS</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mb-0 ms-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="events.php">Events</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    All Arts
                  </a>
                  <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="product.php">All Products</a></li>
                    <li><a class="dropdown-item border-0" href="#">Paintings</a></li>
                    <li><a class="dropdown-item border-0" href="#">Sculptures</a></li>
                    <li><a class="dropdown-item border-0" href="#">Photography</a></li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="artadvisor.php">Art Advisor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="egift.php">eGift</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="customer.php">My Account</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </section>
    </div>
  </div>
<!--end nav-->

  <section id="profile-header" class="p_4">
    <div class="container-xl">
      <div class="row">
        <div class="col-md-12">
          <div class="profile-header-container">
            <div class="profile-cover" style="background-image: url('img/customer-cover.jpg')"></div>
            <div class="profile-info">
              <div class="profile-avatar">
                <img src="img/customer-avatar.jpg" alt="Customer Name">
              </div>
              <div class="profile-details">
                <h1 class="customer-name">Alex Morgan</h1>
                <p class="customer-title">Art Collector & Enthusiast</p>
                <div class="customer-location">
                  <i class="fa fa-map-marker col_pink me-1"></i> Seattle, Washington
                </div>
                <div class="customer-meta">
                  <span><i class="fa fa-star col_pink me-1"></i> Member since 2020</span>
                  <span class="ms-3"><i class="fa fa-check-circle col_pink me-1"></i> Verified Collector</span>
                </div>
              </div>
              <div class="profile-actions">
                <button class="btn btn-outline-pink me-2"><i class="fa fa-cog me-1"></i> Edit Profile</button>
                <button class="btn btn-pink"><i class="fa fa-sign-out me-1"></i> Logout</button>
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
              <h3>Welcome back, Alex!</h3>
              <p>You have 3 new notifications and 1 order being processed.</p>
            </div>

            <div class="dashboard-cards">
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="card-content">
                  <div class="card-number">12</div>
                  <div class="card-label">Total Orders</div>
                </div>
              </div>
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-heart"></i>
                </div>
                <div class="card-content">
                  <div class="card-number">8</div>
                  <div class="card-label">Wishlist Items</div>
                </div>
              </div>
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-star"></i>
                </div>
                <div class="card-content">
                  <div class="card-number">5</div>
                  <div class="card-label">Favorite Artists</div>
                </div>
              </div>
              <div class="dashboard-card">
                <div class="card-icon">
                  <i class="fa fa-trophy"></i>
                </div>
                <div class="card-content">
                  <div class="card-number">Gold</div>
                  <div class="card-label">Collector Tier</div>
                </div>
              </div>
            </div>

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
                <div class="order-row">
                  <div class="order-item">#AW-1256</div>
                  <div class="order-item">Jun 15, 2023</div>
                  <div class="order-item">1</div>
                  <div class="order-item">$450.00</div>
                  <div class="order-item"><span class="status shipped">Shipped</span></div>
                  <div class="order-item"><a href="#" class="btn btn-sm btn-outline-pink">Track</a></div>
                </div>
                <div class="order-row">
                  <div class="order-item">#AW-1248</div>
                  <div class="order-item">May 28, 2023</div>
                  <div class="order-item">2</div>
                  <div class="order-item">$720.00</div>
                  <div class="order-item"><span class="status delivered">Delivered</span></div>
                  <div class="order-item"><a href="#" class="btn btn-sm btn-outline-pink">Review</a></div>
                </div>
                <div class="order-row">
                  <div class="order-item">#AW-1235</div>
                  <div class="order-item">Apr 12, 2023</div>
                  <div class="order-item">1</div>
                  <div class="order-item">$275.00</div>
                  <div class="order-item"><span class="status delivered">Delivered</span></div>
                  <div class="order-item"><a href="#" class="btn btn-sm btn-outline-pink">Review</a></div>
                </div>
              </div>
            </div>

            <div class="profile-section">
              <div class="section-header">
                <h4>Recently Viewed</h4>
                <a href="#" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
              </div>
              <div class="viewed-items">
                <div class="viewed-item">
                  <img src="img/5.jpg" alt="Urban Rhythm">
                  <div class="viewed-info">
                    <h5>Urban Rhythm</h5>
                    <p class="artist">Sarah Johnson</p>
                    <p class="price">$1,200</p>
                  </div>
                </div>
                <div class="viewed-item">
                  <img src="img/8.jpg" alt="Metropolis">
                  <div class="viewed-info">
                    <h5>Metropolis</h5>
                    <p class="artist">Michael Chen</p>
                    <p class="price">$350</p>
                  </div>
                </div>
                <div class="viewed-item">
                  <img src="img/11.jpg" alt="Nature Fragments">
                  <div class="viewed-info">
                    <h5>Nature Fragments</h5>
                    <p class="artist">Emily Davis</p>
                    <p class="price">$950</p>
                  </div>
                </div>
                <div class="viewed-item">
                  <img src="img/14.jpg" alt="Digital Explorations">
                  <div class="viewed-info">
                    <h5>Digital Explorations</h5>
                    <p class="artist">Robert Wilson</p>
                    <p class="price">$1,800</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="profile-section">
              <div class="section-header">
                <h4>Recommended For You</h4>
                <a href="#" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
              </div>
              <div class="recommended-items">
                <div class="recommended-item">
                  <img src="img/6.jpg" alt="Color Waves">
                  <div class="recommended-info">
                    <h5>Color Waves</h5>
                    <p class="artist">Sarah Johnson</p>
                    <p class="price">$950</p>
                    <button class="btn btn-sm btn-pink">Add to Cart</button>
                  </div>
                </div>
                <div class="recommended-item">
                  <img src="img/9.jpg" alt="Harmony in Chaos">
                  <div class="recommended-info">
                    <h5>Harmony in Chaos</h5>
                    <p class="artist">Michael Chen</p>
                    <p class="price">$750</p>
                    <button class="btn btn-sm btn-pink">Add to Cart</button>
                  </div>
                </div>
                <div class="recommended-item">
                  <img src="img/12.jpg" alt="Abstract Composition">
                  <div class="recommended-info">
                    <h5>Abstract Composition</h5>
                    <p class="artist">Emily Davis</p>
                    <p class="price">$1,100</p>
                    <button class="btn btn-sm btn-pink">Add to Cart</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="footer" class="pt-3 pb-3">
    <!-- Your existing footer code here -->
  </section>

</body>

</html>