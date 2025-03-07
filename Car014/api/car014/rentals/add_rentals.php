<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->customer_id) && !empty($data->car_id) && !empty($data->rental_start_date) && !empty($data->rental_end_date) && !empty($data->total_price)) {
    try {
        $query = "INSERT INTO rentals (customer_id, car_id, rental_start_date, rental_end_date, total_price, rental_status) 
                  VALUES (:customer_id, :car_id, :rental_start_date, :rental_end_date, :total_price, :rental_status)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':customer_id', $data->customer_id);
        $stmt->bindParam(':car_id', $data->car_id);
        $stmt->bindParam(':rental_start_date', $data->rental_start_date);
        $stmt->bindParam(':rental_end_date', $data->rental_end_date);
        $stmt->bindParam(':total_price', $data->total_price);
        $stmt->bindParam(':rental_status', $data->rental_status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Rental added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add rental']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
