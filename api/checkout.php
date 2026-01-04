<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    return;
}

session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    return;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$fname = $data["fname"] ?? '';
$contact = $data["contact"] ?? '';
$payment = $data["payment"] ?? '';
$address = $data["address"] ?? '';
$orders = $data["orders"] ?? [];

if (empty($fname) || empty($contact) || empty($payment) || empty($address) || empty($orders)) {
    echo json_encode(["success" => false, "message" => "Invalid arguments"]);
    exit;
}

$user_id = $_SESSION["id"];

require(__DIR__ . '/database.php');

$params = implode(',', array_fill(0, count($orders), '?'));

$stmt = $pdo->prepare("
    UPDATE orders 
    SET status = 'completed' 
    WHERE user_id = ? 
    AND product_id IN ($params)
");

$stmt->execute(array_merge([$user_id], $orders));

$stmt = $pdo->prepare("
    SELECT * FROM orders
    WHERE user_id = ? 
    AND product_id IN ($params)
");

$stmt->execute(array_merge([$user_id], $orders));
$new_data = $stmt->fetchAll();

foreach ($new_data as $data) {
    $stmt = $pdo->prepare("INSERT INTO history VALUES ('', ?, ?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$user_id, $data["product_id"], $data["id"], $fname, $contact, $address, $payment]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Duplicated entry"]);
        exit;
    }
}



echo json_encode(["success" => true, "message" => $data]);
