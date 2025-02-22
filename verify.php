<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health_record_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["code"])) {
    $code = $_GET["code"];
    $sql = "UPDATE users SET email_verified = 1 WHERE verification_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $code);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Email successfully verified!";
    } else {
        echo "Invalid or already verified link!";
    }

    $stmt->close();
    $conn->close();
}
?>
