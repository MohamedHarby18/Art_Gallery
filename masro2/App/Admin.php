<?php
require_once 'User.php';
// declare(restrict_type=1);

use App\User;

class Admin extends User
{
    private static $instance;
    private function __construct()
    {

    }
    /// blocked artist who's deleted from our DB
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
           static::$instance = new Admin();
        }
        return static::$instance;
    }
    public static function isBlocked($ArtistID)
    {
        require_once 'App/connection.php';

        $sql = "SELECT Fname FROM `users` WHERE `UserID` = $ArtistID";
        try {
            $result = mysqli_query($con, $sql);
            if ($row = mysqli_fetch_assoc($result)) {
                return False;
            } else {
                return True;
            }
        } catch (mysqli_sql_exception $E) {
            return True;
        }


    }

    public static function Request($ArtistID, $ArtTitle, $ArtPrice)
    {
        if (
            Admin::isBlocked($ArtistID) == False && is_string($ArtTitle) && is_double($ArtPrice)
            && $ArtPrice <= doubleval(1000)
        ) {
            return True;
        } else {
            return False;
        }
    }

    public static function sendEmial($email, $subject, $body)
    {
        require_once 'mail.php';
        try {
            $mail->setFrom('from@gmail.com', 'Admin');
            
            $mail->Subject = "$subject";
            $mail->Body = "$body";
            $mail->send();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public static function Block($ArtistID)
    {
        require_once 'connection.php';
        $sql = "DELETE FROM `users` WHERE `UserID` = $ArtistID";
        try {
            mysqli_query($con, $sql);
        } catch (mysqli_sql_exception $E) {
            echo $E->getMessage();
        }
    }

    public static function generateReport(){
        require_once 'pdf.php';
        require_once 'connection.php';
        $events = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) FROM events"))[0];
        $Virtualgalleries = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) FROM virtualgalleries"))[0];
        $users = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) FROM users"))[0];
        $products = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) FROM artworks WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)"))[0];
        $purchases = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) FROM purchases WHERE Date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)"))[0];
        
        $html="
        <h1>Report</h1>
        <table border='1'>
          <tr><th>Events: </th><td>$events</td></tr>
            <tr><th>Virtual Galleries: </th><td>$Virtualgalleries</td></tr>
          <tr><th>Users: </th><td>$users</td></tr>
        <tr><th>Products Last month: </th><td>$products</td></tr>
        <tr><th>Purchases Last month: </th><td>$purchases</td></tr>
        </table>";
        $report = new \Mpdf\Mpdf();
        $report->WriteHTML($html);
        $report->Output('report.pdf','D'); 
        
    }
}