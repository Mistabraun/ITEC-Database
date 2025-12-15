<?php

if($_SERVER['REQUEST_METHOD'] !== "POST"){
    echo "Invalid request type";
    return;
}


$json_data = file_get_contents("php://input");
$data = json_decode($json_data);

$email = $data->{"email"};
$password = $data->{'password'};


if ((strlen($email) <= 0)  || (strlen($password) <= 0 )){
    echo "Invalid arguments";
    return;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email";
    return;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$connection = require("database.php");
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";

$result = $connection -> query($sql);

echo $password;

if ($result->num_rows <= 0){
    echo "User does not exist.";
    return;
}

print_r($result);