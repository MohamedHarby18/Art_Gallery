<?php

// declare (restrict_type=1);
namespace App;

use App\User;


class Artist extends User
{
    public function __construct(){
       
    }

    public static function getName($ID)
    {
        $con = include_once('App/connection.php');
        $sql=" select Fname from users where Artist=1 and UserID={$ID}";
        $result="";
        // in validation dispaly artist if name not empty
        
        $result=$con->query($sql);
        return $result;
    }
}