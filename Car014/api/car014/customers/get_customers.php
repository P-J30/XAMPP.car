<?php
include_once 'C:/xampp/htdocs/050_Carrent/config/db.php';
header('Content-Type: application/json');

try {
    // Check if a specific customer_id is provided via GET parameter
    if (isset($_GET['customer_id'])) {
        $customer_id = intval($_GET['customer_id']);
        
        $query = "SELECT * FROM customers WHERE customer_id = :customer_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($customer) {
            echo json_encode($customer);
        } else {
            echo json_encode(['error' => 'Customer not found']);
        }
    } 
    // If no customer_id, retrieve all customers with optional pagination
    else {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        $offset = ($page - 1) * $limit;
        
        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total FROM customers";
        $countStmt = $conn->prepare($countQuery);
        $countStmt->execute();
        $totalCustomers = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Retrieve customers
        $query = "SELECT * FROM customers LIMIT :limit OFFSET :offset";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'customers' => $customers,
            'total' => $totalCustomers,
            'page' => $page,
            'limit' => $limit
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>