<?php
// Enable error reporting for debugging (remove or set to 0 for production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Errors should be logged, not displayed, to keep JSON clean
ini_set('log_errors', 1);
// ini_set('error_log', '/path/to/your/php-error.log'); // Optional: specify error log file

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Try to include DBController and initialize early to catch critical errors ---
$db = null;
$initializationError = null;

try {
    require_once '../Controller/DBController.php';
    if (class_exists('DBController')) {
        $db = new DBController();
    } else {
        $initializationError = 'DBController class not found after inclusion.';
    }
} catch (Throwable $e) {
    // Throwable catches Errors and Exceptions in PHP 7+
    $initializationError = 'Failed to load or initialize DBController: ' . $e->getMessage();
    error_log($initializationError . " Trace: " . $e->getTraceAsString()); // Log the full error
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-quiz'])) {
    header('Content-Type: application/json'); // Set content type for all AJAX responses

    if ($initializationError) {
        http_response_code(500); // Internal Server Error
        echo json_encode([
            'status' => 'error',
            'message' => $initializationError
        ]);
        exit;
    }

    if (!$db) { // Should be caught by $initializationError, but as a safeguard
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Database controller is not available.'
        ]);
        exit;
    }

    try {
        // Get form data
        $colors = $_POST['selected_colors'] ?? '';
        $styles = $_POST['selected_styles'] ?? '';
        $budget = $_POST['selected_budget'] ?? '';
        $size = $_POST['selected_size'] ?? '';

        // Get customer ID from session or use a default
        // IMPORTANT: If customerID is a foreign key, '0' might cause an integrity constraint violation
        // if there's no customer with ID 0 and the column doesn't allow NULL or have a different default.
        $customerID = $_SESSION['customer_id'] ?? 0;

        // Insert into database
        $query = "INSERT INTO quiz (customerID, color, styles, budget, size) VALUES (?, ?, ?, ?, ?)";
        // Ensure your DBController's insert method handles parameter binding securely (e.g., prepared statements)
        // The types here are illustrative if your DBController needs them for bind_param (e.g., 'issss')
        $params = [$customerID, $colors, $styles, $budget, $size];

        $insertId = $db->insert($query, $params); // Assumes insert() returns lastInsertId or false/0 on error

        if ($insertId) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Quiz answers saved successfully',
                'quizID' => $insertId
            ]);
        } else {
            $dbErrorMessage = 'Unknown database error.';
            if (method_exists($db, 'getLastError')) {
                $lastError = $db->getLastError();
                if (!empty($lastError)) {
                    $dbErrorMessage = $lastError;
                }
            }
            http_response_code(500); // Internal Server Error for DB save failure
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to save quiz answers: ' . $dbErrorMessage
            ]);
        }
    } catch (Throwable $e) { // Catch any other unexpected errors during POST processing
        error_log("Quiz submission processing error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . " Trace: " . $e->getTraceAsString());
        http_response_code(500); // Internal Server Error
        echo json_encode([
            'status' => 'error',
            'message' => 'An unexpected server error occurred: ' . $e->getMessage() // For dev; be cautious showing raw error messages in prod
        ]);
    }
    exit; // Ensure no further HTML is output after JSON
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Advisor | Discover Your Perfect Artwork</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/artadvisor.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-light bg-white" id="navbar_sticky">
    <div class="container-xl">
        <a class="navbar-brand fs-2 p-0 fw-bold" href="index.html"><i class="fa fa-pencil col_pink me-1 align-middle"></i> ART <span class="col_pink span_1">ADVISOR</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-0 ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="advisor.html">Art Advisor</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Gallery
                    </a>
                    <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="gallery.html">All Artworks</a></li>
                        <li><a class="dropdown-item border-0" href="artists.html">Featured Artists</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="advisor-hero">
    <div class="container">
        <h1 class="font_60">Discover Art You'll Love</h1>
        <p class="lead">Take our quick quiz and we'll recommend artworks perfectly matched to your taste</p>
        <a href="#quiz" class="btn btn-lg bg_pink text-white mt-3">Start Quiz</a>
    </div>
</section>

<!-- Art Advisor Quiz Section -->
<section id="quiz" class="py-5">
  <form id="quizForm" method="POST"> <!-- method="POST" here is fine, JS overrides with fetch -->
    <div class="quiz-container">
      <!-- Quiz Header -->
      <div class="text-center mb-4">
        <h2 class="text-dark">Art Advisor Quiz</h2>
        <p class="text-muted">Answer a few questions to get personalized recommendations</p>
        <div class="progress-container">
          <div class="progress-bar" id="quiz-progress"></div>
        </div>
      </div>

      <!-- Hidden fields to store selections for submission -->
      <input type="hidden" name="selected_colors" id="hidden-colors">
      <input type="hidden" name="selected_styles" id="hidden-styles">
      <input type="hidden" name="selected_budget" id="hidden-budget">
      <input type="hidden" name="selected_size" id="hidden-size">

      <!-- Step 1: Color Preferences -->
      <div class="quiz-step active" id="step1">
        <h3 class="text-center mb-4 text-dark">What colors speak to you?</h3>
        <p class="text-center  text-dark">Select all that appeal to you</p>
        <div class="quiz-options">
          <div class="quiz-option text-dark" data-value="vibrant"><div class="color-option" style="background: linear-gradient(135deg, #ff0000, #ff9900);"></div><span>Vibrant</span></div>
          <div class="quiz-option text-dark" data-value="earthy"><div class="color-option" style="background: linear-gradient(135deg, #8B4513, #CD853F);"></div><span>Earthy</span></div>
          <div class="quiz-option text-dark" data-value="cool"><div class="color-option" style="background: linear-gradient(135deg, #0000ff, #00ffff);"></div><span>Cool Tones</span></div>
          <div class="quiz-option text-dark" data-value="pastel"><div class="color-option" style="background: linear-gradient(135deg, #ffb6c1, #e6e6fa);"></div><span>Pastel</span></div>
          <div class="quiz-option text-dark" data-value="monochrome"><div class="color-option" style="background: linear-gradient(135deg, #000000, #666666);"></div><span>Monochrome</span></div>
          <div class="quiz-option text-dark" data-value="metallic"><div class="color-option" style="background: linear-gradient(135deg, #D4AF37, #C0C0C0);"></div><span>Metallic</span></div>
        </div>
        <div class="quiz-navigation">
          <button type="button" class="btn btn-outline-secondary" disabled>Previous</button>
          <button type="button" class="btn bg_pink text-white next-step">Next</button>
        </div>
      </div>

      <!-- Step 2: Art Styles -->
      <div class="quiz-step" id="step2">
        <h3 class="text-center mb-4 text-dark">Which art styles do you prefer?</h3>
        <p class="text-center text-muted ">Choose up to 3 styles</p>
        <div class="quiz-options">
          <div class="quiz-option text-dark" data-value="abstract"><div class="style-option"><i class="fa fa-paint-brush fa-2x mb-2"></i><span>Abstract</span></div></div>
          <div class="quiz-option text-dark" data-value="realism"><div class="style-option"><i class="fa fa-eye fa-2x mb-2"></i><span>Realism</span></div></div>
          <div class="quiz-option text-dark" data-value="impressionism"><div class="style-option"><i class="fa fa-sun-o fa-2x mb-2"></i><span>Impressionism</span></div></div>
          <div class="quiz-option text-dark" data-value="modern"><div class="style-option"><i class="fa fa-bolt fa-2x mb-2"></i><span>Modern</span></div></div>
          <div class="quiz-option text-dark" data-value="photography"><div class="style-option"><i class="fa fa-camera fa-2x mb-2"></i><span>Photography</span></div></div>
          <div class="quiz-option text-dark" data-value="sculpture"><div class="style-option"><i class="fa fa-cube fa-2x mb-2"></i><span>Sculpture</span></div></div>
        </div>
        <div class="quiz-navigation">
          <button type="button" class="btn btn-outline-secondary prev-step">Previous</button>
          <button type="button" class="btn bg_pink text-white next-step">Next</button>
        </div>
      </div>

      <!-- Step 3: Budget -->
      <div class="quiz-step" id="step3">
        <h3 class="text-center mb-4 text-dark">What's your budget range?</h3>
        <p class="text-center text-muted">This helps us recommend artworks in your price range</p>
        <div class="quiz-options">
          <div class="quiz-option text-dark" data-value="under500"><div class="budget-option"><i class="fa fa-usd fa-2x mb-2"></i><span>Under $500</span></div></div>
          <div class="quiz-option text-dark" data-value="500-2000"><div class="budget-option"><i class="fa fa-usd fa-2x mb-2"></i><i class="fa fa-usd fa-2x mb-2"></i><span>$500 - $2,000</span></div></div>
          <div class="quiz-option text-dark" data-value="2000-5000"><div class="budget-option"><i class="fa fa-usd fa-2x mb-2"></i><i class="fa fa-usd fa-2x mb-2"></i><i class="fa fa-usd fa-2x mb-2"></i><span>$2,000 - $5,000</span></div></div>
          <div class="quiz-option text-dark" data-value="over5000"><div class="budget-option"><i class="fa fa-money fa-2x mb-2"></i><span>Over $5,000</span></div></div>
        </div>
        <div class="quiz-navigation">
          <button type="button" class="btn btn-outline-secondary prev-step">Previous</button>
          <button type="button" class="btn bg_pink text-white next-step">Next</button>
        </div>
      </div>

      <!-- Step 4: Size Preference -->
      <div class="quiz-step" id="step4">
        <h3 class="text-center mb-4 text-dark">What size artwork are you looking for?</h3>
        <p class="text-center text-muted">Consider the space where you'll display the artwork</p>
        <div class="quiz-options">
          <div class="quiz-option text-dark" data-value="small"><div class="size-option"><i class="fa fa-arrows-alt fa-2x mb-2"></i><span>Small (under 24")</span></div></div>
          <div class="quiz-option text-dark" data-value="medium"><div class="size-option"><i class="fa fa-arrows-alt fa-2x mb-2"></i><span>Medium (24"-48")</span></div></div>
          <div class="quiz-option text-dark" data-value="large"><div class="size-option"><i class="fa fa-arrows-alt fa-2x mb-2"></i><span>Large (over 48")</span></div></div>
          <div class="quiz-option text-dark" data-value="any"><div class="size-option"><i class="fa fa-question fa-2x mb-2"></i><span>Not sure / Any size</span></div></div>
        </div>
        <div class="quiz-navigation">
          <button type="button" class="btn btn-outline-secondary prev-step">Previous</button>
          <!-- Changed name to avoid conflict if PHP processes based on it, though JS handles submit -->
          <button type="submit" class="btn bg_pink text-white" id="submit-quiz-js" name="submit-quiz-js">Get Recommendations</button>
        </div>
      </div>
    </div>
  </form>

  <!-- Quiz Results Section -->
  <div class="container advisor-results" id="results" style="display:none;">
    <div class="text-center mb-5">
      <h2 class="font_60">Your Personalized Art Recommendations</h2>
      <p class="lead">Based on your preferences, we've selected these artworks we think you'll love</p>
    </div>
    <div class="art-grid" id="recommended-artworks">
      <!-- Art recommendations will be inserted here by JavaScript -->
    </div>
    <div class="text-center mt-5">
      <a href="gallery.html" class="btn bg_pink text-white btn-lg">Browse Full Gallery</a>
    </div>
  </div>
</section>

<!-- Featured Artists Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font_60">Featured Artists</h2>
            <p>Discover talented artists creating works in styles you love</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="img/artist1.jpg" class="card-img-top" alt="Artist 1">
                    <div class="card-body text-center">
                        <h4>Sophia Chen</h4>
                        <p class="text-muted">Abstract Expressionism</p>
                        <a href="artist-sophia.html" class="btn btn-sm bg_pink text-white">View Portfolio</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="img/artist2.jpg" class="card-img-top" alt="Artist 2">
                    <div class="card-body text-center">
                        <h4>Marcus Johnson</h4>
                        <p class="text-muted">Contemporary Realism</p>
                        <a href="artist-marcus.html" class="btn btn-sm bg_pink text-white">View Portfolio</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="img/artist3.jpg" class="card-img-top" alt="Artist 3">
                    <div class="card-body text-center">
                        <h4>Elena Rodriguez</h4>
                        <p class="text-muted">Mixed Media</p>
                        <a href="artist-elena.html" class="btn btn-sm bg_pink text-white">View Portfolio</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="artists.html" class="btn btn-outline-secondary">View All Artists</a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Art Advisor</h5>
                <p>Helping you discover art you'll love since 2023. Our personalized recommendations connect you with artworks that match your unique taste.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.html" class="text-white">Home</a></li>
                    <li><a href="advisor.html" class="text-white">Art Advisor</a></li>
                    <li><a href="gallery.html" class="text-white">Gallery</a></li>
                    <li><a href="artists.html" class="text-white">Artists</a></li>
                    <li><a href="about.html" class="text-white">About Us</a></li>
                    <li><a href="contact.html" class="text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Stay Connected</h5>
                <p>Subscribe to our newsletter for new artwork alerts and special offers.</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Your email">
                    <button class="btn bg_pink text-white" type="button">Subscribe</button>
                </div>
                <div class="social-icons">
                    <a href="#" class="text-white me-2"><i class="fa fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-2"><i class="fa fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white me-2"><i class="fa fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fa fa-pinterest fa-lg"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">© 2023 Art Advisor. All rights reserved.</p>
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

<!-- Theme Toggle Button -->
<button class="theme-toggle" id="themeToggle">
    <i class="fa fa-moon"></i>
</button>

<!-- JavaScript -->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quizForm = document.getElementById('quizForm');
    const steps = document.querySelectorAll('.quiz-step');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const submitButton = document.getElementById('submit-quiz-js'); // Matched ID with HTML
    const progressBar = document.getElementById('quiz-progress');
    const resultsSection = document.getElementById('results');
    const quizContainer = document.querySelector('.quiz-container');
    const artGrid = document.getElementById('recommended-artworks');

    // Hidden input fields
    const hiddenColors = document.getElementById('hidden-colors');
    const hiddenStyles = document.getElementById('hidden-styles');
    const hiddenBudget = document.getElementById('hidden-budget');
    const hiddenSize = document.getElementById('hidden-size');

    let currentStep = 0;
    const totalSteps = steps.length;

    const artworks = [ // This is still client-side example data
        { id: 1, title: "Vibrant Horizons", artist: "Sophia Chen", price: "$1,200", image: "img/5.jpg", tags: ["abstract", "vibrant", "large", "500-2000"], style: "Abstract Expressionism" },
        { id: 2, title: "Eternal Sunset", artist: "Marcus Johnson", price: "$2,800", image: "img/6.jpg", tags: ["realism", "earthy", "medium", "2000-5000"], style: "Contemporary Realism" },
        { id: 3, title: "Urban Reflections", artist: "Elena Rodriguez", price: "$3,500", image: "img/7.jpg", tags: ["modern", "cool", "large", "2000-5000"], style: "Mixed Media" },
        { id: 4, title: "Whispering Pastels", artist: "David Kim", price: "$950", image: "img/8.jpg", tags: ["impressionism", "pastel", "medium", "500-2000"], style: "Modern Impressionism" },
        { id: 5, title: "Metallic Dreams", artist: "Aisha Patel", price: "$4,200", image: "img/9.jpg", tags: ["abstract", "metallic", "large", "over5000"], style: "Abstract Sculpture" },
        { id: 6, title: "Monochrome Memories", artist: "James Wilson", price: "$1,800", image: "img/10.jpg", tags: ["photography", "monochrome", "medium", "500-2000"], style: "Fine Art Photography" }
    ];

    const userPreferences = {
        colors: [],
        styles: [],
        budget: '',
        size: ''
    };

    updateProgressBar();

    nextButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                steps[currentStep].classList.remove('active');
                currentStep++;
                steps[currentStep].classList.add('active');
                updateProgressBar();
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            steps[currentStep].classList.remove('active');
            currentStep--;
            steps[currentStep].classList.add('active');
            updateProgressBar();
        });
    });

    document.querySelectorAll('.quiz-option').forEach(option => {
        option.addEventListener('click', function () {
            const stepId = this.closest('.quiz-step').id;
            const value = this.dataset.value;

            this.classList.toggle('selected');

            if (stepId === 'step1') {
                if (this.classList.contains('selected')) {
                    if (!userPreferences.colors.includes(value)) {
                        userPreferences.colors.push(value);
                    }
                } else {
                    userPreferences.colors = userPreferences.colors.filter(c => c !== value);
                }
            } else if (stepId === 'step2') {
                if (this.classList.contains('selected')) {
                    if (!userPreferences.styles.includes(value)) {
                        if (userPreferences.styles.length < 3) {
                            userPreferences.styles.push(value);
                        } else {
                            this.classList.remove('selected');
                            alert('Please select no more than 3 styles');
                        }
                    }
                } else {
                    userPreferences.styles = userPreferences.styles.filter(s => s !== value);
                }
            } else if (stepId === 'step3') { // Radio button behavior
                document.querySelectorAll(`#${stepId} .quiz-option`).forEach(opt => {
                    if (opt !== this) opt.classList.remove('selected');
                });
                if (this.classList.contains('selected')) {
                    userPreferences.budget = value;
                } else { // If unselected by clicking again (though toggle makes this tricky for radio)
                    userPreferences.budget = '';
                }
            } else if (stepId === 'step4') { // Radio button behavior
                document.querySelectorAll(`#${stepId} .quiz-option`).forEach(opt => {
                    if (opt !== this) opt.classList.remove('selected');
                });
                 if (this.classList.contains('selected')) {
                    userPreferences.size = value;
                } else {
                    userPreferences.size = '';
                }
            }
        });
    });

    quizForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (validateStep(currentStep)) {
            hiddenColors.value = userPreferences.colors.join(',');
            hiddenStyles.value = userPreferences.styles.join(',');
            hiddenBudget.value = userPreferences.budget;
            hiddenSize.value = userPreferences.size;

            const formData = new FormData(quizForm);
            // Add the submit button's name/value if PHP script checks for it specifically
            formData.append('submit-quiz', '1');


            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';

            fetch('', { // POST to the current page URL
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Check if the response is ok (status in the range 200-299)
                // Then, try to parse it as JSON. If parsing fails, it will also go to catch.
                if (!response.ok) {
                    // Try to get error message from JSON response if server sent one
                    return response.json().then(errData => {
                        throw new Error(errData.message || `Server responded with status: ${response.status}`);
                    }).catch(() => {
                        // If response isn't JSON or .json() fails for other reasons
                        throw new Error(`Network response was not ok. Status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                submitButton.disabled = false;
                submitButton.textContent = 'Get Recommendations';

                if (data.status === 'success') {
                    console.log('Quiz answers saved successfully:', data.message, 'QuizID:', data.quizID);
                    const recommendedArtworks = getRecommendations(); // Get local recommendations for display
                    displayResults(recommendedArtworks);
                    if (quizContainer && resultsSection) {
                        quizContainer.style.display = 'none';
                        resultsSection.style.display = 'block';
                        window.scrollTo({
                            top: resultsSection.offsetTop - 100, // Adjust scroll offset as needed
                            behavior: 'smooth'
                        });
                    }
                } else {
                    // Server responded with status: 'error' (but HTTP was OK)
                    console.error('Error saving quiz answers (from server):', data.message);
                    alert('There was an error submitting your preferences: ' + (data.message || 'Unknown server error.'));
                    // Optionally, still show local recommendations or keep quiz visible
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                submitButton.textContent = 'Get Recommendations';
                console.error('Fetch processing error:', error.message);

                // Fallback behavior as in original code
                const recommendedArtworks = getRecommendations();
                displayResults(recommendedArtworks);
                if (quizContainer && resultsSection) {
                    quizContainer.style.display = 'none';
                    resultsSection.style.display = 'block';
                    window.scrollTo({
                        top: resultsSection.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
                alert('Could not save your preferences to the server. Displaying local recommendations. Details: ' + error.message);
            });
        }
    });

    function updateProgressBar() {
        const progress = ((currentStep + 1) / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
    }

    function validateStep(stepIndex) {
        // Ensure selections are made for radio-button like steps (budget, size)
        if (stepIndex === 0 && userPreferences.colors.length === 0) {
            alert('Please select at least one color preference');
            return false;
        } else if (stepIndex === 1 && userPreferences.styles.length === 0) {
            alert('Please select at least one art style');
            return false;
        } else if (stepIndex === 2 && !userPreferences.budget) {
            // Check if any budget option is selected
            const budgetSelected = Array.from(document.querySelectorAll('#step3 .quiz-option.selected')).length > 0;
            if (!budgetSelected && !userPreferences.budget) { // Double check, userPreferences.budget should be set
                alert('Please select a budget range');
                return false;
            }
        } else if (stepIndex === 3 && !userPreferences.size) {
             // Check if any size option is selected
            const sizeSelected = Array.from(document.querySelectorAll('#step4 .quiz-option.selected')).length > 0;
            if (!sizeSelected && !userPreferences.size) {
                alert('Please select a size preference');
                return false;
            }
        }
        return true;
    }

    function getRecommendations() { // This is still based on client-side 'artworks' array
        return artworks.filter(artwork => {
            const colorMatch = userPreferences.colors.length === 0 ? true : userPreferences.colors.some(color => artwork.tags.includes(color));
            const styleMatch = userPreferences.styles.length === 0 ? true : userPreferences.styles.some(style => artwork.tags.includes(style));
            const budgetMatch = !userPreferences.budget || artwork.tags.includes(userPreferences.budget);
            const sizeMatch = !userPreferences.size || userPreferences.size === 'any' || artwork.tags.includes(userPreferences.size);

            let meetsCriteria = true;
            if (userPreferences.colors.length > 0 && !colorMatch) meetsCriteria = false;
            if (userPreferences.styles.length > 0 && !styleMatch) meetsCriteria = false;
            if (userPreferences.budget && !budgetMatch) meetsCriteria = false; // only check if budget is set
            if (userPreferences.size && userPreferences.size !== 'any' && !sizeMatch) meetsCriteria = false; // only check if size is set and not 'any'

            return meetsCriteria;
        });
    }

    function displayResults(recommendedArtworks) {
        artGrid.innerHTML = '';
        if (recommendedArtworks.length === 0) {
            artGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <h4>No exact matches found based on your preferences. One of our Art Advisors will reach out to you later with curated suggestions; please check your emails.</h4>
                    <p class="text-muted small">If you believe this is an error, please ensure your preferences were saved correctly or try again.</p>
                </div>
            `;
            return;
        }
        recommendedArtworks.forEach(artwork => {
            const artItem = document.createElement('div');
            artItem.className = 'art-item'; // Ensure this class is styled for grid layout
            artItem.innerHTML = `
                <img src="${artwork.image}" alt="${artwork.title}">
                <div class="art-info">
                    <h4>${artwork.title}</h4>
                    <p>${artwork.artist} • ${artwork.style}</p>
                    <p class="art-price">${artwork.price}</p>
                    <a href="artwork-detail.html?id=${artwork.id}" class="btn btn-sm bg_pink text-white">View Details</a>
                </div>
            `;
            artGrid.appendChild(artItem);
        });
    }

    // Theme Toggle and Sticky Navbar (unchanged)
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                themeToggle.innerHTML = '<i class="fa fa-sun"></i>';
                themeToggle.setAttribute('title', 'Switch to dark mode');
            } else {
                themeToggle.innerHTML = '<i class="fa fa-moon"></i>';
                themeToggle.setAttribute('title', 'Switch to light mode');
            }
        });
    }

    const navbar = document.getElementById("navbar_sticky");
    if (navbar) {
        const sticky = navbar.offsetTop;
        const navbar_height = navbar.offsetHeight;

        window.onscroll = function () { stickyNavbar(); };

        function stickyNavbar() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky");
                document.body.style.paddingTop = navbar_height + 'px';
            } else {
                navbar.classList.remove("sticky");
                document.body.style.paddingTop = '0';
            }
        }
        if (window.pageYOffset >= sticky) { // Apply sticky on load if already scrolled
            stickyNavbar();
        }
    }
});
</script>
</body>
</html>