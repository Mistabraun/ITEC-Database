<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo "Invalid request type";
    return;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$email = $data["email"] ?? '';
$password = $data["password"] ?? '';


if ((strlen($email) <= 0)  || (strlen($password) <= 0)) {
    echo json_encode(["success" => false, "message" => "Invalid arguments"]);
    return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email"]);
    return;
}


if (strlen($password) > 16) {
    echo json_encode(["success" => false, "message" => "Password is too Strong"]);
    return;
} else if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password is too Weak"]);
    return;
}

session_start();

if (isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    return;
}

require(__DIR__ . '/database.php');

$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$result = $stmt->rowCount();

if ($result > 0) {
    echo json_encode(["success" => false, "message" => "Email already taken"]);
    return;
}

$stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hashed_password]);
$id = $pdo->lastInsertId();

$_SESSION['email'] = $email;
$_SESSION['id'] = $id;

echo json_encode(["success" => true, "message" => "Success"]);
