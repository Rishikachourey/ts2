<?php
class ProductProcessor {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $price;
    public $image;
    public $sku;
    public $description;
    public $category;
    public $user_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addProduct() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET name = :name, price = :price, image = :image, sku = :sku, description = :description, category = :category, user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':user_id', $this->user_id);

        // Debugging
        var_dump($this->user_id); // Check if user_id is set correctly

        if ($stmt->execute()) {
            return true;
        } else {
            // Add detailed error information
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function getProductsByUser() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    public function updateProduct() {
        $query = "UPDATE " . $this->table_name . "
                  SET name = :name, price = :price, image = :image, sku = :sku, description = :description, category = :category
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);

        // Debugging
        var_dump($this->user_id); // Check if user_id is set correctly

        if ($stmt->execute()) {
            return true;
        } else {
            // Add detailed error information
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function deleteProduct() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);

        // Debugging
        var_dump($this->user_id); // Check if user_id is set correctly

        if ($stmt->execute()) {
            return true;
        } else {
            // Add detailed error information
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    public function getProductsByCategory($category) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
