<?php

$db2host = "localhost";
$db2name = "artgallery";
$db2username = "root";
$db2password = "";

$mysqli = new mysqli($db2host, $db2username, $db2password, $db2name);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
// $mysqli->close();
// ?>


