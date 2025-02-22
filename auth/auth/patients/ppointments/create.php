<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $patient_id, $doctor_id, $appointment_date);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Appointment created successfully"]);
    } else {
        echo json_encode(["error" => "Failed to create appointment"]);
    }

    $stmt->close();
    $conn->close();
}
?>
