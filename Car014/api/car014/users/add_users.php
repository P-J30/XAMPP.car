<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username) && !empty($data->password) && !empty($data->first_name) && !empty($data->last_name)) {
    try {
        $query = "INSERT INTO users (username, password, first_name, last_name, email, phone_number, role_id, status) 
                  VALUES (:username, :password, :first_name, :last_name, :email, :phone_number, :role_id, :status)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':username', $data->username);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':phone_number', $data->phone_number);
        $stmt->bindParam(':role_id', $data->role_id);
        $stmt->bindParam(':status', $data->status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'User added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add user']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
