<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Your Virtual Gallery</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <style>
        /* Gallery Creation Form Styles */
        .creation-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('img/create-gallery-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .creation-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }

        .form-section {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #a81c51;
            display: flex;
            align-items: center;
        }

        .section-title .number {
            background: #a81c51;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #a81c51;
            box-shadow: 0 0 0 0.25rem rgba(168, 28, 81, 0.25);
        }

        .theme-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .theme-option {
            border: 2px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .theme-option.selected {
            border-color: #a81c51;
            box-shadow: 0 5px 15px rgba(168, 28, 81, 0.2);
        }

        .theme-preview {
            height: 100px;
            background-size: cover;
            background-position: center;
        }

        .theme-name {
            padding: 10px;
            text-align: center;
            font-weight: 600;
        }

        .artwork-upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .artwork-upload-area:hover {
            border-color: #a81c51;
            background: rgba(168, 28, 81, 0.05);
        }

        .upload-icon {
            font-size: 3rem;
            color: #a81c51;
            margin-bottom: 15px;
        }

        .uploaded-artworks {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .artwork-thumbnail {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            height: 150px;
        }

        .artwork-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .artwork-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: space-between;
            padding: 8px;
            transform: translateY(100%);
            transition: transform 0.3s;
        }

        .artwork-thumbnail:hover .artwork-actions {
            transform: translateY(0);
        }

        .artwork-actions a {
            color: white;
            font-size: 0.9rem;
        }

        .artwork-details {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }

        .btn-create {
            background: #a81c51;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s;
        }

        .btn-create:hover {
            background: #8c1642;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(168, 28, 81, 0.3);
        }

        /* Preview Modal */
        .preview-modal .modal-content {
            border-radius: 10px;
            overflow: hidden;
        }

        .preview-header {
            background: #a81c51;
            color: white;
            padding: 15px;
        }

        .preview-body {
            padding: 0;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .creation-container {
                padding: 20px;
            }

            .theme-options {
                grid-template-columns: 1fr 1fr;
            }

            .uploaded-artworks {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .theme-options {
                grid-template-columns: 1fr;
            }

            .uploaded-artworks {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!--nav Start -->
    <?php
    include __DIR__ . '/includes/header.html';
    ?>
    <!--nav end -->

    <!-- Hero Section -->
    <section class="creation-hero">
        <div class="container">
            <h1 class="font_60">Create Your Virtual Gallery</h1>
            <p class="lead">Showcase your artwork in a beautiful online exhibition space</p>
        </div>
    </section>

    <!-- Gallery Creation Form -->
    <div class="container">
        <div class="creation-container">
            <form id="galleryCreationForm">
                <!-- Step 1: Basic Information -->
                <div class="form-section">
                    <h3 class="section-title"><span class="number">1</span> Gallery Information</h3>

                    <div class="mb-4">
                        <label for="galleryName" class="form-label">Gallery Title*</label>
                        <input type="text" class="form-control" id="galleryName" placeholder="e.g. 'Urban Perspectives'" required>
                    </div>

                    <div class="mb-4">
                        <label for="galleryDescription" class="form-label">Description*</label>
                        <textarea class="form-control" id="galleryDescription" rows="4" placeholder="Tell visitors about your exhibition theme, inspiration, etc." required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="startDate" class="form-label">Exhibition Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="endDate" class="form-label">Exhibition End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="galleryCategory" class="form-label">Category/Theme*</label>
                        <select class="form-select" id="galleryCategory" required>
                            <option value="" selected disabled>Select a category</option>
                            <option value="abstract">Abstract</option>
                            <option value="realism">Realism</option>
                            <option value="photography">Photography</option>
                            <option value="sculpture">Sculpture</option>
                            <option value="digital">Digital Art</option>
                            <option value="mixed">Mixed Media</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Step 2: Gallery Theme -->
                <div class="form-section">
                    <h3 class="section-title"><span class="number">2</span> Gallery Theme</h3>
                    <p>Choose a visual theme for your virtual gallery space</p>

                    <div class="theme-options">
                        <div class="theme-option selected" data-theme="classic">
                            <div class="theme-preview" style="background-image: url('img/theme-classic-preview.jpg');"></div>
                            <div class="theme-name">Classic</div>
                        </div>
                        <div class="theme-option" data-theme="modern">
                            <div class="theme-preview" style="background-image: url('img/theme-modern-preview.jpg');"></div>
                            <div class="theme-name">Modern</div>
                        </div>
                        <div class="theme-option" data-theme="minimal">
                            <div class="theme-preview" style="background-image: url('img/theme-minimal-preview.jpg');"></div>
                            <div class="theme-name">Minimal</div>
                        </div>
                        <div class="theme-option" data-theme="dark">
                            <div class="theme-preview" style="background-image: url('img/theme-dark-preview.jpg');"></div>
                            <div class="theme-name">Dark</div>
                        </div>
                    </div>

                    <input type="hidden" id="selectedTheme" value="classic">
                </div>

                <!-- Step 3: Upload Artwork -->
                <div class="form-section">
                    <h3 class="section-title"><span class="number">3</span> Add Your Artwork</h3>

                    <div class="artwork-upload-area" id="dropArea">
                        <div class="upload-icon">
                            <i class="fa fa-cloud-upload"></i>
                        </div>
                        <h4>Drag & Drop Artwork Images Here</h4>
                        <p class="text-muted">or</p>
                        <button type="button" class="btn btn-outline-secondary" id="browseFiles">Browse Files</button>
                        <input type="file" id="fileInput" multiple accept="image/*" style="display: none;">
                    </div>

                    <div class="uploaded-artworks" id="uploadedArtworks">
                        <!-- Artwork thumbnails will be added here by JavaScript -->
                        <div class="text-center py-4" id="noArtworksMessage">
                            <p class="text-muted">No artworks added yet</p>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Artwork Details -->
                <div class="form-section" id="artworkDetailsSection" style="display: none;">
                    <h3 class="section-title"><span class="number">4</span> Artwork Details</h3>
                    <p>Provide details for each artwork in your gallery</p>

                    <div id="artworkDetailsContainer">
                        <!-- Artwork detail forms will be added here by JavaScript -->
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="text-center mt-5">
                    <button type="button" class="btn btn-outline-secondary me-3" data-bs-toggle="modal" data-bs-target="#previewModal">Preview Gallery</button>
                    <button type="submit" class="btn-create">Create Gallery</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade preview-modal" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="preview-header">
                    <h5 class="modal-title" id="previewModalLabel">Gallery Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="preview-body">
                    <div class="ratio ratio-16x9">
                        <iframe id="galleryPreviewFrame" src="about:blank"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg_pink text-white">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Artist Portal</h5>
                    <p>Platform for artists to create and share virtual exhibitions. Showcase your work in customizable gallery spaces.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-white">Home</a></li>
                        <li><a href="my-galleries.html" class="text-white">My Galleries</a></li>
                        <li><a href="create-gallery.html" class="text-white">Create Gallery</a></li>
                        <li><a href="profile.html" class="text-white">Artist Profile</a></li>
                        <li><a href="help.html" class="text-white">Help Center</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Support</h5>
                    <p>Email: support@artistportal.com<br>
                        Phone: (123) 456-7890</p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3"><i class="fa fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2023 Artist Portal. All rights reserved.</p>
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

    <!-- JavaScript -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make navbar sticky
            window.onscroll = function() {
                stickyNavbar()
            };

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

            // Theme selection
            const themeOptions = document.querySelectorAll('.theme-option');
            const selectedThemeInput = document.getElementById('selectedTheme');

            themeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    themeOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedThemeInput.value = this.dataset.theme;
                });
            });

            // File upload functionality
            const dropArea = document.getElementById('dropArea');
            const fileInput = document.getElementById('fileInput');
            const browseFilesBtn = document.getElementById('browseFiles');
            const uploadedArtworks = document.getElementById('uploadedArtworks');
            const noArtworksMessage = document.getElementById('noArtworksMessage');
            const artworkDetailsSection = document.getElementById('artworkDetailsSection');
            const artworkDetailsContainer = document.getElementById('artworkDetailsContainer');

            let uploadedFiles = [];

            // Handle browse files button click
            browseFilesBtn.addEventListener('click', function() {
                fileInput.click();
            });

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                handleFiles(e.target.files);
            });

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.style.borderColor = '#a81c51';
                dropArea.style.backgroundColor = 'rgba(168, 28, 81, 0.1)';
            }

            function unhighlight() {
                dropArea.style.borderColor = '#ddd';
                dropArea.style.backgroundColor = '';
            }

            dropArea.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            });

            // Handle uploaded files
            function handleFiles(files) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.match('image.*')) {
                        uploadedFiles.push(file);
                        previewFile(file);
                    }
                }

                if (uploadedFiles.length > 0) {
                    noArtworksMessage.style.display = 'none';
                    artworkDetailsSection.style.display = 'block';
                    generateArtworkDetailForms();
                }
            }

            // Preview uploaded files
            function previewFile(file) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() {
                    const artworkId = 'artwork-' + Date.now();
                    const thumbnail = document.createElement('div');
                    thumbnail.className = 'artwork-thumbnail';
                    thumbnail.id = artworkId;
                    thumbnail.innerHTML = `
                    <img src="${reader.result}" alt="${file.name}">
                    <div class="artwork-actions">
                        <a href="#" class="edit-artwork" data-id="${artworkId}"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="delete-artwork" data-id="${artworkId}"><i class="fa fa-trash"></i></a>
                    </div>
                `;
                    uploadedArtworks.insertBefore(thumbnail, noArtworksMessage);

                    // Add delete functionality
                    thumbnail.querySelector('.delete-artwork').addEventListener('click', function(e) {
                        e.preventDefault();
                        deleteArtwork(artworkId, file.name);
                    });
                };
            }

            // Delete artwork
            function deleteArtwork(artworkId, filename) {
                if (confirm('Are you sure you want to remove this artwork?')) {
                    // Remove from DOM
                    document.getElementById(artworkId).remove();

                    // Remove from uploadedFiles array
                    uploadedFiles = uploadedFiles.filter(file => file.name !== filename);

                    // Show no artworks message if empty
                    if (uploadedFiles.length === 0) {
                        noArtworksMessage.style.display = 'block';
                        artworkDetailsSection.style.display = 'none';
                    } else {
                        generateArtworkDetailForms();
                    }
                }
            }

            // Generate artwork detail forms
            function generateArtworkDetailForms() {
                artworkDetailsContainer.innerHTML = '';

                uploadedFiles.forEach((file, index) => {
                    const artworkId = 'artwork-details-' + index;
                    const form = document.createElement('div');
                    form.className = 'artwork-details mb-4';
                    form.id = artworkId;
                    form.innerHTML = `
                    <h5>Artwork ${index + 1}: ${file.name}</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Title*</label>
                            <input type="text" class="form-control" name="artwork-title[]" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year Created</label>
                            <input type="text" class="form-control" name="artwork-year[]" placeholder="e.g. 2023">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Medium*</label>
                            <input type="text" class="form-control" name="artwork-medium[]" placeholder="e.g. Oil on Canvas" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dimensions</label>
                            <input type="text" class="form-control" name="artwork-dimensions[]" placeholder="e.g. 24 × 36 inches">
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="artwork-description[]" rows="2" placeholder="Brief description of the artwork"></textarea>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Price (USD)</label>
                            <input type="text" class="form-control" name="artwork-price[]" placeholder="e.g. 1200.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Is this artwork for sale?</label>
                            <select class="form-select" name="artwork-for-sale[]">
                                <option value="yes">Yes</option>
                                <option value="no" selected>No</option>
                            </select>
                        </div>
                    </div>
                `;
                    artworkDetailsContainer.appendChild(form);
                });
            }

            // Form submission
            const galleryForm = document.getElementById('galleryCreationForm');

            galleryForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                if (uploadedFiles.length === 0) {
                    alert('Please upload at least one artwork');
                    return;
                }

                // Collect form data
                const formData = new FormData();

                // Add gallery info
                formData.append('galleryName', document.getElementById('galleryName').value);
                formData.append('description', document.getElementById('galleryDescription').value);
                formData.append('startDate', document.getElementById('startDate').value);
                formData.append('endDate', document.getElementById('endDate').value);
                formData.append('category', document.getElementById('galleryCategory').value);
                formData.append('theme', selectedThemeInput.value);

                // Add artwork files
                uploadedFiles.forEach(file => {
                    formData.append('artworkFiles[]', file);
                });

                // Add artwork details
                const artworkForms = document.querySelectorAll('.artwork-details');
                artworkForms.forEach(form => {
                    const inputs = form.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        formData.append(input.name, input.value);
                    });
                });

                // In a real application, you would send this data to the server
                console.log('Form data prepared:', formData);

                // Simulate form submission
                alert('Gallery created successfully! Redirecting to your gallery...');
                // window.location.href = 'my-gallery.html';
            });

            // Preview modal
            const previewModal = document.getElementById('previewModal');
            const previewFrame = document.getElementById('galleryPreviewFrame');

            previewModal.addEventListener('show.bs.modal', function() {
                // In a real application, this would generate a preview based on the form data
                previewFrame.src = 'about:blank';

                // Simulate loading
                setTimeout(() => {
                    previewFrame.srcdoc = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Gallery Preview</title>
                        <style>
                            body { 
                                margin: 0; 
                                padding: 20px; 
                                font-family: Arial, sans-serif; 
                                background: #f5f5f5;
                            }
                            .preview-container {
                                max-width: 800px;
                                margin: 0 auto;
                                background: white;
                                padding: 20px;
                                border-radius: 10px;
                                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                            }
                            h1 {
                                color: #a81c51;
                                text-align: center;
                            }
                            .artwork-grid {
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                gap: 20px;
                                margin-top: 30px;
                            }
                            .artwork-preview {
                                border: 1px solid #ddd;
                                padding: 10px;
                                background: white;
                            }
                            .artwork-preview img {
                                width: 100%;
                                height: 150px;
                                object-fit: cover;
                            }
                            .artwork-info {
                                padding: 10px 0;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="preview-container">
                            <h1>${document.getElementById('galleryName').value || 'Your Gallery Title'}</h1>
                            <p>${document.getElementById('galleryDescription').value || 'Gallery description will appear here'}</p>
                            
                            <div class="artwork-grid">
                                ${uploadedFiles.slice(0, 4).map((file, index) => `
                                    <div class="artwork-preview">
                                        <img src="${URL.createObjectURL(file)}" alt="Artwork ${index + 1}">
                                        <div class="artwork-info">
                                            <h4>Artwork ${index + 1}</h4>
                                            <p>Details will appear here</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                            
                            ${uploadedFiles.length > 4 ? `<p class="text-center">+ ${uploadedFiles.length - 4} more artworks</p>` : ''}
                        </div>
                    </body>
                    </html>
                `;
                }, 500);
            });
        });
    </script>
</body>

</html>