<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->customer_id)) {
    try {
        $updateFields = [];
        $bindParams = [':customer_id' => $data->customer_id];

        $allowedFields = ['first_name', 'last_name', 'phone_number', 'email', 'address', 'driver_license_number'];
        
        foreach ($allowedFields as $field) {
            if (isset($data->$field) && $data->$field !== null) {
                $updateFields[] = "$field = :$field";
                $bindParams[":$field"] = $data->$field;
            }
        }

        if (empty($updateFields)) {
            echo json_encode(['error' => 'No fields to update']);
            exit;
        }

        $query = "UPDATE customers SET " . implode(', ', $updateFields) . 
                 " WHERE customer_id = :customer_id";
        
        $stmt = $conn->prepare($query);
        $stmt->execute($bindParams);
        
        $rowCount = $stmt->rowCount();
        
        if ($rowCount > 0) {
            echo json_encode([
                'message' => 'Customer updated successfully', 
                'rows_affected' => $rowCount
            ]);
        } else {
            echo json_encode(['message' => 'No changes made or customer not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Customer ID is required']);
}
?>