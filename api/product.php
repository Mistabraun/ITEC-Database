<?php

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    return;
}

$id = $_GET["id"] ?? '';

if (empty($id)) {
    echo json_encode(["success" => false, "message" => "Invalid arguments"]);
    exit;
}

require(__DIR__ . '/database.php');

$stmt = $pdo->prepare("SELECT id, name, price, gender, category, sold, stock, sizes, images FROM products WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    echo json_encode([]);
    exit();
}

echo json_encode(["success" => true, "message" => $data]);
