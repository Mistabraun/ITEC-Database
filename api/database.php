<?php

$hostName = "localhost";
$databaseName = "root";
$databasePassword = "";
$databaseDatababseName = "storedb";

$connection = new mysqli(
    $hostName,
    $databaseName,
    $databasePassword,
    $databaseDatababseName
);

if ($connection->connect_errno){
    die("Connection error");
    return;
}

return $connection;