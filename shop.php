<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once 'includes/database.php';
include_once 'classes/product_processor.php';

$database = new Database();
$db = $database->getConnection();
$product = new ProductProcessor($db);
$product->user_id = $_SESSION['user_id'];
$products = $product->getProductsByUser();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
    <h2>Your Products</h2>
    <a href="product.php">Add New Product</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>SKU</th>
            <th>Description</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = $products->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            echo "<tr>";
            echo "<td>{$name}</td>";
            echo "<td>{$price}</td>";
            echo "<td><img src='{$image}' width='50'></td>";
            echo "<td>{$sku}</td>";
            echo "<td>{$description}</td>";
            echo "<td>{$category}</td>";
            echo "<td>";
            echo "<a href='product_edit.php?id={$id}'>Edit</a>";
            echo "<a href='#' class='delete-product' data-id='{$id}'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.delete-product').on('click', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'ajax/product_delete_handler.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    alert(response);
                    if(response === 'Product deleted successfully') {
                        window.location.reload();
                    }
                }
            });
        });
    </script>
</body>
</html>
