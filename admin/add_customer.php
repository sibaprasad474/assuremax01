<?php
session_start();
require_once '../db/db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON POST data or use POST if FormData is sent
    $data = [
        'full_name' => $_POST['full_name'] ?? null,
        'email' => $_POST['email'] ?? null,
        'phone' => $_POST['phone'] ?? null,
        'pan_no' => $_POST['pan_no'] ?? null,
        'aadhaar_no' => $_POST['aadhaar_no'] ?? null,
        'dob' => $_POST['dob'] ?? null,
        'gender' => $_POST['gender'] ?? null,
        'insurance_type' => $_POST['insurance_type'] ?? null,
        'policy_number' => $_POST['policy_number'] ?? null,
        'coverage_amount' => $_POST['coverage_amount'] ?? null,
        'premium_amount' => $_POST['premium_amount'] ?? null,
        'policy_start_date' => $_POST['policy_start_date'] ?? null,
        'policy_end_date' => $_POST['policy_end_date'] ?? null,
        'created_at' => date('Y-m-d H:i:s'),
    ];

    try {
        // Prepare the insert query
        $query = "INSERT INTO customers (full_name, email, phone, pan_no, aadhar_no, dob, gender, 
                  insurance_type, policy_number, coverage_amount, premium_amount, policy_start_date, 
                  policy_end_date, created_at) 
                  VALUES (:full_name, :email, :phone, :pan_no, :aadhar_no, :dob, :gender, 
                  :insurance_type, :policy_number, :coverage_amount, :premium_amount, 
                  :policy_start_date, :policy_end_date, :created_at)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':pan_no', $data['pan_no']);
        $stmt->bindParam(':aadhar_no', $data['aadhaar_no']);
        $stmt->bindParam(':dob', $data['dob']); // Bind DOB
        $stmt->bindParam(':gender', $data['gender']); // Bind Gender
        $stmt->bindParam(':insurance_type', $data['insurance_type']); // Bind Insurance Type
        $stmt->bindParam(':policy_number', $data['policy_number']); // Bind Policy Number
        $stmt->bindParam(':coverage_amount', $data['coverage_amount']); // Bind Coverage Amount
        $stmt->bindParam(':premium_amount', $data['premium_amount']); // Bind Premium Amount
        $stmt->bindParam(':policy_start_date', $data['policy_start_date']); // Bind Policy Start Date
        $stmt->bindParam(':policy_end_date', $data['policy_end_date']); // Bind Policy End Date
        $stmt->bindParam(':created_at', $data['created_at']);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Customer added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Insert failed: Could not execute the query.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Insert failed: ' . $e->getMessage()]);
    }
    exit();
}

$edit = false; // Set $edit to false for add mode
include_once('./includes/header.php');
?>

<div id="page-wrapper">
    <h2 class="page-header">Add Customer</h2>
    <form id="customer_form" enctype="multipart/form-data">
        <?php include_once('./forms/customer_form.php'); ?>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Capture form submit event
        $("#customer_form").submit(function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Create a FormData object from the form
            var formData = new FormData(this); // `this` refers to the form element

            // Log form data to console for debugging
            console.log("Captured Form Data:", Object.fromEntries(formData));

            // Send AJAX request
            $.ajax({
                url: 'add_customer.php', // Ensure this URL is correct
                type: 'POST',
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                data: formData,
                success: function (response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            alert(res.message);
                            window.location.href = 'index.php'; // Redirect on success
                        } else {
                            alert(res.message); // Show error message
                        }
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        alert("An unexpected error occurred. Please try again.");
                    }
                },

            error: function (xhr, status, error) {
                    // Handle error
                    console.error("Error occurred:", error);
                }
            });
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>