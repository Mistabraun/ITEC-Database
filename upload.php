<?php

function checkForError($file)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Upload error: " . $file['error'];
        return true;
    }
    return false;
}

function getDirectory($data, $file)
{
    return "assets/products" . "/" . strtolower($data["gender"]) . "/" . strtolower($data["type"]) . "/" . $file['name'];
}

function moveToProducts($data, $file)
{
    // $originalName = $file["name"];
    // $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
    $targetDirectory = getDirectory($data, $file);
    move_uploaded_file($file['tmp_name'], $targetDirectory);
    return $targetDirectory;
}

function randomTimestamp($start, $end)
{
    $startTimestamp = strtotime($start);
    $endTimestamp = strtotime($end);

    return mt_rand($startTimestamp, $endTimestamp);
}

function randomPrice($min, $max)
{
    // Calculate how many steps fit in the range
    $steps = range($min, $max, 200);

    // Pick a random step
    return $steps[array_rand($steps)];
}

function randomSizes()
{
    $sizes = ['Extra Small', 'Small', 'Medium', 'Large'];
    $randIndex = mt_rand(0, count($sizes) - 1);
    return array_slice($sizes, 0, $randIndex + 1);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST["name"];
    // $price = $_POST["price"];
    $gender = $_POST["gender"];
    $type = $_POST["type"];

    $display_image = $_FILES["display"];
    $hover_image = $_FILES["hover"];

    if (checkForError($display_image) || checkForError($hover_image)) {
        exit;
    }

    // Randomly generated yung ibang details para sa search.
    $data = [
        "name" => $name,
        "price" => randomPrice(1000, 3000),
        "gender" => $gender,
        "type" => $type,
        "sold" => random_int(1, 100),
        "stock" => random_int(0, 20),
        "sizes" => randomSizes(),
        "creation" => randomTimestamp('2025-01-01', date('Y-m-d'))
    ];

    // kung nag exist na yung file possible na meron na data.
    if (file_exists(getDirectory($data, $display_image))) {
        echo "Data already exists.";
        exit;
    }

    $images = [
        moveToProducts($data, $display_image),
        moveToProducts($data, $hover_image)
    ];

    $data["images"] = $images;


    $products_json_path = "json/products.json";
    $products_json = json_decode(file_get_contents($products_json_path), true);
    $products_json[$gender][strtolower($type)][] = $data;

    $new_data = json_encode($products_json, JSON_PRETTY_PRINT);

    file_put_contents($products_json_path, $new_data);
    echo "Data successfully uploaded.";
    // echo $new_data;
}
