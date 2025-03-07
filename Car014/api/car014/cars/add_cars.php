<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->brand) && !empty($data->model) && !empty($data->year)) {
    try {
        $query = "INSERT INTO cars (brand, model, year, color, engine_type, transmission, seats, price)    
        VALUES (:brand, :model, :year, :color, :engine_type, :transmission, :seats, :price)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':brand', $data->brand);
        $stmt->bindParam(':model', $data->model);
        $stmt->bindParam(':year', $data->year);
        $stmt->bindParam(':color', $data->color);
        $stmt->bindParam(':engine_type', $data->engine_type);
        $stmt->bindParam(':transmission', $data->transmission);
        $stmt->bindParam(':seats', $data->seats);
        $stmt->bindParam(':price', $data->price);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Car added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add car']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
