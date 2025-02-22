<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health_record_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['userid'];  // Email field from login form
    $userPassword = $_POST['usrpsw'];  // Password field from login form

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password using password_verify()
        if (password_verify($userPassword, $user['password'])) {
            echo "<script>alert('Login Successful! Welcome, " . $user['first_name'] . "'); window.location.href='dashboard.html';</script>";
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email. Please register first.'); window.location.href='registration.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
