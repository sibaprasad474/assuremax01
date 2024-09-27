<?php
session_start();
require_once '../db/db.php';

// Check if the request is an AJAX call for fetching customers
if (isset($_GET['action']) && $_GET['action'] === 'fetch_customers') {
    // Fetch customers from the database
    $query = "SELECT id, full_name, email, phone, pan_no, aadhar_no, dob, gender, insurance_type, 
                     policy_number, coverage_amount, premium_amount, policy_start_date, policy_end_date, created_at 
              FROM customers"; // Adjust to include the correct fields
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the customers as a JSON response
    echo json_encode(['data' => $customers]);
    exit; // Stop further execution
}

// Include header for the main page
include_once('./includes/header.php');
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Customers</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_customer.php?operation=create" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i> Add new
                </a>
            </div>
        </div>
    </div>

    <div id="export-section">
        <a href="export_customers.php">
            <button class="btn btn-sm btn-primary">
                Export to CSV <i class="glyphicon glyphicon-export"></i>
            </button>
        </a>
    </div>

    <!-- Responsive Table Container -->
    <div class="table-responsive">
        <table id="customersTable" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">Name</th>
                    <th width="20%">Email</th>
                    <th width="15%">Phone</th>
                    <th width="10%">PAN No</th>
                    <th width="10%">Aadhar No</th>
                    <th width="10%">DOB</th>
                    <th width="10%">Gender</th>
                    <th width="10%">Insurance Type</th>
                    <th width="10%">Policy Number</th>
                    <th width="10%">Coverage Amount</th>
                    <th width="10%">Premium Amount</th>
                    <th width="10%">Policy Start Date</th>
                    <th width="10%">Policy End Date</th>
                    <th width="10%">Created At</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here via AJAX -->
            </tbody>
        </table>
    </div>
    <!-- End Responsive Table Container -->

</div>

<!-- Linking DataTables script and CSS -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />

<script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#customersTable').DataTable({
            "ajax": {
                "url": "customers.php?action=fetch_customers", // AJAX endpoint to fetch data
                "dataSrc": "data" // The key in the returned JSON object that contains the array of data
            },
            "columns": [
                { "data": "id" },
                { "data": "full_name" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "pan_no" },
                { "data": "aadhar_no" },
                { "data": "dob" },
                { "data": "gender" },
                { "data": "insurance_type" },
                { "data": "policy_number" },
                { "data": "coverage_amount" },
                { "data": "premium_amount" },
                { "data": "policy_start_date" },
                { "data": "policy_end_date" },
                { "data": "created_at" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return `
                            <a href="edit_customer.php?id=${row.id}" class="btn btn-info btn-xs">Edit</a>
                            <button class="btn btn-danger btn-xs delete-btn" data-id="${row.id}">Delete</button>
                        `;
                    }
                }
            ],
            "order": [[0, "asc"]]
        });

        // Delete customer via AJAX
        $('#customersTable tbody').on('click', '.delete-btn', function() {
            var customerId = $(this).data('id');
            if (confirm('Are you sure you want to delete this customer?')) {
                $.ajax({
                    url: 'delete_customer.php',
                    type: 'POST',
                    data: { id: customerId },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            alert('Customer deleted successfully!');
                            table.ajax.reload(); // Reload the table data
                        } else {
                            alert('Failed to delete customer.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            }
        });
    });
</script>

<?php include_once('./includes/footer.php'); ?>
