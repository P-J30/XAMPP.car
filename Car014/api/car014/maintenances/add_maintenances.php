<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->car_id) && !empty($data->maintenance_date) && isset($data->description) && isset($data->cost) && !empty($data->status)) {
    try {
        $query = "INSERT INTO maintenance (car_id, maintenance_date, description, cost, status) 
                  VALUES (:car_id, :maintenance_date, :description, :cost, :status)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':car_id', $data->car_id);
        $stmt->bindParam(':maintenance_date', $data->maintenance_date);
        $stmt->bindParam(':description', $data->description);
        $stmt->bindParam(':cost', $data->cost);
        $stmt->bindParam(':status', $data->status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Maintenance record added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add maintenance record']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
