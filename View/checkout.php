<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Art Web</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/checkout.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>
	<!--nav Start -->
	<?php
	include __DIR__ . '/includes/header.html';
	?>
	<!--nav end -->

	<section id="center" class="center_o bg_gray pt-2 pb-2">
		<div class="container-xl">
			<div class="row center_o1">
				<div class="col-md-5">
					<div class="center_o1l">
						<h2 class="mb-0">Checkout</h2>
					</div>
				</div>
				<div class="col-md-7">
					<div class="center_o1r text-end">
						<h6 class="mb-0"><a href="#">Home</a> <span class="me-2 ms-2"><i class="fa fa-caret-right"></i></span> Checkout</h6>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="checkout">
		<div class="container-xl">
			<div class="checkout_1 row">
				<div class="col-md-8">
					<div class="checkout_1l">
						<h5>Make Your Checkout Here</h5>
						<p>Please fill in your information to complete the checkout</p>
					</div>
					<form id="checkoutForm" class="needs-validation" novalidate>
						<div class="checkout_1l1 row">
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">First Name <span class="text-danger">*</span></h6>
								<input class="form-control" type="text" name="firstName" required>
								<div class="invalid-feedback">Please enter your first name</div>
							</div>
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Last Name <span class="text-danger">*</span></h6>
								<input class="form-control" type="text" name="lastName" required>
								<div class="invalid-feedback">Please enter your last name</div>
							</div>
						</div>
						<div class="checkout_1l1 row">
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Email Address <span class="text-danger">*</span></h6>
								<input class="form-control" type="email" name="email" required>
								<div class="invalid-feedback">Please enter a valid email address</div>
							</div>
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Phone Number <span class="text-danger">*</span></h6>
								<input class="form-control" type="tel" name="phone" required>
								<div class="invalid-feedback">Please enter your phone number</div>
							</div>
						</div>
						<div class="checkout_1l1 row">
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Country <span class="text-danger">*</span></h6>
								<select class="form-select bg_gray" name="country" required>
									<option value="">Select Country</option>
									<option value="US">United States</option>
									<option value="UK">United Kingdom</option>
									<option value="CA">Canada</option>
									<option value="AU">Australia</option>
									<option value="DE">Germany</option>
									<option value="FR">France</option>
									<option value="IT">Italy</option>
									<option value="ES">Spain</option>
								</select>
								<div class="invalid-feedback">Please select your country</div>
							</div>
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">State / Division <span class="text-danger">*</span></h6>
								<input class="form-control" type="text" name="state" required>
								<div class="invalid-feedback">Please enter your state/division</div>
							</div>
						</div>
						<div class="checkout_1l1 row">
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Address Line 1 <span class="text-danger">*</span></h6>
								<input class="form-control" type="text" name="address1" required>
								<div class="invalid-feedback">Please enter your address</div>
							</div>
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Address Line 2</h6>
								<input class="form-control" type="text" name="address2">
							</div>
						</div>
						<div class="checkout_1l1 row">
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Postal Code <span class="text-danger">*</span></h6>
								<input class="form-control" type="text" name="postalCode" required>
								<div class="invalid-feedback">Please enter your postal code</div>
							</div>
							<div class="col-md-6 ps-0">
								<h6 class="font_14 fw-bold">Currency <span class="text-danger">*</span></h6>
								<select class="form-select bg_gray" name="currency" required>
									<option value="">Select Currency</option>
									<option value="USD">USD ($)</option>
									<option value="EUR">EUR (€)</option>
									<option value="GBP">GBP (£)</option>
									<option value="CAD">CAD (C$)</option>
									<option value="AUD">AUD (A$)</option>
								</select>
								<div class="invalid-feedback">Please select your preferred currency</div>
							</div>
						</div>
						<div class="checkout_1l">
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="createAccount" name="createAccount">
								<label class="form-check-label" for="createAccount">Create an account for future purchases</label>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-4">
					<div class="checkout_1r">
						<h5>CART TOTALS</h5>
						<hr class="line">
						<h6 class="fw-bold font_14">Sub Total <span class="pull-right">$230.00</span></h6>
						<h6 class="fw-bold mt-3 font_14">(+) Shipping <span class="pull-right">$20.00</span></h6>
						<hr>
						<h6 class="fw-bold font_14">Total <span class="pull-right">$250.00</span></h6><br>
						<h5>PAYMENTS</h5>
						<hr class="line">
						<div class="form-check mt-3">
							<input type="radio" class="form-check-input" id="customCheck1">
							<label class="form-check-label" for="customCheck1">Check Payments</label>
						</div>
						<div class="form-check mt-2">
							<input type="radio" class="form-check-input" id="customCheck1">
							<label class="form-check-label" for="customCheck1">Cash On Delivery</label>
						</div>
						<div class="form-check mt-2">
							<input type="radio" class="form-check-input" id="customCheck1">
							<label class="form-check-label" for="customCheck1">PayPal</label>
						</div>
						<h6 class="mt-3"><a class="button" href="#">PROCEED TO CHECKOUT</a></h6>
					</div>
				</div>
			</div>
		</div>
	</section>

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
					<p class="mb-0">© 2013 Your Website Name. All Rights Reserved | Design by <a class="col_pink" href="http://www.templateonweb.com">TemplateOnWeb</a></p>
				</div>
			</div>
		</div>
	</section>

	<script>
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

		// Form validation
		(function() {
			'use strict'
			var forms = document.querySelectorAll('.needs-validation')
			Array.prototype.slice.call(forms).forEach(function(form) {
				form.addEventListener('submit', function(event) {
					if (!form.checkValidity()) {
						event.preventDefault()
						event.stopPropagation()
					}
					form.classList.add('was-validated')
				}, false)
			})
		})()

		// Handle form submission
		document.getElementById('checkoutForm').addEventListener('submit', function(e) {
			e.preventDefault();

			// Get form data
			const formData = new FormData(this);
			const data = Object.fromEntries(formData);

			// Here you would typically send the data to your server
			console.log('Form submitted with data:', data);

			// For demo purposes, show success message
			alert('Order submitted successfully!');
		});

		// Update totals based on currency selection
		document.querySelector('select[name="currency"]').addEventListener('change', function(e) {
			const currency = e.target.value;
			const currencySymbols = {
				'USD': '$',
				'EUR': '€',
				'GBP': '£',
				'CAD': 'C$',
				'AUD': 'A$'
			};

			const symbol = currencySymbols[currency] || '$';

			// Update the displayed prices with the new currency symbol
			document.querySelectorAll('.pull-right').forEach(price => {
				const value = price.textContent.replace(/[^0-9.]/g, '');
				price.textContent = `${symbol}${value}`;
			});
		});
	</script>

</body>

</html>