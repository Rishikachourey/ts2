<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
    <form id="productForm">
        <h2>Add Product</h2>
        <label>Product Name:</label><br>
        <input type="text" name="name" required><br>
        <label>Product Price:</label><br>
        <input type="number" name="price" required><br>
        <label>Product Image:</label><br>
        <input type="file" name="image" required><br>
        <label>Product SKU:</label><br>
        <input type="text" name="sku" required><br>
        <label>Product Description:</label><br>
        <textarea name="description" required></textarea><br>
        <label>Product Category:</label><br>
        <input type="text" name="category" required><br>
        <input type="submit" value="Add Product">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#productForm').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            formData.append('user_id', <?php echo $_SESSION['user_id']; ?>);
            $.ajax({
                url: 'ajax/product_add_handler.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    if(response === 'Product added successfully') {
                        window.location.href = 'shop.php';
                    }
                }
            });
        });
    </script>
</body>
</html>
