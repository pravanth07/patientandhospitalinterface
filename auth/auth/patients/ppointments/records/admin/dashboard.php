<?php
include '../config/db.php';

$result = $conn->query("SELECT id, name, email, role FROM users");
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
$conn->close();
?>
