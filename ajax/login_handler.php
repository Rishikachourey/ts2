<?php
session_start();
require_once '../includes/database.php'; // Adjust path as per your project structure
require_once '../classes/User.php'; // Adjust path as per your project structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = []; // Initialize response array

    // Validate and sanitize input
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate user credentials
    $user = new User($conn); // Assuming $conn is your database connection object
    $userId = $user->login($password);

    if ($userId) {
        $_SESSION['user_id'] = $userId; // Store user id in session
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid email or password';
    }

    echo json_encode($response); // Send JSON response back to the AJAX request
}
?>
