<?php
require_once '../Controller/DBController.php';

// Create database controller instance
$db = new DBController();

// Function to get events by category
function getEventsByCategory($db, $category = null)
{
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
  <?php
  include './includes/header.php';
  ?>
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
                    <img src="<?= htmlspecialchars($baseUrl) ?>Images/events/<?= $event['Image'] ?>" alt="<?= htmlspecialchars($event['Title']) ?>">
                    <div class="event-category <?= strtolower($event['Category']) ?>"><?= $event['Category'] ?></div>
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
      </div>
    </div>
  </section>
  <script src="js/main.js"></script>
</body>

</html>