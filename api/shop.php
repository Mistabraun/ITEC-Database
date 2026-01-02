<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    return;
}

$category = $_GET["category"] ?? '';
$stock = $_GET["stock"] ?? true;
$gender = $_GET["gender"] ?? null;
$minimum = $_GET["minimum"] ?? null;
$maximum = $_GET["maximum"] ?? null;
$sizes = $_GET["size"] ?? ["Extra Small", "Small", "Medium", "Large"];

if (empty($category)) {
    echo json_encode([]);
    exit();
}


require(__DIR__ . '/database.php');
$sql = "SELECT * FROM products WHERE category = ?";
$params[] = $category;

if (!empty($stock)) {
    if ($stock == "true") {
        $sql .= " AND stock > 0";
    } elseif ($stock == "false") {
        $sql .= " AND stock <= 0";
    }
}

if (!empty($gender) && ($gender == "Men" || $gender == "Women")) {
    $sql .= " AND gender = ?";
    $params[] = $gender;
}

if (!empty($minimum) && !empty($maximum)) {
    $sql .= " AND price BETWEEN ? AND ?";
    $params[] = $minimum;
    $params[] = $maximum;
} else if (!empty($minimum)) {
    $sql .= " AND price >= ?";
    $params[] = $minimum;
} else if (!empty($maximum)) {
    $sql .= " AND price <= ?";
    $params[] = $minimum;
}

if (!empty($sizes)) {
    $sql .= " AND JSON_CONTAINS(sizes, " . "'\"" . implode("\",\"", $sizes) . "\"'" . ")";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll();
echo json_encode($data);
