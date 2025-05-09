<?php
require_once '../Controller/DBController.php';

// Create database controller instance
$db = new DBController();

// Function to get events by category
function getEventsByCategory($db, $category = null) {
    $query = "SELECT * FROM events";
    if ($category) {
        $query .= " WHERE Category = ?";
        return $db->select($query, [$category]);
    }
    return $db->select($query);
}

// Get all events for the "All Events" tab
$allEvents = getEventsByCategory($db);

?>

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
      <div class="tab-content" id="eventsTabContent">
        <!-- All Events Tab -->
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
          <div class="row">
            <?php foreach ($allEvents as $event): 
              $eventDate = new DateTime($event['Date']);
              $day = $eventDate->format('d');
              $month = $eventDate->format('M');
              $time = $eventDate->format('g:i A');
            ?>
            <div class="col-lg-6 mb-4">
              <div class="event-card">
                <div class="event-date">
                  <span class="day"><?php echo $day; ?></span>
                  <span class="month"><?php echo $month; ?></span>
                </div>
                <div class="event-image">
                  <img src="<?php echo htmlspecialchars($event['Image']); ?>" alt="<?php echo htmlspecialchars($event['Title']); ?>">
                  <div class="event-category <?php echo strtolower($event['Category']); ?>"><?php echo $event['Category']; ?></div>
                </div>
                <div class="event-details">
                  <h3><?php echo htmlspecialchars($event['Title']); ?></h3>
                  <div class="event-meta">
                    <span><i class="fa fa-map-marker col_pink me-1 ms-3"></i> <?php echo htmlspecialchars($event['Location']); ?></span>
                  </div>
                  <p><?php echo htmlspecialchars($event['Description']); ?></p>
                  <a href="#" class="btn btn-pink">Register Now</a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>


      <!-- Past Events Section -->
      <div class="row mt-5">
        <div class="col-md-12">
          <h2 class="font_40 text-center mb-4">PAST EVENTS</h2>
          <div class="past-events-slider">
            <?php
            // Get past events (assuming you have a way to determine past events)
            $currentDate = date('Y-m-d');
            $pastEvents = $db->select("SELECT * FROM events WHERE Date < ? ORDER BY Date ASC LIMIT 9", [$currentDate]);
            
            foreach ($pastEvents as $event): 
              $eventDate = new DateTime($event['Date']);
              $formattedDate = $eventDate->format('F j, Y');
            ?>
            <div class="past-event">
              <img src="<?php echo htmlspecialchars($event['Image']); ?>" alt="<?php echo htmlspecialchars($event['Title']); ?>">
              <div class="past-event-overlay">
                <h4><?php echo htmlspecialchars($event['Title']); ?></h4>
                <p><?php echo $formattedDate; ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="js/main.js"></script>

</body>
</html>