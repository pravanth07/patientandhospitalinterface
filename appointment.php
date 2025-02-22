<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "health_record_db"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Print form data to check missing fields
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Retrieve form data safely
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$purpose = isset($_POST['subject']) ? trim($_POST['subject']) : ''; // FIX: Change from subject to purpose
$phone = isset($_POST['number']) ? trim($_POST['number']) : '';
$department = isset($_POST['Department']) ? trim($_POST['Department']) : '';
$appointment_date = isset($_POST['appointment_date']) ? trim($_POST['appointment_date']) : '';
$appointment_time = isset($_POST['Time']) ? trim($_POST['Time']) : '';

// Check if any field is missing
if (empty($name) || empty($email) || empty($purpose) || empty($phone) || empty($department) || empty($appointment_date) || empty($appointment_time)) {
    die("⚠️ Error: Please fill in all required fields.");
}

// Prepare SQL statement
$sql = "INSERT INTO appointments (name, email, purpose, phone, department, appointment_date, appointment_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $email, $purpose, $phone, $department, $appointment_date, $appointment_time);

if ($stmt->execute()) {
    echo "✅ Appointment booked successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
