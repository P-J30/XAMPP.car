<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->role_name)) {
    try {
        $query = "INSERT INTO roles (role_name, description) VALUES (:role_name, :description)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':role_name', $data->role_name);
        $stmt->bindParam(':description', $data->description);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Role added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add role']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
