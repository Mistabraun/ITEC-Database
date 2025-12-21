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

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "Not an email";
    return; 
}
if (strlen($password) > 16 ){
    echo "Password is too Strong";
    return;
}
else if (strlen($password) < 8 ){
    echo "Password is too Weak";
    return;
}


$connection = require("database.php");

if (!$connection){
    echo "Error";
    return;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users VALUES ('', '$email', '$hashed_password')";

try {
    $result = $connection -> query($sql);
    echo $connection->insert_id;
    session_start();
    $_SESSION['email'] = $email;
    echo "200";   
} catch (mysqli_sql_exception $e) {
    $status_code = $e->getCode();
    
    if ($status_code == 1062){
        echo "Email already registered";
        return;
    } else {
        echo "Error occurred";
        return;
    }
}    
