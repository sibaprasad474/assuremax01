<?php
session_start();
require_once '../db/db.php'; // Assuming your db.php file contains the PDO connection

// Check if it's a POST request and the ID is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $customer_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($customer_id) {
        // Use the existing PDO connection ($conn) to delete the customer
        $query = "DELETE FROM customers WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Send JSON response indicating success
            echo json_encode(['success' => true]);
        } else {
            // Send JSON response indicating failure
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid customer ID']);
    }
    exit();
}
