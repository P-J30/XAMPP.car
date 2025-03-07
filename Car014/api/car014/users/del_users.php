<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id)) {
    try {
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':user_id', $data->user_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete user']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
