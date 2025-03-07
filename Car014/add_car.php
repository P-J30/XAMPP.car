<?php
session_start();
require_once 'config/database.php';
require_once 'api/car.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// สร้าง instance ของ Database และ Car
$database = new Database();
$db = $database->getConnection();
$car = new Car($db);

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $color = $_POST['color'];
    $engine_type = $_POST['engine_type'];
    $transmission = $_POST['transmission'];
    $seats = $_POST['seats'];
    $price = $_POST['price'];

    // สร้างรถใหม่
    if ($car->create($brand, $model, $year, $color, $engine_type, $transmission, $seats, $price)) {
        $_SESSION['success'] = "เพิ่มข้อมูลรถสำเร็จ";
        header("Location: cars.php");
        exit();
    } else {
        $error = "ไม่สามารถเพิ่มข้อมูลรถได้ กรุณาลองใหม่อีกครั้ง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรถยนต์ - เพิ่มรถใหม่</title>
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
                        <a class="nav-link active" href="add_car.php">
                            <i class="fas fa-plus"></i> เพิ่มรถใหม่
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i> เพิ่มรถใหม่
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ยี่ห้อรถ</label>
                                    <input type="text" name="brand" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">รุ่นรถ</label>
                                    <input type="text" name="model" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ปีที่ผลิต</label>
                                    <input type="number" name="year" class="form-control" min="1900" max="2024" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">สี</label>
                                    <input type="text" name="color" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชนิดเครื่องยนต์</label>
                                    <select name="engine_type" class="form-select" required>
                                        <option value="">เลือกชนิดเครื่องยนต์</option>
                                        <option value="เบนซิน">เบนซิน</option>
                                        <option value="ดีเซล">ดีเซล</option>
                                        <option value="ไฟฟ้า">ไฟฟ้า</option>
                                        <option value="ไฮบริด">ไฮบริด</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชนิดเกียร์</label>
                                    <select name="transmission" class="form-select" required>
                                        <option value="">เลือกชนิดเกียร์</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automatic">Automatic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">จำนวนที่นั่ง</label>
                                    <input type="number" name="seats" class="form-control" min="1" max="10" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ราคา (บาท)</label>
                                    <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="cars.php" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> ยกเลิก
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> บันทึก
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 