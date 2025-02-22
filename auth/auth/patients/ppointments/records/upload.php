<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $patient_id = $_POST["patient_id"];
    $record_type = $_POST["record_type"];
    $target_dir = "../uploads/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO medical_records (patient_id, record_type, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $patient_id, $record_type, $target_file);

        if ($stmt->execute()) {
            echo json_encode(["message" => "File uploaded successfully"]);
        } else {
            echo json_encode(["error" => "Database error"]);
        }
    } else {
        echo json_encode(["error" => "Failed to upload file"]);
    }

    $stmt->close();
    $conn->close();
}
?>
