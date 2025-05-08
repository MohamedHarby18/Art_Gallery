display art gallery
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Virtual Gallery | Artist Exhibition Space</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    
</head>
<body class="theme-classic">

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

<!-- Gallery Hero Section -->
<section class="gallery-hero">
    <div class="container">
        <h1 class="gallery-title">Urban Perspectives</h1>
        <p class="lead">A Virtual Exhibition by <strong>Marcus Johnson</strong></p>
    </div>
</section>

<!-- Gallery Info Section -->
<section class="container">
    <div class="gallery-info">
        <p class="gallery-description">
            "Urban Perspectives" explores the dynamic interplay of light, shadow, and geometry in cityscapes. 
            This collection captures the essence of urban life through a unique lens, transforming ordinary 
            city scenes into extraordinary visual narratives. Each piece invites viewers to see the familiar 
            in unfamiliar ways.
        </p>
        
        <div class="gallery-meta">
            <div class="meta-item">
                <div class="meta-label">Exhibition Dates</div>
                <div class="meta-value">June 15 - August 30, 2023</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Artworks</div>
                <div class="meta-value">12 Pieces</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Theme</div>
                <div class="meta-value">Urban Exploration</div>
            </div>
        </div>
        
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary" onclick="changeTheme('classic')">Classic</button>
            <button type="button" class="btn btn-outline-secondary" onclick="changeTheme('modern')">Modern</button>
            <button type="button" class="btn btn-outline-secondary" onclick="changeTheme('minimal')">Minimal</button>
            <button type="button" class="btn btn-outline-secondary" onclick="changeTheme('dark')">Dark</button>
        </div>
    </div>
    
    <!-- Virtual Gallery Space -->
    <div class="gallery-space">
        <div class="gallery-wall wall-left"></div>
        <div class="gallery-wall wall-center"></div>
        <div class="gallery-wall wall-right"></div>
        
        <!-- Artwork Displays (positioned absolutely within the gallery space) -->
        <div class="artwork-display" style="width: 250px; height: 300px; left: 22%; top: 100px;">
            <img src="img/artwork1.jpg" alt="Metropolis Reflection">
            <div class="artwork-label">
                <div class="artwork-name">Metropolis Reflection</div>
                <div class="artwork-medium">Oil on Canvas, 2022</div>
            </div>
        </div>
        
        <div class="artwork-display" style="width: 300px; height: 200px; left: 25%; top: 450px;">
            <img src="img/artwork2.jpg" alt="Neon Crossroads">
            <div class="artwork-label">
                <div class="artwork-name">Neon Crossroads</div>
                <div class="artwork-medium">Acrylic, 2023</div>
            </div>
        </div>
        
        <div class="artwork-display" style="width: 200px; height: 350px; right: 18%; top: 80px;">
            <img src="img/artwork3.jpg" alt="Steel Canyon">
            <div class="artwork-label">
                <div class="artwork-name">Steel Canyon</div>
                <div class="artwork-medium">Mixed Media, 2021</div>
            </div>
        </div>
        
        <div class="artwork-display" style="width: 350px; height: 250px; left: 30%; top: 250px;">
            <img src="img/artwork4.jpg" alt="Dawn Over Downtown">
            <div class="artwork-label">
                <div class="artwork-name">Dawn Over Downtown</div>
                <div class="artwork-medium">Digital Painting, 2023</div>
            </div>
        </div>
    </div>
    
    <!-- Artwork List -->
    <h2 class="text-center mb-4">Featured Artworks</h2>
    
    <div class="artwork-list">
        <div class="artwork-card">
            <div class="artwork-card-img">
                <img src="img/artwork1.jpg" alt="Metropolis Reflection">
            </div>
            <div class="artwork-card-body">
                <h5 class="artwork-card-title">Metropolis Reflection</h5>
                <p class="artwork-card-meta">Oil on Canvas • 24" × 36" • 2022</p>
                <p class="artwork-card-price">$2,400</p>
                <a href="#" class="btn btn-sm bg_pink text-white mt-2">View Details</a>
            </div>
        </div>
        
        <div class="artwork-card">
            <div class="artwork-card-img">
                <img src="img/artwork2.jpg" alt="Neon Crossroads">
            </div>
            <div class="artwork-card-body">
                <h5 class="artwork-card-title">Neon Crossroads</h5>
                <p class="artwork-card-meta">Acrylic • 18" × 24" • 2023</p>
                <p class="artwork-card-price">$1,800</p>
                <a href="#" class="btn btn-sm bg_pink text-white mt-2">View Details</a>
            </div>
        </div>
        
        <div class="artwork-card">
            <div class="artwork-card-img">
                <img src="img/artwork3.jpg" alt="Steel Canyon">
            </div>
            <div class="artwork-card-body">
                <h5 class="artwork-card-title">Steel Canyon</h5>
                <p class="artwork-card-meta">Mixed Media • 30" × 48" • 2021</p>
                <p class="artwork-card-price">$3,200</p>
                <a href="#" class="btn btn-sm bg_pink text-white mt-2">View Details</a>
            </div>
        </div>
        
        <div class="artwork-card">
            <div class="artwork-card-img">
                <img src="img/artwork4.jpg" alt="Dawn Over Downtown">
            </div>
            <div class="artwork-card-body">
                <h5 class="artwork-card-title">Dawn Over Downtown</h5>
                <p class="artwork-card-meta">Digital Painting • 24" × 36" • 2023</p>
                <p class="artwork-card-price">$1,200</p>
                <a href="#" class="btn btn-sm bg_pink text-white mt-2">View Details</a>
            </div>
        </div>
    </div>
    
    <!-- Artist Profile -->
    <div class="artist-profile">
        <div class="artist-avatar">
            <img src="img/artist-marcus.jpg" alt="Marcus Johnson">
        </div>
        <div class="artist-info">
            <h3 class="artist-name">Marcus Johnson</h3>
            <p class="artist-bio">
                Marcus Johnson is a contemporary urban artist based in New York City. His work explores the 
                architectural beauty and social dynamics of modern cities. With a background in both fine arts 
                and urban planning, Marcus brings a unique perspective to his depictions of urban environments. 
                His work has been exhibited in galleries across North America and Europe.
            </p>
            <div class="artist-social">
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-globe"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-5 bg-dark text-white mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Virtual Galleries</h5>
                <p>Platform for artists to create and share their virtual exhibitions. Showcase your work in customizable gallery spaces.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.html" class="text-white">Home</a></li>
                    <li><a href="galleries.html" class="text-white">Browse Galleries</a></li>
                    <li><a href="create-gallery.html" class="text-white">Create Your Gallery</a></li>
                    <li><a href="artists.html" class="text-white">Featured Artists</a></li>
                    <li><a href="about.html" class="text-white">About Us</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Contact</h5>
                <p>Email: info@virtualgallery.com<br>
                Phone: (123) 456-7890</p>
                <div class="social-icons">
                    <a href="#" class="text-white me-3"><i class="fa fa-instagram"></i></a>
                    <a href="#" class="text-white me-3"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="text-white"><i class="fa fa-pinterest"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; 2023 Virtual Gallery. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">
                    <a href="#" class="text-white me-3">Privacy Policy</a>
                    <a href="#" class="text-white me-3">Terms of Service</a>
                    <a href="#" class="text-white">FAQ</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript -->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    // Change gallery theme
    function changeTheme(theme) {
        document.body.className = 'theme-' + theme;
    }
    
    // Make navbar sticky
    window.onscroll = function() {stickyNavbar()};
    
    var navbar = document.getElementById("navbar_sticky");
    var sticky = navbar.offsetTop;
    var navbar_height = navbar.offsetHeight;
    
    function stickyNavbar() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
            document.body.style.paddingTop = navbar_height + 'px';
        } else {
            navbar.classList.remove("sticky");
            document.body.style.paddingTop = '0';
        }
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Could add more interactive features here
    });
</script>
</body>
</html>