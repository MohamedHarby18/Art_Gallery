<?php
// login.php
require_once '../Controller/controlDB.php'; // Includes session_start()

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // header('Location: account.php'); // Redirect to account page or dashboard
    // For now, let's redirect to index.html or a generic logged-in page
    // header('Location: index.html');
    // exit;
}
///whatisthis
$errors = $_SESSION['errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <style>
        .error-message { color: red; font-size: 0.9em; margin-top: 5px; }
        .form-group { margin-bottom: 1.2rem; /* Increased margin */ }
    </style>
</head>
<body>
<div class="main clearfix position-relative">
 <div class="main_1 clearfix position-absolute top-0 w-100">
   <section id="header">
<nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
  <div class="container-xl">
    <a class="navbar-brand fs-2 p-0 fw-bold text-white" href="index.html"><i class="fa fa-pencil col_pink me-1 align-middle"></i> art <span class="col_pink span_1">WEB</span> <br> <span class="font_12 span_2">DIGITAL ART</span></a>
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
        <li class="nav-item">
          <a class="nav-link" href="contact.html">Contact</a>
        </li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="account.php">Account</a> <!-- Link to user account page -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link active" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="registration.php">Register</a>
          </li>
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
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/1.jpg" class="d-block w-100" alt="Login">
      <div class="carousel-caption d-md-block">
         <h1 class="text-white font_60">Welcome Back</h1>
         <h4 class="text-white mt-3">Access Your Art Collection</h4>
         <p class="text-white mt-4">Sign in to view your saved favorites, track orders, and manage your account.</p>
      </div>
    </div>
  </div>
</div>
</section>
 </div>
</div>

<!-- Login Section -->
<section id="login" class="login-section p_4">
 <div class="container-xl">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="login-card">
                <div class="login-header">
                    <h3 class="mb-0">SIGN IN</h3>
                </div>
                <div class="login-body">
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($errors['general']); ?></div>
                    <?php endif; ?>

                    <form id="loginForm" action="process_login.php" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" required>
                            <?php if (isset($errors['email'])): ?><div class="error-message invalid-feedback d-block"><?php echo htmlspecialchars($errors['email']); ?></div><?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password" required>
                            <?php if (isset($errors['password'])): ?><div class="error-message invalid-feedback d-block"><?php echo htmlspecialchars($errors['password']); ?></div><?php endif; ?>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" <?php echo isset($old_input['remember']) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-login">LOGIN</button>
                        
                        <div class="login-links">
                            <a href="forgot-password.html">Forgot password?</a>
                            <span class="mx-2">|</span>
                            <a href="registration.php">Create account</a>
                        </div>
                        
                        <div class="divider">
                            <span class="divider-text">OR</span>
                        </div>
                        
                        <div class="social-login">
                            <p class="mb-3">Sign in with social media</p>
                            <a href="#" class="social-btn"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="social-btn"><i class="fa fa-google"></i></a>
                            <a href="#" class="social-btn"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="social-btn"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
</section>

<!-- Footer Section (same as before) -->
<section id="footer" class="pt-3 pb-3">
 <div class="container-fluid">
   <div class="row footer_1">
    <div class="col-md-3">
     <div class="footer_1i">
      <hr class="line_1">
      <h5 class="mb-3">ABOUT</h5>
      <p>Phasellus et nisl tellus. Etiam facilisis eu nisi scelerisque faucibus. Proin semper suscipit magna, nec imperdiet lacus semper vitae. Sed hendrerit enim non justo posuere placerat eget purus mauris.</p>
      <p>Etiam facilisis eu nisi scelerisque faucibus. Proin semper suscipit magna, nec imperdiet lacus semper.</p>
     </div>
    </div>
    <div class="col-md-3">
     <div class="footer_1i">
      <hr class="line_1">
      <h5 class="mb-3">RECENT WORKS</h5>
      <div class="footer_1i1 row">
       <div class="col-md-4 col-4 p-0">
        <div class="footer_1i1i">
          <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <a href="#"><img src="img/30.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
        </div>
       </div>
       <div class="col-md-4 col-4 p-0">
        <div class="footer_1i1i">
          <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <a href="#"><img src="img/31.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
        </div>
       </div>
       <div class="col-md-4 col-4 p-0">
        <div class="footer_1i1i">
          <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <a href="#"><img src="img/32.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
        </div>
       </div>
      </div>
      <div class="footer_1i1 row">
       <div class="col-md-4 col-4 p-0">
        <div class="footer_1i1i">
          <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <a href="#"><img src="img/33.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
        </div>
       </div>
       <div class="col-md-4 col-4 p-0">
        <div class="footer_1i1i">
          <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <a href="#"><img src="img/34.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
        </div>
       </div>
       <div class="col-md-4 col-4 p-0">
        <div class="footer_1i1i">
          <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <a href="#"><img src="img/35.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <div class="col-md-3">
     <div class="footer_1i">
      <hr class="line_1">
      <h5 class="mb-3">TAG CLOUD</h5>
       <ul class="mb-0">
        <li class="d-inline-block"><a class="d-block" href="#">Analyze</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Audio</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Blog</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Business</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Creative</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Design</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Experiment</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">News</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Expertize</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Express</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Share</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Sustain</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Video</a></li>
        <li class="d-inline-block"><a class="d-block" href="#">Youtube</a></li>
       </ul>
     </div>
    </div>
    <div class="col-md-3">
     <div class="footer_1i">
      <hr class="line_1">
      <h5 class="mb-3">RECENT NEWS</h5>
       <p class="font_14 mb-2"><a href="#">INTEGER AT DIAM GRAVIDA FRINGILLA NIBH PRETI PURUS</a></p>
      <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> May 18 <a class="col_light" href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
      <hr>
       <p class="font_14 mb-2"><a href="#">DONEC QUIS EX VEL TINCIDUNT</a></p>
      <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> July 19 <a class="col_light" href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
      <hr>
      <p class="font_14 mb-2"><a href="#">PRAESENT IACULIS TORTOR VIVERRA</a></p>
      <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> June 17 <a class="col_light" href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
     </div>
    </div>
   </div>
   <div class="row footer_2 mt-4 text-center">
    <div class="col-md-12">
     <ul>
      <li class="d-inline-block me-3 font_14"><a href="#">CONTACT</a></li>
      <li class="d-inline-block me-3 font_14"><a href="#">PRIVACY POLICY</a></li>
      <li class="d-inline-block me-3 font_14"><a href="#">TERMS OF USE</a></li>
      <li class="d-inline-block font_14"><a href="#">FAQ</a></li>
     </ul>
     <p class="mb-0">© 2023 Art Web. All Rights Reserved | Design by <a class="col_pink" href="http://www.templateonweb.com">TemplateOnWeb</a></p>
    </div>
   </div>
 </div>
</section>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Client-side form validation (optional)
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            // Basic client-side checks
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // if (!email || !password) {
            //     alert('Please fill in all fields'); // Handled by 'required'
            //     e.preventDefault(); 
            // }
            // Form will submit to process_login.php if not prevented
        });
    }
    
    // Sticky navbar (from your original JS)
    window.onscroll = function() {myFunction()};

    var navbar_sticky = document.getElementById("navbar_sticky");
    if (navbar_sticky) { // Check if navbar_sticky exists
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
    }
});
</script>

</body>
</html>