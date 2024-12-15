<?php
// Database connection credentials
$servername = "localhost";
$username = "web_user";
$password = "Nassar@321456#";
$dbname = "web_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally create a table
$sql = "CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50) NOT NULL,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'visitors' is ready.<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Get visitor's IP address and current time
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$current_time = date('Y-m-d H:i:s');

// Insert visitor details into the database
$sql = "INSERT INTO visitors (ip_address) VALUES ('$visitor_ip')";
if ($conn->query($sql) === TRUE) {
    echo "Visitor logged successfully.<br>";
} else {
    echo "Error logging visitor: " . $conn->error;
}

// Display visitor's IP and current time
echo "Your IP address is: $visitor_ip<br>";
echo "Current server time is: $current_time<br>";

echo "Thank you 😚";
$conn->close();
?>

