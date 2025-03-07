<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->maintenance_id) && isset($data->car_id) && isset($data->maintenance_date) && isset($data->description) && isset($data->cost) && isset($data->status)) {
    try {
        $query = "UPDATE maintenance 
                  SET car_id = :car_id, maintenance_date = :maintenance_date, description = :description, cost = :cost, status = :status 
                  WHERE maintenance_id = :maintenance_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':maintenance_id', $data->maintenance_id);
        $stmt->bindParam(':car_id', $data->car_id);
        $stmt->bindParam(':maintenance_date', $data->maintenance_date);
        $stmt->bindParam(':description', $data->description);
        $stmt->bindParam(':cost', $data->cost);
        $stmt->bindParam(':status', $data->status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Maintenance record updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update maintenance record']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
