<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->maintenance_id)) {
    try {
        $query = "DELETE FROM maintenance WHERE maintenance_id = :maintenance_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':maintenance_id', $data->maintenance_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Maintenance record deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete maintenance record']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
