<?php

session_start();

$email = $_SESSION['email'];

if(!isset($email)){
    return;
}

$connection = require('database.php');

$sql = "SELECT orders.user_id, orders.product_id, orders.quantity, users.email" . 
" FROM orders INNER JOIN users" .
" ON orders.user_id = users.id". 
" WHERE email = '" . $email . "'";

$result = $connection -> query($sql);

echo json_encode($result->fetch_assoc());