<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->rental_id) && !empty($data->payment_date) && !empty($data->amount)) {
    try {
        $query = "INSERT INTO payments (rental_id, payment_date, amount, payment_method, payment_status) 
                  VALUES (:rental_id, :payment_date, :amount, :payment_method, :payment_status)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':rental_id', $data->rental_id);
        $stmt->bindParam(':payment_date', $data->payment_date);
        $stmt->bindParam(':amount', $data->amount);
        $stmt->bindParam(':payment_method', $data->payment_method);
        $stmt->bindParam(':payment_status', $data->payment_status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Payment added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add payment']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
