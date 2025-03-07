<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->rental_id)) {
    try {
        $query = "DELETE FROM rentals WHERE rental_id = :rental_id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':rental_id', $data->rental_id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Rental deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete rental']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
