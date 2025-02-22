<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health_record_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $reset_code = md5(uniqid($email, true));

    $sql = "UPDATE users SET verification_code = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $reset_code, $email);
    $stmt->execute();

    $to = $email;
    $subject = "Password Reset";
    $message = "Click this link to reset your password: http://localhost/reset_password.php?code=$reset_code";
    $headers = "From: noreply@yourdomain.com\r\n";

    mail($to, $subject, $message, $headers);
    echo "Password reset link has been sent!";
}
?>
