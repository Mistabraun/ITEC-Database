<?php
// para lang di muna gumana, kapag na view yung web 
if (true) {
    return;
}


$mysqli = new mysqli("localhost", "root", "", "storedb"); //connected to products

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$jsonPath = __DIR__ . "/../json/products.json";

if (!file_exists($jsonPath)) {
    die("Error: JSON file not found at $jsonPath");
}

$json = file_get_contents($jsonPath);
$data = json_decode($json, true);

if ($data === null) {
    die("Error: Failed to decode JSON. Check syntax.");
}

$stmt = $mysqli->prepare("INSERT INTO products (name, price, gender, category, sold, stock, sizes, images, creation) VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}


foreach ($data as $genderName => $categories) {
    foreach ($categories as $categoryName => $products) {
        foreach ($products as $product) {

            $sizes  = json_encode($product['sizes']);
            $images = json_encode($product['images']);
            $stmt->bind_param(
                "sissiissi",
                $product['name'],
                $product['price'],
                $product['gender'],
                $product['type'],
                $product['sold'],
                $product['stock'],
                $sizes,
                $images,
                $product['creation']
            );

            echo $sizes . "/n";

            if (!$stmt->execute()) {
                echo "Error inserting " . $product['name'] . ": " . $stmt->error . "<br>";
            }
        }
    }
}

$stmt->close();
$mysqli->close();

echo "posa!";
