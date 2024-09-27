<?php
// Database credentials
$host = 'localhost';    // Hostname
$db_name = 'assuremax';  // Database name
$username = 'root';      // Database username
$password = '';          // Database password

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // If connection is successful, you can add any confirmation logic here
    // echo "Connected successfully"; 
    
} catch (PDOException $e) {
    // If connection fails, show the error
    echo "Connection failed: " . $e->getMessage();
}
?>
