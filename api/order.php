<?php
header('Content-Type: application/json');

session_start();
$user_id = $_SESSION["id"];
if (!isset($user_id)) {
    echo json_encode(['success' => false, 'message' => 'Error request method']);
    exit;
}

require(__DIR__ . '/database.php');


$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    $stmt = $pdo->prepare("SELECT orders.product_id AS id, orders.quantity, orders.total_price AS price, products.name FROM orders INNER JOIN products ON orders.product_id = products.id WHERE orders.user_id = ?");
    $stmt->execute([$user_id]);
    $data = $stmt->fetchAll();
    echo json_encode(($data));
    exit;
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $product_id = $data['id'] ?? 0;

    if ($user_id <= 0 || $product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM `orders` WHERE user_id = ? AND product_id = ? AND status = 'pending'");
    $stmt->execute([$user_id, $product_id]);
    echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
    exit;
}
//pang delete if pinindot ni user ung X sa cart ^
if ($method === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);
    $product_id = (int)($data['id'] ?? 0);
    $quantity   = (int)($data['quantity'] ?? 0);
    $size = $data["size"] ?? null;

    //- (quantity) +

    if ($product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT price, stock FROM products WHERE id = ?"); //connected to products
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product does not exist']);
        exit;
    }

    if ($quantity > $product['stock']) {
        echo json_encode([
            'success' => false,
            'message' => "Insufficient stock. Only {$product['stock']} available."
        ]);
        exit;
    }

    $total_price = $product['price'] * $quantity;

    $stmt = $pdo->prepare("SELECT id, quantity, total_price FROM `orders` WHERE user_id = ? AND product_id = ? AND status = 'pending'");
    $stmt->execute([$user_id, $product_id]);
    $existingOrder = $stmt->fetch();
    //pang update
    if ($existingOrder) {

        if (($quantity + $existingOrder['quantity']) <= 0) {
            $stmt = $pdo->prepare("DELETE FROM `orders` WHERE user_id = ? AND product_id = ? AND status = 'pending'");
            $stmt->execute([$user_id, $product_id]);
            echo json_encode(['success' => true, 'message' => ['quantity' => 0]]);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE `orders` SET quantity = ?, total_price = ? WHERE id = ?");
        $stmt->execute([$quantity + $existingOrder['quantity'], $total_price + $existingOrder['total_price'], $existingOrder['id']]);

        $stmt = $pdo->prepare("SELECT id, quantity, total_price AS price FROM `orders` WHERE user_id = ? AND product_id = ? AND status = 'pending'");
        $stmt->execute([$user_id, $product_id]);
        $new_data = $stmt->fetch();

        echo json_encode(['success' => true, 'message' => $new_data]);
    } else {
        if (empty($size)) {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO `orders` (user_id, product_id, quantity, total_price, size, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $product_id, $quantity, $total_price, $size]);
        echo json_encode(['success' => true, 'message' => 'Added successfully']);
    }
    exit;
}
