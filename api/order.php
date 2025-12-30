<?php
header('Content-Type: application/json');
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "storedb"; //naka connect sa orderdb db

try {
    $pdo = new PDO(
        "mysql:host=$db_host; dbname=$db_name; charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $user_id = (int)($data['user_id'] ?? 0);
    $product_id = (int)($data['product_id'] ?? 0);

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
    $user_id    = (int)($_POST['user_id'] ?? 0);
    $product_id = (int)($_POST['product_id'] ?? 0);
    $quantity   = (int)($_POST['quantity'] ?? 1);
    //- (quantity) +
    if ($user_id <= 0 || $product_id <= 0 || $quantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT price, stock FROM products.products WHERE id = ?"); //connected to products
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

    $stmt = $pdo->prepare("SELECT id FROM `orders` WHERE user_id = ? AND product_id = ? AND status = 'pending'");
    $stmt->execute([$user_id, $product_id]);
    $existingOrder = $stmt->fetch();
    //pang update
    if ($existingOrder) {
        $stmt = $pdo->prepare("UPDATE `orders` SET quantity = ?, total_price = ? WHERE id = ?");
        $stmt->execute([$quantity, $total_price, $existingOrder['id']]);
        echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
    } else {
        $stmt = $pdo->prepare("INSERT INTO `orders` (user_id, product_id, quantity, total_price, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $product_id, $quantity, $total_price]);
        echo json_encode(['success' => true, 'message' => 'Added successfully']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Error request method']);
