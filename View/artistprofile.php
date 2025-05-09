<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - Artist Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/artistprofile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">

</head>

<body>
	<?php
	include './includes/header.php';
	?>
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
    </div>

    <!-- Artist Profile Section -->
    <section id="artist-profile" class="artist-section p_4">
        <div class="container-xl">
            <div class="artist-header text-center">
                <img src="img/artist.jpg" alt="Artist Name" class="artist-avatar">
                <h1 class="artist-name">Elena Rodriguez</h1>
                <div class="artist-location">
                    <i class="fa fa-map-marker"></i> Barcelona, Spain
                </div>
                <div class="artist-social">
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-pinterest"></i></a>
                    <a href="#"><i class="fa fa-globe"></i></a>
                </div>
                <p class="artist-bio">
                    Elena Rodriguez is a contemporary mixed-media artist known for her vibrant abstract compositions that explore the intersection of memory and place. Her work has been exhibited internationally and is held in numerous private collections. Elena's process involves layering acrylics, inks, and found materials to create textured, emotionally charged surfaces.
                </p>
                <div class="artist-stats">
                    <div class="stat-item">
                        <div class="stat-number">42</div>
                        <div class="stat-label">Exhibitions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">127</div>
                        <div class="stat-label">Artworks</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2015</div>
                        <div class="stat-label">Year Started</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">36</div>
                        <div class="stat-label">Collections</div>
                    </div>
                </div>
            </div>

            <!-- Artist Tabs -->
            <ul class="nav nav-tabs artist-tabs" id="artistTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="artwork-tab" data-bs-toggle="tab" data-bs-target="#artwork" type="button" role="tab" aria-controls="artwork" aria-selected="true">Artwork</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="exhibitions-tab" data-bs-toggle="tab" data-bs-target="#exhibitions" type="button" role="tab" aria-controls="exhibitions" aria-selected="false">Exhibitions</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false">About</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                </li>
            </ul>

            <div class="tab-content" id="artistTabContent">
                <!-- Artwork Tab -->
                <div class="tab-pane fade show active" id="artwork" role="tabpanel" aria-labelledby="artwork-tab">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="artwork-card">
                                <img src="img/5.jpg" alt="Artwork Title" class="artwork-img">
                                <div class="artwork-details">
                                    <h5 class="artwork-title">Ephemeral Memories</h5>
                                    <div class="artwork-price">$2,400</div>
                                    <div class="artwork-medium">Mixed Media on Canvas • 24" × 36"</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="artwork-card">
                                <img src="img/6.jpg" alt="Artwork Title" class="artwork-img">
                                <div class="artwork-details">
                                    <h5 class="artwork-title">Urban Fragments</h5>
                                    <div class="artwork-price">$1,800</div>
                                    <div class="artwork-medium">Acrylic on Wood Panel • 18" × 24"</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="artwork-card">
                                <img src="img/7.jpg" alt="Artwork Title" class="artwork-img">
                                <div class="artwork-details">
                                    <h5 class="artwork-title">Chromatic Dialogue</h5>
                                    <div class="artwork-price">$3,200</div>
                                    <div class="artwork-medium">Oil and Ink on Canvas • 30" × 40"</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="artwork-card">
                                <img src="img/8.jpg" alt="Artwork Title" class="artwork-img">
                                <div class="artwork-details">
                                    <h5 class="artwork-title">Silent Echoes</h5>
                                    <div class="artwork-price">$2,700</div>
                                    <div class="artwork-medium">Mixed Media on Paper • 22" × 30"</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="artwork-card">
                                <img src="img/9.jpg" alt="Artwork Title" class="artwork-img">
                                <div class="artwork-details">
                                    <h5 class="artwork-title">Transient Horizons</h5>
                                    <div class="artwork-price">$4,500</div>
                                    <div class="artwork-medium">Acrylic and Gold Leaf on Canvas • 36" × 48"</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="artwork-card">
                                <img src="img/10.jpg" alt="Artwork Title" class="artwork-img">
                                <div class="artwork-details">
                                    <h5 class="artwork-title">Layered Truths</h5>
                                    <div class="artwork-price">$3,800</div>
                                    <div class="artwork-medium">Collage and Encaustic on Panel • 24" × 36"</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exhibitions Tab -->
                <div class="tab-pane fade" id="exhibitions" role="tabpanel" aria-labelledby="exhibitions-tab">
                    <div class="exhibition-item">
                        <div class="exhibition-date">June 2023</div>
                        <h4 class="exhibition-title">"Fragmented Realities" Solo Exhibition</h4>
                        <div class="exhibition-location">Modern Art Gallery, Barcelona, Spain</div>
                        <p>A collection of 15 new works exploring the concept of memory fragmentation in urban environments.</p>
                    </div>

                    <div class="exhibition-item">
                        <div class="exhibition-date">March 2023</div>
                        <h4 class="exhibition-title">"Contemporary Abstraction" Group Show</h4>
                        <div class="exhibition-location">ArtSpace Berlin, Germany</div>
                        <p>Featured alongside 12 international artists pushing the boundaries of abstract expression.</p>
                    </div>

                    <div class="exhibition-item">
                        <div class="exhibition-date">October 2022</div>
                        <h4 class="exhibition-title">"Material Memory" Solo Exhibition</h4>
                        <div class="exhibition-location">The Loft Gallery, Paris, France</div>
                        <p>Showcasing mixed-media works incorporating found objects and personal artifacts.</p>
                    </div>

                    <div class="exhibition-item">
                        <div class="exhibition-date">May 2022</div>
                        <h4 class="exhibition-title">"Art Barcelona" Art Fair</h4>
                        <div class="exhibition-location">Barcelona Convention Center, Spain</div>
                        <p>Represented by Galeria Moderna with a selection of recent works.</p>
                    </div>
                </div>

                <!-- About Tab -->
                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Artist Statement</h4>
                            <p>
                                My work investigates the fragile nature of memory and its relationship to physical space. Through layered surfaces that combine painting, drawing, and collage, I create visual metaphors for how we construct and reconstruct our personal histories. Each piece becomes a palimpsest, with earlier layers partially obscured but still contributing to the final composition.
                            </p>
                            <p>
                                I'm particularly interested in how urban environments shape our collective memory, and often incorporate materials sourced from city streets - fragments of posters, discarded papers, and other ephemera that carry traces of human presence.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h4>Education & Background</h4>
                            <ul>
                                <li>MFA in Painting, Barcelona School of Fine Arts, 2012</li>
                                <li>BFA in Visual Arts, University of Madrid, 2009</li>
                                <li>Artist Residency, International Art Foundation, New York, 2018</li>
                                <li>Artist Residency, La Maison des Artistes, Paris, 2016</li>
                            </ul>

                            <h4 class="mt-4">Awards & Recognition</h4>
                            <ul>
                                <li>Contemporary Art Prize, Barcelona Arts Council, 2021</li>
                                <li>Emerging Artist Grant, Spanish Cultural Ministry, 2019</li>
                                <li>Best in Show, International Mixed Media Exhibition, 2017</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Tab -->
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Contact the Artist</h4>
                            <p>For inquiries about available work, commissions, or exhibition opportunities, please use the form or contact details below.</p>

                            <div class="mt-4">
                                <p><strong>Studio Address:</strong><br>
                                    Carrer de les Arts 42<br>
                                    Barcelona, 08001<br>
                                    Spain</p>

                                <p><strong>Email:</strong> studio@elenarodriguez.com</p>
                                <p><strong>Phone:</strong> +34 600 123 456</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form class="contact-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-contact">SEND MESSAGE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
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
            // Sticky navbar (from your original JS)
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

            // Contact form submission
            document.querySelector('.contact-form').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for your message. The artist will respond shortly.');
                this.reset();
            });
        });
    </script>

</body>

</html>