<?php
// // registration.html
// // require_once '..\Controller\controlDBauth.html'; // Includes session_start()

// // Check if user is already logged in, if so, redirect to a different page (e.g., account page)
// if (isset($_SESSION['user_id'])) {
//     // header('Location: account.html'); // Uncomment and create account.html if you have one
//     // For now, let's redirect to index.php or a generic logged-in page
//     // header('Location: index.php'); // Or index.php if you convert it
//     // exit;
// }

session_start();

$errors = $_SESSION['errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['errors'], $_SESSION['old_input']); // Clear after displaying
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - Register</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/registration.css" rel="stylesheet"> <!-- Renamed from regestration.css -->
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <style>
        .error-message { color: red; font-size: 0.9em; margin-top: 5px; }
        .form-group { margin-bottom: 1.2rem; /* Increased margin */ }
        .password-strength { margin-top: 5px; }
        .password-requirements { font-size: 0.8em; color: #666; margin-top: 3px; }
    </style>
</head>
<body>
<div class="main clearfix position-relative">
 <div class="main_1 clearfix position-absolute top-0 w-100">
   <section id="header">
<nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
  <div class="container-xl">
    <a class="navbar-brand fs-2 p-0 fw-bold text-white" href="index.php"><i class="fa fa-pencil col_pink me-1 align-middle"></i> art <span class="col_pink span_1">WEB</span> <br> <span class="font_12 span_2">DIGITAL ART</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mb-0 ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Product
          </a>
          <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="product.php">Product</a></li>
            <li><a class="dropdown-item border-0" href="detail.php">Product Detail</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
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
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="registration.php">Register</a>
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
      <img src="img/1.jpg" class="d-block w-100" alt="Register">
      <div class="carousel-caption d-md-block">
         <h1 class="text-white font_60">Join Our Community</h1>
         <h4 class="text-white mt-3">Create Your Art Account</h4>
         <p class="text-white mt-4">Register to save your favorite artworks, track orders, and get exclusive offers.</p>
      </div>
    </div>
  </div>
</div>
</section>
 </div>
</div>



<!-- Registration Section -->
<section id="register" class="container py-5">
  <div class="text-center mb-5">
    <h2 class="display-5 fw-bold">Create Your Account</h2>
    <p class="fs-5 text-muted">Join us and explore the world of art!</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
    <form action="../Controller/process-signup.php" method="post" id="registerForm" novalidate class="p-4 border rounded-4 shadow-sm bg-dark text-white">

        <!-- Name -->
        <div class="mb-3">
          <label for="fname" class="form-label">First Name</label>
          <input type="text" class="form-control form-control-lg" id="fname" name="fname" required>
        </div>
        <!-- Last Name -->
        <div class="mb-3">
          <label for="lname" class="form-label">Last Name</label>
          <input type="text" class="form-control form-control-lg" id="lname" name="lname" required>
        </div>
        <!-- Phone Number -->
        <div class="mb-3">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="tel" class="form-control form-control-lg" id="phone" name="phone" placeholder="Enter phone number" pattern="[0-9]"required>

        </div>
        <!-- Address -->
        <div class="mb-3">
          <label for="Address" class="form-label"> Address</label>
          <input type="text" class="form-control form-control-lg" id="Address" name="Address" required>
        </div>
        <!-- City -->
        <div class="mb-3">
          <label for="City" class="form-label">City</label>
          <input type="text" class="form-control form-control-lg" id="City" name="City" required>
        </div>
        <!-- Artist -->
        <div class="form-group checkbox-group">
                <input type="checkbox" id="artist" name="artist" value="1">
                <label for="artist">I am an Artist</label>
            </div>
        <!-- Advisor -->
            <div class="form-group checkbox-group">
                <input type="checkbox" id="advisor" name="advisor" value="1">
                <label for="advisor">I am an Advisor</label>
            </div>

        <!-- Email -->
         <?php

if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]); // so it doesn't stay forever
}
?>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control form-control-lg" id="email" name="email" required>
        </div>
        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control form-control-lg" id="password" name="password" required>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
          <label for="password_confirmation" class="form-label">Repeat Password</label>
          <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required>
        </div>

        <!-- Create Account Button -->
        <div class="d-grid">
          <button type="submit" class="btn btn-success btn-lg">Create Account</button>

        </div>
        <div id="errorMessage" style="color: red; margin-top: 10px;"></div>

        <!-- Sign-in Link -->
        <div class="text-center mt-4">
          <span class="me-2">Already have an account?</span>
          <a href="login.php" class="btn btn-outline-primary btn-sm">Sign In</a>
        </div>

      </form>
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

  // Registration form submission with error handling
document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const errorDiv = document.getElementById("errorMessage");
    errorDiv.innerText = ""; // Clear previous errors

    fetch("../Controller/process-signup.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.startsWith("ERROR:")) {
            errorDiv.innerText = data.replace("ERROR:", "");
        } else if (data === "SUCCESS") {
            window.location.href = "signup-success.php";
        } else {
            errorDiv.innerText = "Unexpected response: " + data;
        }
    })
    .catch(err => {
        errorDiv.innerText = "Something went wrong. Please try again.";
        console.error(err);
    });
});











document.addEventListener('DOMContentLoaded', function() {
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrength');
    
    if (passwordInput && strengthBar) { // Check if elements exist
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength += 25; // Base for meeting minimum length
            // More granular strength for length
            if (password.length >= 10) strength += 15; // Additional for longer
            
            // Character type checks
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[a-z]/.test(password)) strength += 20; // Ensure lowercase is also checked
            if (/[0-9]/.test(password)) strength += 20;
            // Optional: Add check for special characters for more strength
            // if (/[^A-Za-z0-9]/.test(password)) strength += 10;


            // Cap strength at 100
            strength = Math.min(strength, 100);
            
            strengthBar.style.width = strength + '%';
            
            // Color coding
            if (strength < 40) { // Weak
                strengthBar.style.backgroundColor = '#ff5252'; // Red
            } else if (strength < 75) { // Medium
                strengthBar.style.backgroundColor = '#ffb142'; // Orange
            } else { // Strong
                strengthBar.style.backgroundColor = '#4caf50'; // Green (changed from #a81c51 for better visual cue)
            }
        });
    }
    
    // Client-side form validation (optional, as server-side is primary)
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            // Basic client-side checks can remain, but html handles actual validation
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const terms = document.getElementById('terms').checked;

            let isValid = true;
            
            if (!firstName || !lastName || !email || !password || !confirmPassword) {
                // alert('Please fill in all required fields'); // Can be improved with individual field messages
                // isValid = false;
            }
            
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                e.preventDefault(); // Prevent submission if client-side passwords don't match
                isValid = false;
            }
            
            if (!terms) {
                // alert('You must agree to the terms and conditions'); // Handled by 'required' attribute
                // isValid = false;
            }
            
            // Password strength check (client-side reminder)
            if (password.length > 0 && password.length < 8) { // Only if password has some input
                alert('Password must be at least 8 characters long');
                e.preventDefault();
                isValid = false;
            }
            // Client-side regex check for complexity (matches server-side)
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (password.length > 0 && !passwordRegex.test(password)) {
                 alert('Password must contain at least 8 characters, including uppercase, lowercase, and numbers.');
                 e.preventDefault();
                 isValid = false;
            }

            // if (!isValid) {
            //     e.preventDefault(); // Prevent form submission if client validation fails
            // }
            // Form will submit to process_register.html if not prevented by e.preventDefault()
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