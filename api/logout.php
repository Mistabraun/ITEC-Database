<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST"){
    echo "Invalid request type";
    return;
}

if (!isset($_SESSION['email'])){
    echo "Not logged in";
    return;
}

session_unset();

echo "200";