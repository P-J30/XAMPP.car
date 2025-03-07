<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->car_id)) {
    try {
        $query = "DELETE FROM cars WHERE car_id = :car_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':car_id', $data->car_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Car deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete car']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
