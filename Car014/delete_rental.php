<?php
session_start();
require_once 'config/database.php';
require_once 'api/rental.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามี ID ที่ต้องการลบหรือไม่
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ไม่พบข้อมูลที่ต้องการลบ";
    header("Location: rentals.php");
    exit();
}

// สร้าง instance ของ Database และ Rental
$database = new Database();
$db = $database->getConnection();
$rental = new Rental($db);

try {
    // ลบข้อมูลการเช่า
    if ($rental->delete($_GET['id'])) {
        $_SESSION['success'] = "ลบข้อมูลการเช่าเรียบร้อยแล้ว";
    } else {
        $_SESSION['error'] = "ไม่สามารถลบข้อมูลการเช่าได้";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
}

// กลับไปยังหน้า rentals.php
header("Location: rentals.php");
exit(); 