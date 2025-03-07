<?php
session_start();
require_once 'config/database.php';
require_once 'api/customer.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามี ID ที่ส่งมาหรือไม่
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ไม่พบข้อมูลลูกค้าที่ต้องการลบ";
    header("Location: customers.php");
    exit();
}

$customer_id = $_GET['id'];

// สร้าง instance ของ Database และ Customer
$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

try {
    // ตรวจสอบว่ามีการเช่าที่เกี่ยวข้องกับลูกค้านี้หรือไม่
    $query = "SELECT COUNT(*) as count FROM rentals WHERE customer_id = :customer_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":customer_id", $customer_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $_SESSION['error'] = "ไม่สามารถลบข้อมูลลูกค้าได้เนื่องจากมีการเช่าที่เกี่ยวข้อง";
        header("Location: customers.php");
        exit();
    }

    // ลบข้อมูลลูกค้า
    if ($customer->delete($customer_id)) {
        $_SESSION['success'] = "ลบข้อมูลลูกค้าเรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "ไม่สามารถลบข้อมูลลูกค้าได้";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
}

// กลับไปยังหน้าจัดการลูกค้า
header("Location: customers.php");
exit(); 