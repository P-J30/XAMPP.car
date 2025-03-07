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
    $_SESSION['error'] = "ไม่พบข้อมูลรถที่ต้องการแก้ไข";
    header("Location: cars.php");
    exit();
}

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

    // อัพเดทข้อมูลรถ
    if ($car->update($id, $brand, $model, $year, $color, $engine_type, $transmission, $seats, $price)) {
        $_SESSION['success'] = "แก้ไขข้อมูลรถสำเร็จ";
        header("Location: cars.php");
        exit();
    } else {
        $error = "ไม่สามารถแก้ไขข้อมูลรถได้ กรุณาลองใหม่อีกครั้ง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรถยนต์ - แก้ไขข้อมูลรถ</title>
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
                        <a class="nav-link" href="add_car.php">
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
                            <i class="fas fa-edit"></i> แก้ไขข้อมูลรถ
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
                                    <input type="text" name="brand" class="form-control" value="<?php echo $car_data['brand']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">รุ่นรถ</label>
                                    <input type="text" name="model" class="form-control" value="<?php echo $car_data['model']; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ปีที่ผลิต</label>
                                    <input type="number" name="year" class="form-control" min="1900" max="2024" value="<?php echo $car_data['year']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">สี</label>
                                    <input type="text" name="color" class="form-control" value="<?php echo $car_data['color']; ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชนิดเครื่องยนต์</label>
                                    <select name="engine_type" class="form-select" required>
                                        <option value="">เลือกชนิดเครื่องยนต์</option>
                                        <option value="เบนซิน" <?php echo $car_data['engine_type'] == 'เบนซิน' ? 'selected' : ''; ?>>เบนซิน</option>
                                        <option value="ดีเซล" <?php echo $car_data['engine_type'] == 'ดีเซล' ? 'selected' : ''; ?>>ดีเซล</option>
                                        <option value="ไฟฟ้า" <?php echo $car_data['engine_type'] == 'ไฟฟ้า' ? 'selected' : ''; ?>>ไฟฟ้า</option>
                                        <option value="ไฮบริด" <?php echo $car_data['engine_type'] == 'ไฮบริด' ? 'selected' : ''; ?>>ไฮบริด</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ชนิดเกียร์</label>
                                    <select name="transmission" class="form-select" required>
                                        <option value="">เลือกชนิดเกียร์</option>
                                        <option value="Manual" <?php echo $car_data['transmission'] == 'Manual' ? 'selected' : ''; ?>>Manual</option>
                                        <option value="Automatic" <?php echo $car_data['transmission'] == 'Automatic' ? 'selected' : ''; ?>>Automatic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">จำนวนที่นั่ง</label>
                                    <input type="number" name="seats" class="form-control" min="1" max="10" value="<?php echo $car_data['seats']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ราคา (บาท)</label>
                                    <input type="number" name="price" class="form-control" min="0" step="0.01" value="<?php echo $car_data['price']; ?>" required>
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