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

$product->id = $_POST['id'];
$product->name = $_POST['name'];
$product->price = $_POST['price'];
$product->image = !empty($_FILES['image']['name']) ? 'uploads/' . basename($_FILES['image']['name']) : '';
$product->sku = $_POST['sku'];
$product->description = $_POST['description'];
$product->category = $_POST['category'];
$product->user_id = $_POST['user_id'];

if(!empty($product->image)) {
    move_uploaded_file($_FILES['image']['tmp_name'], '../' . $product->image);
}

if($product->updateProduct()) {
    echo "Product updated successfully";
} else {
    echo "Unable to update product";
}
?>
