<?php
session_start();
require_once 'config/database.php';
require_once 'api/rental.php';
require_once 'api/car.php';
require_once 'api/customer.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามี ID ที่ต้องการแก้ไขหรือไม่
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ไม่พบข้อมูลที่ต้องการแก้ไข";
    header("Location: rentals.php");
    exit();
}

// สร้าง instance ของ Database และ Classes
$database = new Database();
$db = $database->getConnection();
$rental = new Rental($db);
$car = new Car($db);
$customer = new Customer($db);

// ดึงข้อมูลการเช่าที่ต้องการแก้ไข
$rental_data = $rental->readOne($_GET['id']);
if (!$rental_data) {
    $_SESSION['error'] = "ไม่พบข้อมูลที่ต้องการแก้ไข";
    header("Location: rentals.php");
    exit();
}

// ดึงข้อมูลรถและลูกค้าสำหรับ dropdown
$cars = $car->read();
$customers = $customer->read();

// จัดการการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'] ?? '';
    $customer_id = $_POST['customer_id'] ?? '';
    $rental_start_date = $_POST['rental_start_date'] ?? '';
    $rental_end_date = $_POST['rental_end_date'] ?? '';
    $total_price = $_POST['total_price'] ?? '';
    $rental_status = $_POST['rental_status'] ?? 'Pending';

    try {
        if ($rental->update($_GET['id'], $car_id, $customer_id, $rental_start_date, $rental_end_date, $total_price, $rental_status)) {
            $_SESSION['success'] = "อัพเดทข้อมูลการเช่าเรียบร้อยแล้ว";
            header("Location: rentals.php");
            exit();
        } else {
            $_SESSION['error'] = "ไม่สามารถอัพเดทข้อมูลการเช่าได้";
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
    <title>ระบบจัดการรถยนต์ - แก้ไขข้อมูลการเช่า</title>
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
                        <a class="nav-link" href="customers.php">
                            <i class="fas fa-users"></i> จัดการลูกค้า
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="rentals.php">
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
                    <i class="fas fa-edit"></i> แก้ไขข้อมูลการเช่า
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
                            <label for="car_id" class="form-label">รถ</label>
                            <select class="form-select" id="car_id" name="car_id" required>
                                <option value="">เลือกรถ</option>
                                <?php while ($car_row = $cars->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $car_row['car_id']; ?>" <?php echo ($car_row['car_id'] == $rental_data['car_id']) ? 'selected' : ''; ?>>
                                        <?php echo $car_row['brand'] . ' ' . $car_row['model'] . ' (' . $car_row['year'] . ')'; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <div class="invalid-feedback">
                                กรุณาเลือกรถ
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="customer_id" class="form-label">ลูกค้า</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">เลือกลูกค้า</option>
                                <?php while ($customer_row = $customers->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $customer_row['customer_id']; ?>" <?php echo ($customer_row['customer_id'] == $rental_data['customer_id']) ? 'selected' : ''; ?>>
                                        <?php echo $customer_row['first_name'] . ' ' . $customer_row['last_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <div class="invalid-feedback">
                                กรุณาเลือกลูกค้า
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rental_start_date" class="form-label">วันที่เริ่มเช่า</label>
                            <input type="date" class="form-control" id="rental_start_date" name="rental_start_date" 
                                value="<?php echo $rental_data['rental_start_date']; ?>" required>
                            <div class="invalid-feedback">
                                กรุณาเลือกวันที่เริ่มเช่า
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rental_end_date" class="form-label">วันที่สิ้นสุดการเช่า</label>
                            <input type="date" class="form-control" id="rental_end_date" name="rental_end_date" 
                                value="<?php echo $rental_data['rental_end_date']; ?>" required>
                            <div class="invalid-feedback">
                                กรุณาเลือกวันที่สิ้นสุดการเช่า
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="total_price" class="form-label">ราคารวม</label>
                            <input type="number" class="form-control" id="total_price" name="total_price" 
                                value="<?php echo $rental_data['total_price']; ?>" min="0" step="0.01" required>
                            <div class="invalid-feedback">
                                กรุณากรอกราคารวม
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rental_status" class="form-label">สถานะ</label>
                            <select class="form-select" id="rental_status" name="rental_status" required>
                                <option value="Pending" <?php echo ($rental_data['rental_status'] == 'Pending') ? 'selected' : ''; ?>>รอดำเนินการ</option>
                                <option value="Completed" <?php echo ($rental_data['rental_status'] == 'Completed') ? 'selected' : ''; ?>>เสร็จสิ้น</option>
                                <option value="Cancelled" <?php echo ($rental_data['rental_status'] == 'Cancelled') ? 'selected' : ''; ?>>ยกเลิก</option>
                            </select>
                            <div class="invalid-feedback">
                                กรุณาเลือกสถานะ
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="rentals.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> กลับ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> บันทึก
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

        // ตรวจสอบวันที่สิ้นสุดต้องมากกว่าวันที่เริ่มต้น
        document.getElementById('rental_end_date').addEventListener('change', function() {
            var startDate = document.getElementById('rental_start_date').value;
            var endDate = this.value;
            if (startDate && endDate && endDate < startDate) {
                alert('วันที่สิ้นสุดต้องมากกว่าวันที่เริ่มต้น');
                this.value = '';
            }
        });
    </script>
</body>
</html> 