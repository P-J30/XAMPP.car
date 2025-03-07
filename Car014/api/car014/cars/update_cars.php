<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->car_id) && !empty($data->brand) && !empty($data->model) && !empty($data->year)) {
    try {
        $query = "UPDATE cars SET brand = :brand, model = :model, year = :year, color = :color, 
                  engine_type = :engine_type, transmission = :transmission, seats = :seats, price = :price 
                  WHERE car_id = :car_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':brand', $data->brand);
        $stmt->bindParam(':model', $data->model);
        $stmt->bindParam(':year', $data->year);
        $stmt->bindParam(':color', $data->color);
        $stmt->bindParam(':engine_type', $data->engine_type);
        $stmt->bindParam(':transmission', $data->transmission);
        $stmt->bindParam(':seats', $data->seats);
        $stmt->bindParam(':price', $data->price);
        $stmt->bindParam(':car_id', $data->car_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Car updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update car']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
