<?php
require_once __DIR__ . "/DBController.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $db = new DBController();
    
    $userId = $_SESSION['user_id'];
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $city = $_POST['city'] ?? '';
    $address = $_POST['address'] ?? '';
    
    try {
        $result = $db->execute(
            "UPDATE users SET 
                Fname = ?,
                Lname = ?,
                phoneNumber = ?,
                City = ?,
                Address = ?
             WHERE UserID = ?",
            [$firstName, $lastName, $phoneNumber, $city, $address, $userId]
        );
        
        if ($result) {
            $_SESSION['success_message'] = 'Profile updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to update profile.';
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Error: ' . $e->getMessage();
    }
    
    header('Location: ../View/customer.php');
    exit();
} else {
    header('Location: ../View/customer.php');
    exit();
}