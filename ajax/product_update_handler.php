<?php
require_once '../includes/database.php';
require_once '../classes/product_processor.php';

$database = new Database();
$db = $database->getConnection();

$productProcessor = new ProductProcessor($db);

$targetDir = "../assets/images/";
$image = isset($_FILES["image"]) ? basename($_FILES["image"]["name"]) : null;

if ($image) {
    $targetFile = $targetDir . $image;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        echo "File is not an image.";
        exit;
    }
} else {
    $product = $productProcessor->readOne($_POST['id']);
    $image = $product['image'];
}

$data = [
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'image' => $image,
    'sku' => $_POST['sku'],
    'description' => $_POST['description'],
    'category' => $_POST['category']
];

if($productProcessor->update($data)) {
    echo "Product successfully updated";
} else {
    echo "Error updating product";
}
?>
