<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());
    $stmt->close();
} else {
    echo json_encode(["error" => "No patient ID provided"]);
}

$conn->close();
?>
