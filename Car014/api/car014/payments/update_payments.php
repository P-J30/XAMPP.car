<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->payment_id)) {
    try {
        $query = "UPDATE payments SET payment_date = :payment_date, amount = :amount, 
                  payment_method = :payment_method, payment_status = :payment_status 
                  WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':payment_id', $data->payment_id);
        $stmt->bindParam(':payment_date', $data->payment_date);
        $stmt->bindParam(':amount', $data->amount);
        $stmt->bindParam(':payment_method', $data->payment_method);
        $stmt->bindParam(':payment_status', $data->payment_status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Payment updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update payment']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
