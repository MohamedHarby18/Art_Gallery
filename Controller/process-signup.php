<?php

if (empty($_POST["fname"]) || empty($_POST["lname"])) {
    die("First and Last names are required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}
if (empty($_POST["City"]) || empty($_POST["Address"])) {
    die("City and Address are required");
 
}
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

//check if artist and advisor are set, if not set them to 0
$artist = empty($_POST["artist"]) ? 0 : (int)$_POST["artist"];
$advisor = empty($_POST["advisor"]) ? 0 : (int)$_POST["advisor"];



require_once __DIR__ . '/../Controller/controlDBauth.php';






// Check if email already exists
session_start();
$email = $_POST["email"];
$sql_check_email = "SELECT COUNT(*) FROM users WHERE Email = ?";

$stmt_check_email = $mysqli->stmt_init();

if (!$stmt_check_email->prepare($sql_check_email)) {
    die("SQL error bro: " . $mysqli->error);
}

$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();


require_once __DIR__ . '/../Controller/controlDBauth.php';

header("Content-Type: text/plain");

// Basic validation
if (empty($_POST["fname"]) || empty($_POST["lname"])) {
    echo "ERROR:First and Last names are required";
    exit;
}

if (empty($_POST["phone"])) {
    echo "ERROR:Phone number is required";
    exit;
}
if (!preg_match("/^[0-9]+$/", $_POST["phone"])) {
        echo "Error: Phone number should contain only numbers.";
        exit;
}
if (!preg_match("/^[0-9]{10}$/", $_POST["phone"])) {
    echo "ERROR:Phone number must be 10 digits of numbers";
    exit;
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "ERROR:Valid email is required";
    exit;
}

if (strlen($_POST["password"]) < 8) {
    echo "ERROR:Password must be at least 8 characters";
    exit;
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    echo "ERROR:Password must contain at least one letter";
    exit;
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    echo "ERROR:Password must contain at least one number";
    exit;
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    echo "ERROR:Passwords must match";
    exit;
}

if (empty($_POST["City"]) || empty($_POST["Address"])) {
    echo "ERROR:City and Address are required";
    exit;
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Check if artist and advisor are set
$artist = empty($_POST["artist"]) ? 0 : (int)$_POST["artist"];
$advisor = empty($_POST["advisor"]) ? 0 : (int)$_POST["advisor"];

// Check if email already exists
$email = $_POST["email"];
$sql_check_email = "SELECT COUNT(*) FROM users WHERE Email = ?";
$stmt_check_email = $mysqli->stmt_init();

if (!$stmt_check_email->prepare($sql_check_email)) {
    echo "ERROR:SQL error: " . $mysqli->error;
    exit;
}

$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$stmt_check_email->bind_result($email_count);
$stmt_check_email->fetch();


// Free the result after fetching
$stmt_check_email->free_result();



if ($email_count > 0) {
    echo "ERROR:Email is already taken. Please use a different one.";
    exit;
}

// Insert new user
$sql = "INSERT INTO users (Fname, Lname, phoneNumber, Email, Address, Artist, Advisor, Password, City)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    echo "ERROR:SQL error: " . $mysqli->error;
    exit;
}

$stmt->bind_param(
    "sssssiiss",
    $_POST["fname"],
    $_POST["lname"],
    $_POST["phone"],
    $_POST["email"],
    $_POST["Address"],
    $artist,
    $advisor,
    $password_hash,
    $_POST["City"]
);

if ($stmt->execute()) {
    echo "SUCCESS";
    exit;
} else {
    echo "ERROR:" . $mysqli->error;
    exit;
}

$stmt_check_email->bind_result($email_count);
$stmt_check_email->fetch();

if ($email_count > 0) {
    echo "ERROR:Email is already taken. Please use a different one.";
    exit;
}



// Prepare and execute the SQL statement to insert the new user
$sql = "INSERT INTO users (Fname, Lname, phoneNumber, Email, Address, Artist, Advisor, Password, City)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sssssiiss",
    $_POST["fname"],
    $_POST["lname"],
    $_POST["phone"],
    $_POST["email"],
    $_POST["Address"],
    $artist,
    $advisor,
    $password_hash,
    $_POST["City"]
);

if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
