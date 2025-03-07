<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

try {
    $query = "SELECT * FROM rentals";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rentals);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
