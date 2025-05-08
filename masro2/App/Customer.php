<?php

// declare (restrict_type=1);
namespace App;
use App\User;

class Customer extends User{
    public function __construct(){

    }
    public function setAll($Fname,$Lname,$email,$password,$phone,$address,$city,$gender){
        parent::__construct($Fname,$Lname,$email,$password,$phone,$address,$city,$gender);
    }
}
