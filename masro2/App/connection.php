<?php
$Servername="localhost";
$USername="root";
$Password="";
$DBname="artgallery";
$con;

try{
    return $con = mysqli_connect($Servername,$USername,$Password,$DBname);
}catch(mysqli_sql_exception $e){
    echo "Connection failed";
}

