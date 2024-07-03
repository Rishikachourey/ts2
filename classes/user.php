<?php
class User {
    private $conn;
    private $table_name = "user";

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $address;
    public $profile_photo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " SET first_name=:first_name, last_name=:last_name, email=:email, password=:password, phone_number=:phone_number, address=:address, profile_photo=:profile_photo";
        $stmt = $this->conn->prepare($query);

        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->profile_photo = htmlspecialchars(strip_tags($this->profile_photo));

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":profile_photo", $this->profile_photo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // public function login() {
    //     $query = "SELECT id, first_name, last_name, email, password FROM " . $this->table_name . " WHERE email = :email";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(":email", $this->email);
    //     $stmt->execute();

    //     $num = $stmt->rowCount();

    //     if ($num > 0) {
    //         $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //         $this->id = $row['id'];
    //         $this->first_name = $row['first_name'];
    //         $this->last_name = $row['last_name'];
    //         $this->password = $row['password'];

    //         if (password_verify($this->password, $row['password'])) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // public function login($password) {
    //     $query = "SELECT id, first_name, last_name, email, password FROM " . $this->table_name . " WHERE email = :email";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(":email", $this->email);
    //     $stmt->execute();
    
    //     $num = $stmt->rowCount();
    
    //     if ($num > 0) {
    //         $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //         $this->id = $row['id'];
    //         $this->first_name = $row['first_name'];
    //         $this->last_name = $row['last_name'];
    //         $hashed_password = $row['password'];
    
    //         if (password_verify($password, $hashed_password)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
 // Method to authenticate user
//  public function authenticateUser($email, $password) {
//     $email = $this->conn->real_escape_string($email);
//     $password = $this->conn->real_escape_string($password);
    
//           $query = "SELECT id, first_name, last_name, email, password FROM " . $this->table_name . " WHERE email = :email";
   
//     // $sql = "SELECT id FROM user WHERE email = '$email' AND password = '$password'";
//      $result = $this->conn->query($query);

//     if ($result->num_rows == 1) {
//         $row = $result->fetch_assoc();
//         return $row['id'];
//     } else {
//         return false;
//     }
// }

    public function login($password) {
        
        $query = "SELECT id, first_name, last_name, email, password FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $hashed_password = $row['password'];
    
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $row['id'];
                return $row['id'];
            }
        }
        return false;
    }
    
}
?>
