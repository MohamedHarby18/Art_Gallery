<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View in My Room | Art Web</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/global.css" rel="stylesheet">
  <link href="css/view-in-room.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
  
	<?php
	include './includes/header.php';
	?>

  <section id="view-room" class="p_4">
    <div class="container-xl">
      <div class="row port_1 text-center mb-4">
        <div class="col-md-12">
          <h1 class="font_60">VIEW IN MY ROOM</h1>
          <p>Visualize how this artwork will look in your space</p>
          <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
        </div>
      </div>

      <div class="row view-room-container">
        <div class="col-md-8">
          <div class="view-room-preview">
            <div class="room-background-container">
              <!-- Default room background -->
              <img src="img/living-room.jpg" id="roomBackground" class="room-background" alt="Room background">

              <!-- Artwork overlay -->
              <div class="artwork-overlay" id="artworkOverlay">
                <img src="img/5.jpg" class="artwork-image" id="artworkImage" alt="Artwork">
              </div>
            </div>

            <div class="room-controls mt-4">
              <button class="btn btn-outline-pink me-2" id="changeRoomBtn">
                <i class="fa fa-home me-1"></i> Change Room
              </button>
              <button class="btn btn-outline-pink me-2" id="uploadRoomBtn">
                <i class="fa fa-upload me-1"></i> Upload Your Room
              </button>
              <button class="btn btn-outline-pink" id="resetBtn">
                <i class="fa fa-refresh me-1"></i> Reset
              </button>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="artwork-details">
            <h3 class="mb-3">Red Beauty Nature</h3>
            <p class="artist-name">By Artist Name</p>

            <div class="size-controls mb-4">
              <h5>Adjust Size</h5>
              <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-outline-pink size-btn" data-size="small">Small</button>
                <button type="button" class="btn btn-outline-pink size-btn active" data-size="medium">Medium</button>
                <button type="button" class="btn btn-outline-pink size-btn" data-size="large">Large</button>
              </div>
            </div>

            <div class="frame-controls mb-4">
              <h5>Frame Style</h5>
              <div class="frame-options">
                <div class="frame-option" data-frame="none">
                  <div class="frame-preview no-frame"></div>
                  <span>None</span>
                </div>
                <div class="frame-option active" data-frame="black">
                  <div class="frame-preview black-frame"></div>
                  <span>Black</span>
                </div>
                <div class="frame-option" data-frame="white">
                  <div class="frame-preview white-frame"></div>
                  <span>White</span>
                </div>
                <div class="frame-option" data-frame="wood">
                  <div class="frame-preview wood-frame"></div>
                  <span>Wood</span>
                </div>
                <div class="frame-option" data-frame="gold">
                  <div class="frame-preview gold-frame"></div>
                  <span>Gold</span>
                </div>
              </div>
            </div>

            <div class="artwork-options mb-4">
              <h5>Try Different Artworks</h5>
              <div class="artwork-thumbnails">
                <div class="artwork-thumbnail active" data-artwork="img/5.jpg">
                  <img src="img/5.jpg" alt="Artwork 1">
                </div>
                <div class="artwork-thumbnail" data-artwork="img/6.jpg">
                  <img src="img/6.jpg" alt="Artwork 2">
                </div>
                <div class="artwork-thumbnail" data-artwork="img/7.jpg">
                  <img src="img/7.jpg" alt="Artwork 3">
                </div>
                <div class="artwork-thumbnail" data-artwork="img/8.jpg">
                  <img src="img/8.jpg" alt="Artwork 4">
                </div>
              </div>
            </div>

            <div class="action-buttons">
              <button class="btn btn-pink me-2">
                <i class="fa fa-shopping-cart me-1"></i> Add to Cart
              </button>
              <button class="btn btn-outline-pink">
                <i class="fa fa-heart me-1"></i> Save to Wishlist
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row room-options mt-5">
        <div class="col-12">
          <h4 class="text-center mb-4">Choose a Room Style</h4>
          <div class="room-style-options">
            <div class="room-style" data-room="img/living-room.jpg">
              <img src="img/living-room-thumb.jpg" alt="Living Room">
              <span>Living Room</span>
            </div>
            <div class="room-style" data-room="img/bedroom.jpg">
              <img src="img/bedroom-thumb.jpg" alt="Bedroom">
              <span>Bedroom</span>
            </div>
            <div class="room-style" data-room="img/office.jpg">
              <img src="img/office-thumb.jpg" alt="Office">
              <span>Office</span>
            </div>
            <div class="room-style" data-room="img/dining-room.jpg">
              <img src="img/dining-room-thumb.jpg" alt="Dining Room">
              <span>Dining Room</span>
            </div>
            <div class="room-style" data-room="img/hallway.jpg">
              <img src="img/hallway-thumb.jpg" alt="Hallway">
              <span>Hallway</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="related" class="p_4 pt-0">
    <div class="container-xl">
      <div class="row port_1 text-center mb-4">
        <div class="col-md-12">
          <h1 class="font_60">RELATED ARTWORKS</h1>
          <p>You might also like these pieces</p>
          <span class="icon_line col_pink"><i class="fa fa-square-o"></i></span>
        </div>
      </div>
      <div class="row related-artworks">
        <div class="col-md-3">
          <div class="artwork-card">
            <div class="artwork-image">
              <img src="img/6.jpg" alt="Related Artwork 1">
              <div class="artwork-overlay">
                <button class="btn btn-pink btn-sm">View in Room</button>
              </div>
            </div>
            <div class="artwork-details">
              <h5>Mountain Landscape</h5>
              <p class="artist">By Artist Name</p>
              <p class="price">$250.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="artwork-card">
            <div class="artwork-image">
              <img src="img/7.jpg" alt="Related Artwork 2">
              <div class="artwork-overlay">
                <button class="btn btn-pink btn-sm">View in Room</button>
              </div>
            </div>
            <div class="artwork-details">
              <h5>Abstract Composition</h5>
              <p class="artist">By Artist Name</p>
              <p class="price">$320.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="artwork-card">
            <div class="artwork-image">
              <img src="img/8.jpg" alt="Related Artwork 3">
              <div class="artwork-overlay">
                <button class="btn btn-pink btn-sm">View in Room</button>
              </div>
            </div>
            <div class="artwork-details">
              <h5>City at Night</h5>
              <p class="artist">By Artist Name</p>
              <p class="price">$275.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="artwork-card">
            <div class="artwork-image">
              <img src="img/9.jpg" alt="Related Artwork 4">
              <div class="artwork-overlay">
                <button class="btn btn-pink btn-sm">View in Room</button>
              </div>
            </div>
            <div class="artwork-details">
              <h5>Ocean Waves</h5>
              <p class="artist">By Artist Name</p>
              <p class="price">$290.00</p>
            </div>
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