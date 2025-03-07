<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id)) {
    try {
        $query = "UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, 
                  email = :email, phone_number = :phone_number, role_id = :role_id, status = :status 
                  WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':user_id', $data->user_id);
        $stmt->bindParam(':username', $data->username);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':phone_number', $data->phone_number);
        $stmt->bindParam(':role_id', $data->role_id);
        $stmt->bindParam(':status', $data->status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'User updated successfully']);
        } else {
            echo json_encode(['message' => 'Failed to update user']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
