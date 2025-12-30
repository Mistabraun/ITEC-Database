<?php
header('Content-Type: application/json');

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "storedb";


try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error'
    ]);
    exit;
}


return $pdo;
