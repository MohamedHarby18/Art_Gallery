<?php
//     require_once '../mail.php';

// $mail->setFrom('from@gmail.com', 'Admin');
// $mail->addAddress('bassilhamdi410@gmail.com'); 
// $mail->Subject = 'test mail';
// $mail->Body= 'This is the HTML message body <b>in bold!</b>';
// $mail->send();

require_once 'Admin.php';
require_once 'connection.php';

if(isset($_POST['refer'])){
    session_start();
    if(!isset($_SESSION['userId']) && !isset($_COOKIE['userid'])){
        $_SESSION['refermsg'] = 'You have to be logged in first';
        header('Location: ../index.php#ref');
        exit();
    }else{
    try{
    $email = $_POST['emailrefer'];
    $userid = isset($_SESSION['userId'])? $_SESSION['userId'] :$_COOKIE['userid'];
    $subject = 'Referal';
    $body = 'You have been refered by  to join our  <a href="http://localhost/art_gallery/index.php">Website</a>';
    Admin::sendEmial($email, $subject, $body);
    $sql = "INSERT INTO referrals(UserID,ReferredUserEmail) VALUES('$userid','$email')";
    mysqli_query($con,$sql);
    $_SESSION['refermsg'] = 'Refered successfully';
    header('Location: ../index.php#ref');
    exit();
    }catch(Exception $ex){
        $_SESSION['refermsg'] = $ex->getMessage();
    }
    }
}