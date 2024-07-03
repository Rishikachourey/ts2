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
$product->user_id = $_SESSION['user_id'];

if($product->deleteProduct()) {
    echo "Product deleted successfully";
} else {
    echo "Unable to delete product";
}
?>
