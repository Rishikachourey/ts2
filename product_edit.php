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

$product->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$product->user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->bindParam(1, $product->id);
$stmt->bindParam(2, $product->user_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
    <form id="editProductForm">
        <h2>Edit Product</h2>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Product Name:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>
        <label>Product Price:</label><br>
        <input type="number" name="price" value="<?php echo $row['price']; ?>" required><br>
        <label>Product Image:</label><br>
        <input type="file" name="image"><br>
        <label>Product SKU:</label><br>
        <input type="text" name="sku" value="<?php echo $row['sku']; ?>" required><br>
        <label>Product Description:</label><br>
        <textarea name="description" required><?php echo $row['description']; ?></textarea><br>
        <label>Product Category:</label><br>
        <input type="text" name="category" value="<?php echo $row['category']; ?>" required><br>
        <input type="submit" value="Update Product">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#editProductForm').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            formData.append('user_id', <?php echo $_SESSION['user_id']; ?>);
            $.ajax({
                url: 'ajax/product_edit_handler.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    if(response === 'Product updated successfully') {
                        window.location.href = 'shop.php';
                    }
                }
            });
        });
    </script>
</body>
</html>
