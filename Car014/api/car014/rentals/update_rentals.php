<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->rental_id)) {
    try {
        $query = "UPDATE rentals SET rental_start_date = :rental_start_date, rental_end_date = :rental_end_date, 
                  total_price = :total_price, rental_status = :rental_status WHERE rental_id = :rental_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':rental_id', $data->rental_id);
        $stmt->bindParam(':rental_start_date', $data->rental_start_date);
        $stmt->bindParam(':rental_end_date', $data->rental_end_date);
        $stmt->bindParam(':total_price', $data->total_price);
        $stmt->bindParam(':rental_status', $data->rental_status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Rental updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update rental']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
