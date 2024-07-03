<?php
include_once '../includes/database.php';
include_once '../classes/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->first_name = $_POST['first_name'];
$user->last_name = $_POST['last_name'];
$user->email = $_POST['email'];
$user->password = $_POST['password'];
$user->phone_number = $_POST['phone_number'];
$user->address = $_POST['address'];
$user->profile_photo = 'path/to/photo'; // Handle file upload and set this path

if ($user->register()) {
    echo "User successfully registered.";
} else {
    echo "Unable to register the user.";
}
?>
