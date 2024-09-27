<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you're fetching email and password from AJAX request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Replace this with your actual authentication logic (e.g., database check)
    if ($email == 'admin@gmail.com' && $password == 'password') {
        // Login successful, set session variables
        $_SESSION['user_email'] = $email;  // Set the session variable for user
        $_SESSION['logged_in'] = true; // Additional flag for login status
        
        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        // Login failed, return error message
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
}
?>
