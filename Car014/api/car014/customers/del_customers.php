<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->customer_id)) {
    try {
        $query = "DELETE FROM customers WHERE customer_id = :customer_id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':customer_id', $data->customer_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                echo json_encode([
                    'message' => 'Customer deleted successfully', 
                    'rows_affected' => $rowCount
                ]);
            } else {
                echo json_encode(['message' => 'No customer found with given ID']);
            }
        } else {
            echo json_encode(['message' => 'Failed to delete customer']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Customer ID is required']);
}
?>