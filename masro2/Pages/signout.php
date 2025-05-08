<?php

require_once '../App/Authcontoller.php';
session_start();


$_SESSION = [];

Authcontoller::unSetCookies();

session_destroy();


header("Location: ../index.php");
exit(); 
