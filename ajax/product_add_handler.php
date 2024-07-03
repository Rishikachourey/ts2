<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access";
    exit();
}

include_once '../includes/database.php';
include_once '../classes/product_processor.php';

$database = new Database();
$db = $database->getConnection();
$product = new ProductProcessor($db);

$product->name = $_POST['name'];
$product->price = $_POST['price'];
$product->image = 'uploads/' . basename($_FILES['image']['name']);
$product->sku = $_POST['sku'];
$product->description = $_POST['description'];
$product->category = $_POST['category'];
$product->user_id = $_SESSION['user_id']; // Correctly assign the user_id

if(move_uploaded_file($_FILES['image']['tmp_name'], '../' . $product->image)) {
    if($product->addProduct()) {
        echo "Product added successfully";
    } else {
        echo "Unable to add product";
    }
} else {
    echo "Image upload failed";
}
?>
