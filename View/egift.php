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
    <div class="main_2 clearfix">
      <section id="center" class="center_home">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
              aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"
              class="" aria-current="true"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/1.jpg" class="d-block w-100" alt="Gift Cards">
              <div class="carousel-caption d-md-block">
                <h1 class="text-white font_60">The Perfect Art Gift</h1>
                <h4 class="text-white mt-3">Digital Gift Cards</h4>
                <p class="text-white mt-4">Give the gift of art with our customizable e-gift cards. Let your loved ones
                  choose their perfect piece from our curated collection.</p>
                <h6 class="mt-4 mb-0"><a class="button" href="#gift-cards"><i class="fa fa-gift bg-white col_pink p-3">
                    </i> <span class="ps-3 pe-3">View Gift Options</span></a></h6>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/2.jpg" class="d-block w-100" alt="Gift Cards">
              <div class="carousel-caption d-md-block">
                <h1 class="text-white font_60">Instant Delivery</h1>
                <h4 class="text-white mt-3">Send Anytime, Anywhere</h4>
                <p class="text-white mt-4">Our e-gift cards are delivered instantly via email, perfect for last-minute
                  gifts or special occasions.</p>
                <h6 class="mt-4 mb-0"><a class="button" href="#gift-cards"><i class="fa fa-bolt bg-white col_pink p-3">
                    </i> <span class="ps-3 pe-3">Send Today</span></a></h6>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </section>
    </div>
  </div>

  <!-- Gift Cards Section -->
  <section id="gift-cards" class="gift-section p_4">
    <div class="container-xl">
      <div class="row port_1 text-center">
        <div class="col-md-12">
          <h1 class="font_60">ART GIFT CARDS</h1>
          <p>Give the perfect gift - let them choose their favorite artwork</p>
          <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
        </div>
      </div>

      <!-- Gift Card Options -->
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

      <!-- Customization Panel -->
      <div class="gift-customize" id="customizePanel">
        <div class="row">
          <div class="col-md-6">
            <div class="gift-preview" id="giftPreview"></div>
            <div class="form-group mb-3">
              <label>Choose Design</label>
              <div class="row mt-2">
                <div class="col-3">
                  <div class="design-option" data-image="img/5.jpg"
                    style="background-image: url('img/5.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;">
                  </div>
                </div>
                <div class="col-3">
                  <div class="design-option" data-image="img/6.jpg"
                    style="background-image: url('img/6.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;">
                  </div>
                </div>
                <div class="col-3">
                  <div class="design-option" data-image="img/7.jpg"
                    style="background-image: url('img/7.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;">
                  </div>
                </div>
                <div class="col-3">
                  <div class="design-option" data-image="img/8.jpg"
                    style="background-image: url('img/8.jpg'); height: 60px; background-size: cover; cursor: pointer; border: 2px solid #ddd;">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h3 class="mb-4">Personalize Your Gift</h3>
            <div class="form-group mb-3">
              <label for="recipientName">Recipient Name</label>
              <input type="text" class="form-control" id="recipientName" placeholder="Enter recipient's name">
            </div>
            <div class="form-group mb-3">
              <label for="recipientEmail">Recipient Email</label>
              <input type="email" class="form-control" id="recipientEmail" placeholder="Enter recipient's email">
            </div>
            <div class="form-group mb-3">
              <label for="senderName">Your Name</label>
              <input type="text" class="form-control" id="senderName" placeholder="Enter your name">
            </div>
            <div class="form-group mb-3">
              <label for="giftMessage">Message</label>
              <textarea class="form-control" id="giftMessage" rows="3" placeholder="Add a personal message"></textarea>
            </div>
            <div class="form-group mb-4">
              <label for="deliveryDate">Delivery Date</label>
              <input type="date" class="form-control" id="deliveryDate">
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h4 class="mb-0" id="selectedAmount">$0</h4>
                <small class="text-muted">Gift Amount</small>
              </div>
              <button class="btn btn-primary btn-lg" id="checkoutBtn">Proceed to Checkout</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Gift Features -->
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

  <!-- How It Works Section -->
  <section id="how-it-works" class="p_4 pt-0" style="background: #f9f9f9;">
    <div class="container-xl">
      <div class="row port_1 text-center mb-4">
        <div class="col-md-12">
          <h1 class="font_60">HOW IT WORKS</h1>
          <p>Simple steps to give the perfect art gift</p>
          <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="text-center p-4">
            <div class="rounded-circle bg_pink text-white d-inline-flex align-items-center justify-content-center"
              style="width: 80px; height: 80px; font-size: 30px; margin-bottom: 20px;">1</div>
            <h4>Choose Amount</h4>
            <p>Select from our curated gift amounts or enter a custom value that fits your budget.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="text-center p-4">
            <div class="rounded-circle bg_pink text-white d-inline-flex align-items-center justify-content-center"
              style="width: 80px; height: 80px; font-size: 30px; margin-bottom: 20px;">2</div>
            <h4>Personalize</h4>
            <p>Add a personal message and choose when the gift should be delivered.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="text-center p-4">
            <div class="rounded-circle bg_pink text-white d-inline-flex align-items-center justify-content-center"
              style="width: 80px; height: 80px; font-size: 30px; margin-bottom: 20px;">3</div>
            <h4>Complete Purchase</h4>
            <p>Check out securely and we'll handle the rest. Your recipient will receive their gift via email.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="p_4">
    <div class="container-xl">
      <div class="row port_1 text-center mb-4">
        <div class="col-md-12">
          <h1 class="font_60">FREQUENTLY ASKED QUESTIONS</h1>
          <p>Everything you need to know about our gift cards</p>
          <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="accordion" id="faqAccordion">
            <div class="accordion-item mb-3">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="true" aria-controls="collapseOne">
                  How do the gift cards work?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Our gift cards work like a credit towards any artwork in our collection. The recipient can apply the
                  gift card amount at checkout, and if their purchase exceeds the gift card amount, they can pay the
                  difference.
                </div>
              </div>
            </div>
            <div class="accordion-item mb-3">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  When will the recipient receive their gift card?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  E-gift cards are delivered immediately via email unless you specify a future delivery date during
                  checkout. You can schedule delivery for a special occasion like a birthday or anniversary.
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="accordion" id="faqAccordion2">
            <div class="accordion-item mb-3">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Can I use multiple gift cards for one purchase?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#faqAccordion2">
                <div class="accordion-body">
                  Yes, recipients can apply multiple gift cards to a single purchase. At checkout, they'll have the
                  option to enter multiple gift card codes to combine their values.
                </div>
              </div>
            </div>
            <div class="accordion-item mb-3">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Do gift cards expire?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#faqAccordion2">
                <div class="accordion-body">
                  Our gift cards never expire, so the recipient can take their time choosing the perfect artwork. The
                  full value remains available until it's completely used.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer Section (from your original HTML) -->
  <section id="footer" class="pt-3 pb-3">
    <div class="container-fluid">
      <div class="row footer_1">
        <div class="col-md-3">
          <div class="footer_1i">
            <hr class="line_1">
            <h5 class="mb-3">ABOUT</h5>
            <p>Phasellus et nisl tellus. Etiam facilisis eu nisi scelerisque faucibus. Proin semper suscipit magna, nec
              imperdiet lacus semper vitae. Sed hendrerit enim non justo posuere placerat eget purus mauris.</p>
            <p>Etiam facilisis eu nisi scelerisque faucibus. Proin semper suscipit magna, nec imperdiet lacus semper.
            </p>
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
            <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> May 18 <a class="col_light"
                href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
            <hr>
            <p class="font_14 mb-2"><a href="#">DONEC QUIS EX VEL TINCIDUNT</a></p>
            <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> July 19 <a class="col_light"
                href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
            <hr>
            <p class="font_14 mb-2"><a href="#">PRAESENT IACULIS TORTOR VIVERRA</a></p>
            <h6 class="col_light font_14"><i class="fa fa-clock-o col_pink me-1"></i> June 17 <a class="col_light"
                href="#"><i class="fa fa-comment-o col_pink me-1 ms-3"></i> 2</a></h6>
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
          <p class="mb-0">© 2023 Art Web. All Rights Reserved | Design by <a class="col_pink"
              href="http://www.templateonweb.com">TemplateOnWeb</a></p>
        </div>
      </div>
    </div>
  </section>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Handle gift card selection
      const giftCards = document.querySelectorAll('.gift-card');
      const customizePanel = document.getElementById('customizePanel');
      const giftPreview = document.getElementById('giftPreview');
      const selectedAmount = document.getElementById('selectedAmount');

      giftCards.forEach(card => {
        card.addEventListener('click', function () {
          // Update preview with selected image
          const imageUrl = this.getAttribute('data-image');
          giftPreview.style.backgroundImage = `url('${imageUrl}')`;

          // Update amount
          const amount = this.getAttribute('data-amount');
          selectedAmount.textContent = `$${amount}`;

          // Show customization panel
          customizePanel.style.display = 'block';

          // Scroll to panel
          customizePanel.scrollIntoView({ behavior: 'smooth' });
        });
      });

      // Handle design selection
      const designOptions = document.querySelectorAll('.design-option');
      designOptions.forEach(option => {
        option.addEventListener('click', function () {
          const imageUrl = this.getAttribute('data-image');
          giftPreview.style.backgroundImage = `url('${imageUrl}')`;
        });
      });

      // Checkout button
      document.getElementById('checkoutBtn').addEventListener('click', function () {
        // Validate form
        const recipientName = document.getElementById('recipientName').value;
        const recipientEmail = document.getElementById('recipientEmail').value;

        if (!recipientName || !recipientEmail) {
          alert('Please fill in all required fields');
          return;
        }

        // In a real implementation, this would submit to your payment processor
        alert('Thank you! In a real implementation, this would proceed to checkout.');
      });

      // Set minimum delivery date to today
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('deliveryDate').setAttribute('min', today);
    });

    // Sticky navbar (from your original JS)
    window.onscroll = function () { myFunction() };

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
  </script>

</body>

</html>