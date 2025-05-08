<?php
require_once '../App/connection.php';
session_start();
if (!isset($_SESSION['userId']) && !isset($_COOKIE['userid']))
{
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Retrieve the rating and product ID from the form data
    $userRate = $_POST['rating'];
    $productId = $_POST['product_id'];
    $userId= $_POST['user_id'];

    $checkDuplicate=mysqli_query($con,"SELECT * from ProductUserRating where product_id=$productId and user_id=$userId");
    if($checkDuplicate){
        $_SESSION['Duplicate_rating_error']="Can't rate product Mulitple times";
        header("Location:ProductPreview.php?product_id=$productId");
        exit();
    }
    mysqli_query($con, "UPDATE artworks
    SET total_reviews = total_reviews + 1
    WHERE ArtworkID = $productId;");
    $sql = "INSERT INTO ProductUserRating (product_id, user_id, rate)
            VALUES ($productId, $userId, $userRate)";
    $result = mysqli_query($con, $sql);
    // Check if the update was successful
    header("Location:ProductPreview.php?product_id=$productId");
}
