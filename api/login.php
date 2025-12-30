<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
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

session_start();

if (isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    return;
}

require(__DIR__ . '/database.php');

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user_data = $stmt->fetch();

if (!$user_data) {;
    echo json_encode(["success" => false, "message" => "Invalid credentials"]);
    return;
}

$hashed_password = $user_data['password'];

if (!password_verify($password, $hashed_password)) {
    echo json_encode(["success" => false, "message" => "Invalid credentials"]);
    return;
}

echo json_encode(["success" => true, "message" => "Successfully logged in."]);

$_SESSION['email'] = $user_data['email'];
$_SESSION['id'] = $user_data['id'];

return;
