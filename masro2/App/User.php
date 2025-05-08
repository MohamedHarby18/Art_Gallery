<?php

// declare(restrict_type=1);

namespace App;
abstract class User
{
    private string $SSNO;
    private string $Fname;
    private string $Lname;
    private string $email;
    private string $password;
    private string $phone;
    private string $address;
    private string $city;
    private $gender;
    

    
    public function __construct($Fname,$Lname,$email,$password,$phone,$address,$city,$gender) 
    {
        $this->Fname = $Fname;
        $this->Lname = $Lname;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->address = $address;
        $this->city = $city;
        $this->gender = $gender;
        $this->city = $city;
    }
   

    public function getFname(){
        return $this->Fname;
    }

    public function setFname($Fname){
        $this->Fname=$Fname;
    }

    public function getLname(){
        return $this->Lname;
    }

    public function setLname($Lname){
        $this->Lname= $Lname;
    }

    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($email){
        $this->email=$email;
    }

    public function getPass(){
        return $this->password;
    }

    public function setPass($password){
        $this->password=$password;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone($phone){
        $this->phone=$phone;
    }


    public function getAddress(){
        return $this->address;
    }

    public function setAddress($address){
        $this->address=$address;
    }

    public function setCity($city){
        $this->city=$city;
    }
    public function getCity(){
        return $this->city;
    }

    public function setGender($gender){
        $this->gender=$gender;
    }
    public function getGender(){
        return $this->gender;
    }
    public function getSsn(){
        return $this->SSNO;
    }
    public function setSsn($SSNO){
        $this->SSNO = $SSNO;
    }
}