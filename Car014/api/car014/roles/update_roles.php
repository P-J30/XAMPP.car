<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->role_id)) {
    try {
        $query = "UPDATE roles SET role_name = :role_name, description = :description WHERE role_id = :role_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':role_id', $data->role_id);
        $stmt->bindParam(':role_name', $data->role_name);
        $stmt->bindParam(':description', $data->description);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Role updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update role']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
