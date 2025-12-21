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
$sql = "SELECT password FROM users WHERE email = '$email'";

$result = $connection -> query($sql);

$fetched = $result->fetch_assoc();

if (!$fetched){;
    echo "Invalid credentials";
    return;
}

$hashed_password = $fetched['password'];

if (password_verify($password, $hashed_password)) {
    echo "200";
    session_start();

    $_SESSION['email'] = $email;
    
} else {
    echo "Invalid credentials";
    return;
}

return;