<?php
require_once('../includes/database.php');
require_once('../classes/product_processor.php');

$category = $_POST['category'];

$productProcessor = new ProductProcessor();
$products = $productProcessor->getProductsByCategory($category);

foreach($products as $product) {
    echo '<li>' . htmlspecialchars($product['name']) . '<button class="addToCart" data-id="' . $product['id'] . '">Add to Cart</button></li>';
}
?>
