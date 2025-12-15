<!-- Formats the old version to new version -->

<?php

$products_json_path = "json/products.json";
$products_json = json_decode(file_get_contents($products_json_path), true);

$new = [
    "accessories" => [],
    "bottoms" => [],
    "footwear" => [],
    "jackets" => [],
    "swimwear" => [],
    "tops" => []
];

foreach ($products_json as $gender => $gValue) {
    foreach ($gValue as $index => $item) {
        $type = strtolower($item['type']);
        $new[$type][] = $item;
    }
}

echo json_encode($new);

// print_r($products_json);
