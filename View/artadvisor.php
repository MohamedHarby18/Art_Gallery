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
	<?php
	include './includes/header.php';
	?>

<!-- Hero Section -->
<section class="advisor-hero">
    <div class="container">
        <h1 class="font_60">Discover Art You'll Love</h1>
        <p class="lead">Take our quick quiz and we'll recommend artworks perfectly matched to your taste</p>
        <a href="#quiz" class="btn btn-lg bg_pink text-white mt-3">Start Quiz</a>
    </div>
</section>

<!-- Quiz Container -->
<section id="quiz" class="py-5">
    <div class="quiz-container">
        <div class="text-center mb-4">
            <h2>Art Advisor Quiz</h2>
            <p class="text-muted">Answer a few questions to get personalized recommendations</p>
            <div class="progress-container">
                <div class="progress-bar" id="quiz-progress"></div>
            </div>
        </div>
        
        <!-- Step 1: Color Preferences -->
        <div class="quiz-step active" id="step1">
            <h3 class="text-center mb-4">What colors speak to you?</h3>
            <p class="text-center text-muted">Select all that appeal to you</p>
            
            <div class="quiz-options">
                <div class="quiz-option" data-value="vibrant">
                    <div class="color-option" style="background: linear-gradient(135deg, #ff0000, #ff9900);"></div>
                    <span>Vibrant</span>
                </div>
                <div class="quiz-option" data-value="earthy">
                    <div class="color-option" style="background: linear-gradient(135deg, #8B4513, #CD853F);"></div>
                    <span>Earthy</span>
                </div>
                <div class="quiz-option" data-value="cool">
                    <div class="color-option" style="background: linear-gradient(135deg, #0000ff, #00ffff);"></div>
                    <span>Cool Tones</span>
                </div>
                <div class="quiz-option" data-value="pastel">
                    <div class="color-option" style="background: linear-gradient(135deg, #ffb6c1, #e6e6fa);"></div>
                    <span>Pastel</span>
                </div>
                <div class="quiz-option" data-value="monochrome">
                    <div class="color-option" style="background: linear-gradient(135deg, #000000, #666666);"></div>
                    <span>Monochrome</span>
                </div>
                <div class="quiz-option" data-value="metallic">
                    <div class="color-option" style="background: linear-gradient(135deg, #D4AF37, #C0C0C0);"></div>
                    <span>Metallic</span>
                </div>
            </div>
            
            <div class="quiz-navigation">
                <button class="btn btn-outline-secondary" disabled>Previous</button>
                <button class="btn bg_pink text-white next-step">Next</button>
            </div>
        </div>
        
        <!-- Step 2: Art Styles -->
        <div class="quiz-step" id="step2">
            <h3 class="text-center mb-4">Which art styles do you prefer?</h3>
            <p class="text-center text-muted">Choose up to 3 styles</p>
            
            <div class="quiz-options">
                <div class="quiz-option" data-value="abstract">
                    <div class="style-option">
                        <i class="fa fa-paint-brush fa-2x mb-2"></i>
                        <span>Abstract</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="realism">
                    <div class="style-option">
                        <i class="fa fa-eye fa-2x mb-2"></i>
                        <span>Realism</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="impressionism">
                    <div class="style-option">
                        <i class="fa fa-sun-o fa-2x mb-2"></i>
                        <span>Impressionism</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="modern">
                    <div class="style-option">
                        <i class="fa fa-bolt fa-2x mb-2"></i>
                        <span>Modern</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="photography">
                    <div class="style-option">
                        <i class="fa fa-camera fa-2x mb-2"></i>
                        <span>Photography</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="sculpture">
                    <div class="style-option">
                        <i class="fa fa-cube fa-2x mb-2"></i>
                        <span>Sculpture</span>
                    </div>
                </div>
            </div>
            
            <div class="quiz-navigation">
                <button class="btn btn-outline-secondary prev-step">Previous</button>
                <button class="btn bg_pink text-white next-step">Next</button>
            </div>
        </div>
        
        <!-- Step 3: Budget -->
        <div class="quiz-step" id="step3">
            <h3 class="text-center mb-4">What's your budget range?</h3>
            <p class="text-center text-muted">This helps us recommend artworks in your price range</p>
            
            <div class="quiz-options">
                <div class="quiz-option" data-value="under500">
                    <div class="budget-option">
                        <i class="fa fa-usd fa-2x mb-2"></i>
                        <span>Under $500</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="500-2000">
                    <div class="budget-option">
                        <i class="fa fa-usd fa-2x mb-2"></i><i class="fa fa-usd fa-2x mb-2"></i>
                        <span>$500 - $2,000</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="2000-5000">
                    <div class="budget-option">
                        <i class="fa fa-usd fa-2x mb-2"></i><i class="fa fa-usd fa-2x mb-2"></i><i class="fa fa-usd fa-2x mb-2"></i>
                        <span>$2,000 - $5,000</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="over5000">
                    <div class="budget-option">
                        <i class="fa fa-money fa-2x mb-2"></i>
                        <span>Over $5,000</span>
                    </div>
                </div>
            </div>
            
            <div class="quiz-navigation">
                <button class="btn btn-outline-secondary prev-step">Previous</button>
                <button class="btn bg_pink text-white next-step">Next</button>
            </div>
        </div>
        
        <!-- Step 4: Size Preference -->
        <div class="quiz-step" id="step4">
            <h3 class="text-center mb-4">What size artwork are you looking for?</h3>
            <p class="text-center text-muted">Consider the space where you'll display the artwork</p>
            
            <div class="quiz-options">
                <div class="quiz-option" data-value="small">
                    <div class="size-option">
                        <i class="fa fa-arrows-alt fa-2x mb-2"></i>
                        <span>Small (under 24")</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="medium">
                    <div class="size-option">
                        <i class="fa fa-arrows-alt fa-2x mb-2"></i>
                        <span>Medium (24"-48")</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="large">
                    <div class="size-option">
                        <i class="fa fa-arrows-alt fa-2x mb-2"></i>
                        <span>Large (over 48")</span>
                    </div>
                </div>
                <div class="quiz-option" data-value="any">
                    <div class="size-option">
                        <i class="fa fa-question fa-2x mb-2"></i>
                        <span>Not sure / Any size</span>
                    </div>
                </div>
            </div>
            
            <div class="quiz-navigation">
                <button class="btn btn-outline-secondary prev-step">Previous</button>
                <button class="btn bg_pink text-white" id="submit-quiz">Get Recommendations</button>
            </div>
        </div>
    </div>
    
    <!-- Results Section -->
    <div class="container advisor-results" id="results">
        <div class="text-center mb-5">
            <h2 class="font_60">Your Personalized Art Recommendations</h2>
            <p class="lead">Based on your preferences, we've selected these artworks we think you'll love</p>
        </div>
        
        <div class="art-grid" id="recommended-artworks">
            <!-- Artworks will be inserted here by JavaScript -->
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
                <p class="mb-0">&copy; 2023 Art Advisor. All rights reserved.</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Quiz functionality
        const steps = document.querySelectorAll('.quiz-step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const submitButton = document.getElementById('submit-quiz');
        const progressBar = document.getElementById('quiz-progress');
        const resultsSection = document.getElementById('results');
        const quizContainer = document.querySelector('.quiz-container');
        const artGrid = document.getElementById('recommended-artworks');
        
        let currentStep = 0;
        const totalSteps = steps.length;
        
        // Sample artwork data (in a real app, this would come from an API)
        const artworks = [
            {
                id: 1,
                title: "Vibrant Horizons",
                artist: "Sophia Chen",
                price: "$1,200",
                image: "img/5.jpg",
                tags: ["abstract", "vibrant", "large", "500-2000"],
                style: "Abstract Expressionism"
            },
            {
                id: 2,
                title: "Eternal Sunset",
                artist: "Marcus Johnson",
                price: "$2,800",
                image: "img/6.jpg",
                tags: ["realism", "earthy", "medium", "2000-5000"],
                style: "Contemporary Realism"
            },
            {
                id: 3,
                title: "Urban Reflections",
                artist: "Elena Rodriguez",
                price: "$3,500",
                image: "img/7.jpg",
                tags: ["modern", "cool", "large", "2000-5000"],
                style: "Mixed Media"
            },
            {
                id: 4,
                title: "Whispering Pastels",
                artist: "David Kim",
                price: "$950",
                image: "img/8.jpg",
                tags: ["impressionism", "pastel", "medium", "500-2000"],
                style: "Modern Impressionism"
            },
            {
                id: 5,
                title: "Metallic Dreams",
                artist: "Aisha Patel",
                price: "$4,200",
                image: "img/9.jpg",
                tags: ["abstract", "metallic", "large", "over5000"],
                style: "Abstract Sculpture"
            },
            {
                id: 6,
                title: "Monochrome Memories",
                artist: "James Wilson",
                price: "$1,800",
                image: "img/10.jpg",
                tags: ["photography", "monochrome", "medium", "500-2000"],
                style: "Fine Art Photography"
            }
        ];
        
        // User preferences object
        const userPreferences = {
            colors: [],
            styles: [],
            budget: '',
            size: ''
        };
        
        // Initialize quiz
        updateProgressBar();
        
        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    steps[currentStep].classList.remove('active');
                    currentStep++;
                    steps[currentStep].classList.add('active');
                    updateProgressBar();
                }
            });
        });
        
        // Previous button click handler
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                steps[currentStep].classList.remove('active');
                currentStep--;
                steps[currentStep].classList.add('active');
                updateProgressBar();
            });
        });
        
        // Option selection handler
        document.querySelectorAll('.quiz-option').forEach(option => {
            option.addEventListener('click', function() {
                const stepId = this.closest('.quiz-step').id;
                const value = this.dataset.value;
                
                // Toggle selection
                this.classList.toggle('selected');
                
                // Update preferences based on step
                if (stepId === 'step1') {
                    // Color selection (multiple allowed)
                    if (this.classList.contains('selected')) {
                        if (!userPreferences.colors.includes(value)) {
                            userPreferences.colors.push(value);
                        }
                    } else {
                        userPreferences.colors = userPreferences.colors.filter(c => c !== value);
                    }
                } else if (stepId === 'step2') {
                    // Style selection (multiple allowed)
                    if (this.classList.contains('selected')) {
                        if (!userPreferences.styles.includes(value)) {
                            // Limit to 3 selections
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
                } else if (stepId === 'step3') {
                    // Budget selection (single choice)
                    if (this.classList.contains('selected')) {
                        // Deselect other options
                        document.querySelectorAll(`#${stepId} .quiz-option`).forEach(opt => {
                            if (opt !== this) opt.classList.remove('selected');
                        });
                        userPreferences.budget = value;
                    } else {
                        userPreferences.budget = '';
                    }
                } else if (stepId === 'step4') {
                    // Size selection (single choice)
                    if (this.classList.contains('selected')) {
                        // Deselect other options
                        document.querySelectorAll(`#${stepId} .quiz-option`).forEach(opt => {
                            if (opt !== this) opt.classList.remove('selected');
                        });
                        userPreferences.size = value;
                    } else {
                        userPreferences.size = '';
                    }
                }
            });
        });
        
        // Submit quiz handler
        submitButton.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                // Process recommendations
                const recommendedArtworks = getRecommendations();
                
                // Display results
                displayResults(recommendedArtworks);
                
                // Hide quiz and show results
                quizContainer.style.display = 'none';
                resultsSection.style.display = 'block';
                
                // Smooth scroll to results
                window.scrollTo({
                    top: resultsSection.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
        
        // Update progress bar
        function updateProgressBar() {
            const progress = ((currentStep + 1) / totalSteps) * 100;
            progressBar.style.width = `${progress}%`;
        }
        
        // Validate current step before proceeding
        function validateStep(stepIndex) {
            if (stepIndex === 0) {
                if (userPreferences.colors.length === 0) {
                    alert('Please select at least one color preference');
                    return false;
                }
            } else if (stepIndex === 1) {
                if (userPreferences.styles.length === 0) {
                    alert('Please select at least one art style');
                    return false;
                }
            } else if (stepIndex === 2) {
                if (!userPreferences.budget) {
                    alert('Please select a budget range');
                    return false;
                }
            } else if (stepIndex === 3) {
                if (!userPreferences.size) {
                    alert('Please select a size preference');
                    return false;
                }
            }
            return true;
        }
        
        // Get recommendations based on user preferences
        function getRecommendations() {
            // Filter artworks based on preferences
            return artworks.filter(artwork => {
                // Check color match
                const colorMatch = userPreferences.colors.some(color => 
                    artwork.tags.includes(color)
                );
                
                // Check style match
                const styleMatch = userPreferences.styles.some(style => 
                    artwork.tags.includes(style)
                );
                
                // Check budget match
                const budgetMatch = !userPreferences.budget || 
                                  artwork.tags.includes(userPreferences.budget);
                
                // Check size match
                const sizeMatch = !userPreferences.size || 
                                userPreferences.size === 'any' ||
                                artwork.tags.includes(userPreferences.size);
                
                return colorMatch && styleMatch && budgetMatch && sizeMatch;
            });
        }
        
        // Display recommended artworks
        function displayResults(recommendedArtworks) {
            artGrid.innerHTML = '';
            
            if (recommendedArtworks.length === 0) {
                artGrid.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <h4>We couldn't find exact matches for your preferences</h4>
                        <p>Try broadening your selections or browse our full gallery</p>
                        <a href="gallery.html" class="btn bg_pink text-white">Browse Gallery</a>
                    </div>
                `;
                return;
            }
            
            recommendedArtworks.forEach(artwork => {
                const artItem = document.createElement('div');
                artItem.className = 'art-item';
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
        
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('light-mode');
            
            if (document.body.classList.contains('light-mode')) {
                themeToggle.innerHTML = '<i class="fa fa-sun"></i>';
                themeToggle.setAttribute('title', 'Switch to dark mode');
            } else {
                themeToggle.innerHTML = '<i class="fa fa-moon"></i>';
                themeToggle.setAttribute('title', 'Switch to light mode');
            }
        });
        
        // Make navbar sticky
        window.onscroll = function() {stickyNavbar()};
        
        var navbar = document.getElementById("navbar_sticky");
        var sticky = navbar.offsetTop;
        var navbar_height = navbar.offsetHeight;
        
        function stickyNavbar() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky");
                document.body.style.paddingTop = navbar_height + 'px';
            } else {
                navbar.classList.remove("sticky");
                document.body.style.paddingTop = '0';
            }
        }
    });
</script>
</body>
</html>