<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request type']);
    return;
}

session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    return;
}

session_unset();

echo json_encode(['success' => true, 'message' => 'Success']);
