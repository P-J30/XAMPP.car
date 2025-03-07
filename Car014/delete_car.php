<?php
session_start();
require_once 'config/database.php';
require_once 'api/car.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบ ID
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "กรุณาระบุรหัสรถที่ต้องการลบ";
    header("Location: cars.php");
    exit();
}

$id = $_GET['id'];

// สร้าง instance ของ Database และ Car
$database = new Database();
$db = $database->getConnection();
$car = new Car($db);

// อ่านข้อมูลรถ
$car_data = $car->readOne($id);

// ถ้าไม่พบข้อมูลรถ
if (!$car_data) {
    $_SESSION['error'] = "ไม่พบข้อมูลรถที่ต้องการลบ";
    header("Location: cars.php");
    exit();
}

// ลบข้อมูลรถ
if ($car->delete($id)) {
    $_SESSION['success'] = "ลบข้อมูลรถสำเร็จ";
} else {
    $_SESSION['error'] = "ไม่สามารถลบข้อมูลรถได้ กรุณาลองใหม่อีกครั้ง";
}

// กลับไปยังหน้าจัดการรถ
header("Location: cars.php");
exit();
?> 