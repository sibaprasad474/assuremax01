<?php

session_start();
require_once '../db/db.php'; // Ensure this path is correct

// Check if the database connection is established
if (!isset($conn)) {
    die('Database connection failed.');
}

// Select fields to export based on the provided data structure
$select = array('id', 'full_name', 'email', 'phone', 'pan_no', 'aadhar_no', 'dob', 'gender', 'insurance_type', 'policy_number', 'coverage_amount', 'premium_amount', 'policy_start_date', 'policy_end_date', 'created_at');

$chunk_size = 100; // Number of rows to fetch per query
$offset = 0; // Start from the beginning

// Fetch total count of records
$total_count_query = $conn->query("SELECT COUNT(*) FROM customers");
$total_count = $total_count_query->fetchColumn(); // Get the total count

// Create a memory stream to hold CSV data
$handle = fopen('php://memory', 'w');

// Write the CSV header
fputcsv($handle, $select);
$filename = 'export_customers.csv';

// Calculate the number of queries needed to fetch all records
$num_queries = ceil($total_count / $chunk_size); // Use ceil to round up

// Prevent memory leak for large number of rows by using limit and offset
for ($i = 0; $i < $num_queries; $i++) {
    // Fetch rows in chunks
    $query = $conn->prepare("SELECT " . implode(',', $select) . " FROM customers LIMIT :offset, :chunk_size");
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->bindValue(':chunk_size', $chunk_size, PDO::PARAM_INT);
    $query->execute();
    
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    
    // If no rows returned, break out of the loop
    if (empty($rows)) {
        break;
    }
    
    // Write each row to the CSV
    foreach ($rows as $row) {
        fputcsv($handle, array_values($row));
    }
    
    // Update offset for the next chunk
    $offset += $chunk_size;
}

// Reset the file pointer to the start of the file
fseek($handle, 0);

// Tell the browser it's going to be a CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');

// Send the generated CSV lines directly to the browser
fpassthru($handle);
exit; // End the script to prevent any additional output
