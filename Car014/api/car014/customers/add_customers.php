<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->first_name) && !empty($data->last_name) && !empty($data->phone_number) && !empty($data->driver_license_number)) {
    try {
        $query = "INSERT INTO customers 
                  (first_name, last_name, phone_number, email, address, driver_license_number) 
                  VALUES (:first_name, :last_name, :phone_number, :email, :address, :driver_license_number)";
        
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':phone_number', $data->phone_number);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':address', $data->address);
        $stmt->bindParam(':driver_license_number', $data->driver_license_number);
        
        if ($stmt->execute()) {
            $customerId = $conn->lastInsertId();
            echo json_encode([
                'message' => 'Customer added successfully', 
                'customer_id' => $customerId
            ]);
        } else {
            echo json_encode(['message' => 'Failed to add customer']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Missing required fields']);
}
?>