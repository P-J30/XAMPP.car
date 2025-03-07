<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->payment_id)) {
    try {
        $query = "DELETE FROM payments WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':payment_id', $data->payment_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Payment deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete payment']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
