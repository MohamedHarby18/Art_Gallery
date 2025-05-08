<?php
session_start();
require_once '../App/connection.php';

if (!isset($_SESSION['userId'])&& !isset($_COOKIE['userid'])) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

// Check if the product ID is provided and it exists
if(isset($_GET['product_id']) && !empty($_GET['product_id'])) {

    // Get productID 
    $productId = filter_var($_GET['product_id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Get values form GET and SESSION
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1; // Default quantity is 1
    $userId = $_SESSION['userId']; // Get user ID from the session

    
    // Get number in stock of product 
    $result= mysqli_query($con,"SELECT numberInStock from artworks where ArtworkID=$productId");
    $row=mysqli_fetch_assoc($result);
    $numberinstock=$row['numberInStock'];
    $error;
    if($quantity>$numberinstock){
        $_SESSION['quantity_error']="quantity exceeds number in stock of this product";
        header("Location:ProductPreview.php?product_id=$productId");
        exit();
    }else{
        mysqli_query($con,"UPDATE artworks set numberInStock=numberInStock-$quantity");
        mysqli_query($con,"INSERT INTO shoppingcart(userId,ItemID,quantity) VALUES('$userId', '$productId','$quantity')");
        header("Location:ProductPreview.php?product_id=$productId");
        exit();
    }

} else {
    // Redirect to the products page or display an error message
    header("Location: products.php");
    exit(); // Stop further execution
}
?>
