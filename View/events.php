<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Events | Art Web</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/global.css" rel="stylesheet">
  <link href="css/events.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <!--nav Start -->
  <?php
  include __DIR__ . '/includes/header.html';
  ?>
  <!--nav end -->

  <section id="events-hero" class="p_4">
    <div class="container-xl">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="font_60 text-white">UPCOMING EVENTS</h1>
          <p class="text-white">Discover art exhibitions, workshops, and creative gatherings</p>
          <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
        </div>
      </div>
    </div>
  </section>

  <section id="events-main" class="p_4">
    <div class="container-xl">
      <div class="row mb-5">
        <div class="col-md-12">
          <ul class="nav nav-tabs events-tabs" id="eventsTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                role="tab" aria-controls="all" aria-selected="true">All Events</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="exhibitions-tab" data-bs-toggle="tab" data-bs-target="#exhibitions"
                type="button" role="tab" aria-controls="exhibitions" aria-selected="false">Exhibitions</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="workshops-tab" data-bs-toggle="tab" data-bs-target="#workshops" type="button"
                role="tab" aria-controls="workshops" aria-selected="false">Workshops</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="talks-tab" data-bs-toggle="tab" data-bs-target="#talks" type="button"
                role="tab" aria-controls="talks" aria-selected="false">Artist Talks</button>
            </li>
          </ul>
        </div>
      </div>

      <div class="tab-content" id="eventsTabContent">
        <!-- All Events Tab -->
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
          <div class="row">
            <!-- Event 1 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">15</span>
                  <span class="month">JUN</span>
                </div>
                <div class="event-image">
                  <img src="img/event1.jpg" alt="Urban Art Exhibition">
                  <div class="event-category exhibition">Exhibition</div>
                </div>
                <div class="event-details">
                  <h3>Urban Art Exhibition</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 10:00 AM - 6:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> City Art Gallery</span>
                  </div>
                  <p>Experience the vibrant world of urban art with works from emerging street artists. This exhibition
                    showcases graffiti, murals, and mixed media pieces that transform urban landscapes.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Event 2 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">22</span>
                  <span class="month">JUN</span>
                </div>
                <div class="event-image">
                  <img src="img/event2.jpg" alt="Watercolor Workshop">
                  <div class="event-category workshop">Workshop</div>
                </div>
                <div class="event-details">
                  <h3>Watercolor Techniques Workshop</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 2:00 PM - 5:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Art Web Studio</span>
                  </div>
                  <p>Learn advanced watercolor techniques from master artist Sarah Johnson. This hands-on workshop
                    covers wet-on-wet, dry brush, and glazing methods for stunning effects.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Event 3 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">05</span>
                  <span class="month">JUL</span>
                </div>
                <div class="event-image">
                  <img src="img/event3.jpg" alt="Digital Art Talk">
                  <div class="event-category talk">Artist Talk</div>
                </div>
                <div class="event-details">
                  <h3>The Future of Digital Art</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 7:00 PM - 9:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Online Event</span>
                  </div>
                  <p>Join renowned digital artist Michael Chen as he discusses emerging trends in digital art, NFTs, and
                    the intersection of technology and creativity in the modern art world.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Event 4 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">18</span>
                  <span class="month">JUL</span>
                </div>
                <div class="event-image">
                  <img src="img/event4.jpg" alt="Sculpture Exhibition">
                  <div class="event-category exhibition">Exhibition</div>
                </div>
                <div class="event-details">
                  <h3>Modern Sculpture Showcase</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 11:00 AM - 7:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Contemporary Arts Center</span>
                  </div>
                  <p>Explore groundbreaking three-dimensional works from contemporary sculptors. This exhibition
                    features innovative materials and techniques pushing the boundaries of sculpture.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Event 5 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">29</span>
                  <span class="month">JUL</span>
                </div>
                <div class="event-image">
                  <img src="img/event5.jpg" alt="Portrait Drawing">
                  <div class="event-category workshop">Workshop</div>
                </div>
                <div class="event-details">
                  <h3>Portrait Drawing Masterclass</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 10:00 AM - 4:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Art Web Studio</span>
                  </div>
                  <p>Refine your portrait skills with this intensive one-day workshop. Learn anatomy, proportion, and
                    shading techniques to create lifelike portraits in charcoal and pencil.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Event 6 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">12</span>
                  <span class="month">AUG</span>
                </div>
                <div class="event-image">
                  <img src="img/event6.jpg" alt="Art Collector Talk">
                  <div class="event-category talk">Artist Talk</div>
                </div>
                <div class="event-details">
                  <h3>Art Collecting 101</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 6:30 PM - 8:30 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> The Art Loft</span>
                  </div>
                  <p>Gallery owner and collector David Wilson shares insights on starting and growing an art collection.
                    Learn how to identify quality works and navigate the art market.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Exhibitions Tab -->
        <div class="tab-pane fade" id="exhibitions" role="tabpanel" aria-labelledby="exhibitions-tab">
          <div class="row">
            <!-- Exhibition 1 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">15</span>
                  <span class="month">JUN</span>
                </div>
                <div class="event-image">
                  <img src="img/event1.jpg" alt="Urban Art Exhibition">
                  <div class="event-category exhibition">Exhibition</div>
                </div>
                <div class="event-details">
                  <h3>Urban Art Exhibition</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 10:00 AM - 6:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> City Art Gallery</span>
                  </div>
                  <p>Experience the vibrant world of urban art with works from emerging street artists. This exhibition
                    showcases graffiti, murals, and mixed media pieces that transform urban landscapes.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Exhibition 2 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">18</span>
                  <span class="month">JUL</span>
                </div>
                <div class="event-image">
                  <img src="img/event4.jpg" alt="Sculpture Exhibition">
                  <div class="event-category exhibition">Exhibition</div>
                </div>
                <div class="event-details">
                  <h3>Modern Sculpture Showcase</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 11:00 AM - 7:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Contemporary Arts Center</span>
                  </div>
                  <p>Explore groundbreaking three-dimensional works from contemporary sculptors. This exhibition
                    features innovative materials and techniques pushing the boundaries of sculpture.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Workshops Tab -->
        <div class="tab-pane fade" id="workshops" role="tabpanel" aria-labelledby="workshops-tab">
          <div class="row">
            <!-- Workshop 1 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">22</span>
                  <span class="month">JUN</span>
                </div>
                <div class="event-image">
                  <img src="img/event2.jpg" alt="Watercolor Workshop">
                  <div class="event-category workshop">Workshop</div>
                </div>
                <div class="event-details">
                  <h3>Watercolor Techniques Workshop</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 2:00 PM - 5:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Art Web Studio</span>
                  </div>
                  <p>Learn advanced watercolor techniques from master artist Sarah Johnson. This hands-on workshop
                    covers wet-on-wet, dry brush, and glazing methods for stunning effects.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Workshop 2 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">29</span>
                  <span class="month">JUL</span>
                </div>
                <div class="event-image">
                  <img src="img/event5.jpg" alt="Portrait Drawing">
                  <div class="event-category workshop">Workshop</div>
                </div>
                <div class="event-details">
                  <h3>Portrait Drawing Masterclass</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 10:00 AM - 4:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Art Web Studio</span>
                  </div>
                  <p>Refine your portrait skills with this intensive one-day workshop. Learn anatomy, proportion, and
                    shading techniques to create lifelike portraits in charcoal and pencil.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Talks Tab -->
        <div class="tab-pane fade" id="talks" role="tabpanel" aria-labelledby="talks-tab">
          <div class="row">
            <!-- Talk 1 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">05</span>
                  <span class="month">JUL</span>
                </div>
                <div class="event-image">
                  <img src="img/event3.jpg" alt="Digital Art Talk">
                  <div class="event-category talk">Artist Talk</div>
                </div>
                <div class="event-details">
                  <h3>The Future of Digital Art</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 7:00 PM - 9:00 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> Online Event</span>
                  </div>
                  <p>Join renowned digital artist Michael Chen as he discusses emerging trends in digital art, NFTs, and
                    the intersection of technology and creativity in the modern art world.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>

            <!-- Talk 2 -->
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day">12</span>
                  <span class="month">AUG</span>
                </div>
                <div class="event-image">
                  <img src="img/event6.jpg" alt="Art Collector Talk">
                  <div class="event-category talk">Artist Talk</div>
                </div>
                <div class="event-details">
                  <h3>Art Collecting 101</h3>
                  <div class="event-meta">
                    <span><i class="fa fa-clock-o col_pink me-1"></i> 6:30 PM - 8:30 PM</span>
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> The Art Loft</span>
                  </div>
                  <p>Gallery owner and collector David Wilson shares insights on starting and growing an art collection.
                    Learn how to identify quality works and navigate the art market.</p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Past Events Section -->
      <div class="row mt-5">
        <div class="col-md-12">
          <h2 class="font_40 text-center mb-4">PAST EVENTS</h2>
          <div class="past-events-slider">
            <div class="past-event">
              <img src="img/past-event1.jpg" alt="Abstract Expressionism">
              <div class="past-event-overlay">
                <h4>Abstract Expressionism</h4>
                <p>May 5, 2023</p>
              </div>
            </div>
            <div class="past-event">
              <img src="img/past-event2.jpg" alt="Printmaking Workshop">
              <div class="past-event-overlay">
                <h4>Printmaking Workshop</h4>
                <p>April 15, 2023</p>
              </div>
            </div>
            <div class="past-event">
              <img src="img/past-event3.jpg" alt="Contemporary Photography">
              <div class="past-event-overlay">
                <h4>Contemporary Photography</h4>
                <p>March 22, 2023</p>
              </div>
            </div>
            <div class="past-event">
              <img src="img/past-event4.jpg" alt="Clay Sculpting">
              <div class="past-event-overlay">
                <h4>Clay Sculpting</h4>
                <p>February 8, 2023</p>
              </div>
            </div>
            <div class="past-event">
              <img src="img/past-event5.jpg" alt="Digital Art Symposium">
              <div class="past-event-overlay">
                <h4>Digital Art Symposium</h4>
                <p>January 14, 2023</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="newsletter" class="p_4 bg-light">
    <div class="container-xl">
      <div class="row">
        <div class="col-md-8 mx-auto text-center">
          <h3 class="mb-3">STAY UPDATED ON OUR EVENTS</h3>
          <p>Subscribe to our newsletter to receive announcements about upcoming exhibitions, workshops, and special
            events.</p>
          <div class="input-group newsletter-form">
            <input type="email" class="form-control" placeholder="Your email address">
            <button class="btn btn-pink" type="button">Subscribe</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="footer" class="pt-3 pb-3">
    <!-- Your existing footer code here -->
  </section>

  <script src="js/main.js"></script>

</body>

</html>