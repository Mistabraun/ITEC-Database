<?php

$hostName = "localhost";
$name = "root";
$password = "";
$databaseName = "storedb";

$connection = new mysqli(
    $hostName,
    $name,
    $password,
    $databaseName
);

if ($connection->connect_errno){
    die("Connection error");
    return;
}

return $connection;