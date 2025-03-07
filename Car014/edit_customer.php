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
    $_SESSION['error'] = "ไม่พบข้อมูลลูกค้าที่ต้องการแก้ไข";
    header("Location: customers.php");
    exit();
}

$customer_id = $_GET['id'];

// สร้าง instance ของ Database และ Customer
$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);

// ดึงข้อมูลลูกค้า
$customer_data = $customer->readOne($customer_id);

// ถ้าไม่พบข้อมูลลูกค้า
if (!$customer_data) {
    $_SESSION['error'] = "ไม่พบข้อมูลลูกค้าที่ต้องการแก้ไข";
    header("Location: customers.php");
    exit();
}

// จัดการการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $driver_license_number = $_POST['driver_license_number'] ?? '';

    try {
        if ($customer->update($customer_id, $first_name, $last_name, $email, $phone_number, $address, $driver_license_number)) {
            $_SESSION['success'] = "แก้ไขข้อมูลลูกค้าเรียบร้อยแล้ว";
            header("Location: customers.php");
            exit();
        } else {
            $_SESSION['error'] = "ไม่สามารถแก้ไขข้อมูลลูกค้าได้";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรถยนต์ - แก้ไขข้อมูลลูกค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-car"></i> ระบบจัดการรถยนต์
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cars.php">
                            <i class="fas fa-list"></i> รายการรถ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="customers.php">
                            <i class="fas fa-users"></i> จัดการลูกค้า
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rentals.php">
                            <i class="fas fa-key"></i> จัดการการเช่า
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit"></i> แก้ไขข้อมูลลูกค้า
                </h5>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" 
                                value="<?php echo htmlspecialchars($customer_data['first_name']); ?>" required>
                            <div class="invalid-feedback">
                                กรุณากรอกชื่อ
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" 
                                value="<?php echo htmlspecialchars($customer_data['last_name']); ?>" required>
                            <div class="invalid-feedback">
                                กรุณากรอกนามสกุล
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="<?php echo htmlspecialchars($customer_data['email']); ?>" required>
                            <div class="invalid-feedback">
                                กรุณากรอกอีเมลที่ถูกต้อง
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                value="<?php echo htmlspecialchars($customer_data['phone_number']); ?>" required>
                            <div class="invalid-feedback">
                                กรุณากรอกเบอร์โทรศัพท์
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">ที่อยู่</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($customer_data['address']); ?></textarea>
                        <div class="invalid-feedback">
                            กรุณากรอกที่อยู่
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="driver_license_number" class="form-label">หมายเลขใบขับขี่</label>
                        <input type="text" class="form-control" id="driver_license_number" name="driver_license_number" 
                            value="<?php echo htmlspecialchars($customer_data['driver_license_number']); ?>" required>
                        <div class="invalid-feedback">
                            กรุณากรอกหมายเลขใบขับขี่
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="customers.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> กลับ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ตรวจสอบความถูกต้องของฟอร์ม
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html> 