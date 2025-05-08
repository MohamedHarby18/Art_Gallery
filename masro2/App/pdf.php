<?php

session_start();
if((isset($_SESSION['Admin']) && $_SESSION['Admin']!=1 ) || !isset($_SESSION['Admin']))
{
    echo "You don't have access";
    // header("Location: ");
    exit();
}
require_once  '../vendor/autoload.php';
require_once 'Admin.php';

Admin::generateReport();