<?php
// Start session - MUST be at the very top
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../Controller/DBArtworkManager.php'; // Include the new file
$db = new DBArtworkManager(); // Instantiate the new class

// --- AUTHENTICATION & PERMISSIONS ---
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to manage artworks.";
    header("Location: login.php");
    exit;
}
$artistId = (int)$_SESSION['user_id'];

// Ensure the logged-in user is an artist
$user_check = $db->select("SELECT Artist FROM users WHERE UserID = ?", [$artistId], "i");
if (!$user_check || count($user_check) === 0 || $user_check[0]['Artist'] != 1) {
    $_SESSION['error_message'] = "You do not have permission to manage artworks.";
    header("Location: ../View/artistprofile.php");
    exit;
}

// --- Determine Action (Add, Edit, Delete) ---
$action = $_GET['action'] ?? 'add';
$artworkId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Initialize form data and settings
$artwork_data = [
    'Title' => '',
    'Description' => '',
    'Catagory' => '',
    'Price' => '',
    'Image' => '',
    'numberInStock' => 1
];
$form_title = "Add New Artwork";
$submit_button_name = "add_artwork";
$submit_button_text = "Add Artwork";
$current_image_filename = '';

// --- If Editing, Fetch Existing Artwork Data ---
if ($action === 'edit' && $artworkId) {
    $existing_artwork_result = $db->select("SELECT * FROM artworks WHERE ArtworkID = ? AND ArtistID = ?", [$artworkId, $artistId], "ii");
    if ($existing_artwork_result && count($existing_artwork_result) > 0) {
        $artwork_data = $existing_artwork_result[0];
        $form_title = "Edit Artwork: " . htmlspecialchars($artwork_data['Title']);
        $submit_button_name = "update_artwork";
        $submit_button_text = "Update Artwork";
        $current_image_filename = $artwork_data['Image'];
    } else {
        $_SESSION['error_message'] = "Artwork not found or you don't have permission to edit it.";
        header("Location: ../View/artistprofile.php");
        exit;
    }
}

$errors = [];

// --- Handle Form Submission (Add or Update) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artwork_data['Title'] = trim($_POST['title'] ?? $artwork_data['Title']);
    $artwork_data['Description'] = trim($_POST['description'] ?? $artwork_data['Description']);
    $artwork_data['Catagory'] = trim($_POST['category'] ?? $artwork_data['Catagory']);
    $artwork_data['Price'] = $_POST['price'] ?? $artwork_data['Price'];
    $artwork_data['numberInStock'] = $_POST['numberInStock'] ?? $artwork_data['numberInStock'];

    if (empty($artwork_data['Title'])) $errors[] = "Title is required.";
    if (empty($artwork_data['Catagory'])) $errors[] = "Category is required.";
    $price_validated = filter_var($artwork_data['Price'], FILTER_VALIDATE_FLOAT);
    if ($price_validated === false || $price_validated < 0) {
        $errors[] = "Price must be a valid positive number.";
    } else { $artwork_data['Price'] = $price_validated; }
    $numberInStock_validated = filter_var($artwork_data['numberInStock'], FILTER_VALIDATE_INT);
    if ($numberInStock_validated === false || $numberInStock_validated < 0) {
        $errors[] = "Number in stock must be a valid non-negative integer.";
    } else { $artwork_data['numberInStock'] = $numberInStock_validated; }
    if (strlen($artwork_data['Description']) > 1000) $errors[] = "Description is too long (max 1000 characters).";

    $new_image_filename_to_save = $current_image_filename;
    $image_upload_error = false;
    if (isset($_FILES['artwork_image']) && $_FILES['artwork_image']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['artwork_image']['tmp_name'];
        $file_name = $_FILES['artwork_image']['name'];
        $file_size = $_FILES['artwork_image']['size'];
        $file_ext = strtolower(end(explode('.', $file_name)));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_ext, $allowed_extensions)) { $errors[] = "Invalid image type."; $image_upload_error = true; }
        if ($file_size > 5 * 1024 * 1024) { $errors[] = "Image exceeds 5MB limit."; $image_upload_error = true; }
        if (!$image_upload_error && empty($errors)) {
            $upload_dir = dirname(__DIR__) . '/Images/artworks/';
            if (!is_dir($upload_dir)) { if (!mkdir($upload_dir, 0775, true)) { $errors[] = "Failed to create upload directory."; $image_upload_error = true; }}
            if (is_dir($upload_dir) && !is_writable($upload_dir)){ $errors[] = "Upload directory not writable."; $image_upload_error = true; }
            if (!$image_upload_error) {
                $safe_filename_base = preg_replace("/[^a-zA-Z0-9_-]/", "_", pathinfo($file_name, PATHINFO_FILENAME));
                $new_image_filename_to_save = $safe_filename_base . '_' . time() . '.' . $file_ext;
                $destination = $upload_dir . $new_image_filename_to_save;
                if (!move_uploaded_file($file_tmp_name, $destination)) {
                    $errors[] = "Failed to move uploaded image."; $new_image_filename_to_save = $current_image_filename; $image_upload_error = true;
                }
            }
        }
    } elseif (isset($_FILES['artwork_image']) && $_FILES['artwork_image']['error'] != UPLOAD_ERR_NO_FILE) {
        $errors[] = "Image upload error: " . $_FILES['artwork_image']['error'];
    } elseif ($action === 'add' && $_FILES['artwork_image']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors[] = "Artwork image is required.";
    }

    if (empty($errors)) {
        if (isset($_POST['add_artwork'])) {
            $query = "INSERT INTO artworks (Title, Description, Catagory, Price, Image, ArtistID, numberInStock, total_reviews, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 0, NOW())";
            $types = "sssdsii";
            $params = [$artwork_data['Title'], $artwork_data['Description'], $artwork_data['Catagory'], $artwork_data['Price'], $new_image_filename_to_save, $artistId, $artwork_data['numberInStock']];
            if ($db->insert($query, $params, $types)) {
                $_SESSION['success_message'] = "Artwork added!"; header("Location: ../View/artistprofile.php"); exit;
            } else {
                $errors[] = "DB Error: " . ($db->getLastError() ?? "Failed to add artwork.");
                if ($new_image_filename_to_save !== $current_image_filename && !empty($new_image_filename_to_save) && file_exists($upload_dir . $new_image_filename_to_save)) { unlink($upload_dir . $new_image_filename_to_save); }
            }
        } elseif (isset($_POST['update_artwork']) && $artworkId) {
            $query = "UPDATE artworks SET Title = ?, Description = ?, Catagory = ?, Price = ?, Image = ?, numberInStock = ? WHERE ArtworkID = ? AND ArtistID = ?";
            $types = "sssdsiii";
            $params = [$artwork_data['Title'], $artwork_data['Description'], $artwork_data['Catagory'], $artwork_data['Price'], $new_image_filename_to_save, $artwork_data['numberInStock'], $artworkId, $artistId];
            if ($db->update($query, $params, $types)) {
                if ($new_image_filename_to_save !== $current_image_filename && !empty($current_image_filename)) {
                    $old_image_path = $upload_dir . $current_image_filename; if (file_exists($old_image_path)) { unlink($old_image_path); }
                }
                $_SESSION['success_message'] = "Artwork updated!"; header("Location: ../View/artistprofile.php"); exit;
            } else {
                $errors[] = "DB Error: " . ($db->getLastError() ?? "Failed to update artwork.");
                if ($image_upload_error === false && $new_image_filename_to_save !== $current_image_filename && file_exists($upload_dir . $new_image_filename_to_save)){ unlink($upload_dir . $new_image_filename_to_save); }
            }
        }
    }
}

if ($action === 'delete' && $artworkId && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $artwork_to_delete_result = $db->select("SELECT Image FROM artworks WHERE ArtworkID = ? AND ArtistID = ?", [$artworkId, $artistId], "ii");
    if ($artwork_to_delete_result && count($artwork_to_delete_result) > 0) {
        $image_to_delete_filename = $artwork_to_delete_result[0]['Image'];
        $query = "DELETE FROM artworks WHERE ArtworkID = ? AND ArtistID = ?"; $types = "ii";
        if ($db->delete($query, [$artworkId, $artistId], $types)) {
            if (!empty($image_to_delete_filename)) { $image_path_to_delete = dirname(__DIR__) . '../Images/artworks/' . $image_to_delete_filename; if (file_exists($image_path_to_delete)) { unlink($image_path_to_delete); } }
            $_SESSION['success_message'] = "Artwork deleted!";
        } else { $_SESSION['error_message'] = "Failed to delete. " . ($db->getLastError() ?? ""); }
    } else { $_SESSION['error_message'] = "Artwork not found for deletion."; }
    header("Location: ../View/artistprofile.php"); exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($form_title); ?> - Art Web</title>
    <link href="../view/css/bootstrap.min.css" rel="stylesheet">
    <link href="../view/css/font-awesome.min.css" rel="stylesheet"> <!-- If you use icons on buttons -->
    <link href="../view/css/global.css" rel="stylesheet"> <!-- Your main stylesheet -->
    <!-- You can add a manage_artwork.css for specific styles or use global.css -->
    <style>
        .form-container {
            background-color: #1c261f;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-preview-image {
            max-width: 150px; /* Smaller preview */
            max-height: 150px;
            margin-top: 10px;
            border: 1px solid #ced4da;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php
        // Adjust path to header.php as per your file structure
        // Assuming manage_artwork.php is in View/ and includes/ is also in View/
        $headerPath = __DIR__ . '../includes/header.php';
        if (file_exists($headerPath)) {
            include $headerPath;
        } else {
            echo "<!-- Header not found at: " . htmlspecialchars($headerPath) . " -->";
        }
    ?>

    <div class="container mt-4 mb-4"> <!-- Added margin top and bottom -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="form-container"> <!-- Using custom class for simple container -->
                    <h2 class="text-center mb-4"><?php echo htmlspecialchars($form_title); ?></h2>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">Errors Found:</h5>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error_item): ?>
                                    <li><?php echo htmlspecialchars($error_item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="manage_artwork.php?action=<?php echo htmlspecialchars($action); ?><?php echo $artworkId ? '&id='.htmlspecialchars($artworkId) : ''; ?>" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($artwork_data['Title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($artwork_data['Description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($artwork_data['Catagory']); ?>" required>
                            <div class="form-text">E.g., Painting, Sculpture, Digital Art, Photography</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($artwork_data['Price']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numberInStock" class="form-label">Number in Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="numberInStock" name="numberInStock" min="0" value="<?php echo htmlspecialchars($artwork_data['numberInStock']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="artwork_image" class="form-label">Artwork Image <?php echo ($action === 'add' ? '<span class="text-danger">*</span>' : '(Leave blank to keep current)'); ?></label>
                            <input type="file" class="form-control" id="artwork_image" name="artwork_image" accept="image/jpeg,image/png,image/gif">
                            <?php if ($action === 'edit' && !empty($current_image_filename)): ?>
                                <div class="mt-2">
                                    <p class="small text-muted mb-1">Current Image:</p>
                                    <img src="../Images/artworks/<?php echo htmlspecialchars($current_image_filename); ?>" alt="Current Artwork Image" class="form-preview-image img-thumbnail">
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex justify-content-end">
                             <a href="../View/artistprofile.php" class="btn btn-secondary me-2">
                                <i class="fa fa-times"></i> Cancel
                             </a>
                            <button type="submit" name="<?php echo htmlspecialchars($submit_button_name); ?>" class="btn <?php echo ($action === 'edit' ? 'btn-primary' : 'btn-success'); ?>">
                                <i class="fa <?php echo ($action === 'edit' ? 'fa-save' : 'fa-plus'); ?>"></i> <?php echo htmlspecialchars($submit_button_text); ?>
                            </button>
                        </div>
                    </form>
                </div> <!-- end .form-container -->
            </div>
        </div>
    </div>

    <?php
        // Adjust path to footer.php as per your file structure
        $footerPath = __DIR__ . '../includes/footer.php';
        if (file_exists($footerPath)) {
            include $footerPath;
        } else {
            echo "<!-- Footer not found at: " . htmlspecialchars($footerPath) . " -->";
        }
    ?>
    <script src="../View/js/bootstrap.bundle.min.js"></script>
</body>
</html>