<?php
session_start();
require_once '../db/db.php'; // PDO connection

// Sanitize the inputs
$customer_id = filter_input(INPUT_GET, 'customer_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
$edit = ($operation == 'edit');

// Handle update request. As the form's action attribute is set to the same script, but with 'POST' method.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get customer id from query string parameter.
    $customer_id = filter_input(INPUT_GET, 'customer_id', FILTER_SANITIZE_NUMBER_INT);

    // Get input data
    $data_to_update = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $data_to_update['updated_at'] = date('Y-m-d H:i:s');

    // Prepare query for updating customer in the database
    $query = "UPDATE customers SET 
                full_name = :full_name,
                email = :email,
                phone = :phone,
                pan_no = :pan_no,
                aadhar_no = :aadhar_no,
                dob = :dob,
                gender = :gender,
                insurance_type = :insurance_type,
                policy_number = :policy_number,
                coverage_amount = :coverage_amount,
                premium_amount = :premium_amount,
                policy_start_date = :policy_start_date,
                policy_end_date = :policy_end_date,
                updated_at = :updated_at
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':full_name', $data_to_update['full_name']);
    $stmt->bindParam(':email', $data_to_update['email']);
    $stmt->bindParam(':phone', $data_to_update['phone']);
    $stmt->bindParam(':pan_no', $data_to_update['pan_no']);
    $stmt->bindParam(':aadhar_no', $data_to_update['aadhar_no']);
    $stmt->bindParam(':dob', $data_to_update['dob']);
    $stmt->bindParam(':gender', $data_to_update['gender']);
    $stmt->bindParam(':insurance_type', $data_to_update['insurance_type']);
    $stmt->bindParam(':policy_number', $data_to_update['policy_number']);
    $stmt->bindParam(':coverage_amount', $data_to_update['coverage_amount']);
    $stmt->bindParam(':premium_amount', $data_to_update['premium_amount']);
    $stmt->bindParam(':policy_start_date', $data_to_update['policy_start_date']);
    $stmt->bindParam(':policy_end_date', $data_to_update['policy_end_date']);
    $stmt->bindParam(':updated_at', $data_to_update['updated_at']);
    $stmt->bindParam(':id', $customer_id);

    $stat = $stmt->execute();

    if ($stat) {
        $_SESSION['success'] = "Customer updated successfully!";
        // Redirect to the listing page
        header('Location: customers.php');
        exit(); // Important! Stop further execution
    }
}

// If edit is true, fetch the customer data to pre-populate the form
if ($edit) {
    $query = "SELECT * FROM customers WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $customer_id);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php include_once 'includes/header.php'; ?>

<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Customer</h2>
    </div>
    <!-- Flash messages -->
    <?php include('./includes/flash_messages.php'); ?>

    <form action="" method="post" enctype="multipart/form-data" id="contact_form">
        <?php require_once('./forms/customer_form.php'); // Common form for add and edit ?>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>
