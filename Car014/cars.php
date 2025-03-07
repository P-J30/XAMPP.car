<?php
session_start();
require_once 'config/db.php';
require_once 'api/car014/car.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// สร้าง instance ของ Database และ Car
$database = new Database();
$db = $database->getConnection();
$car = new Car($db);

// ดึงข้อมูลรถทั้งหมด
$stmt = $car->read();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรถยนต์ - รายการรถ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="cars.php">
                <i class="fas fa-car"></i> ระบบจัดการรถยนต์
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="cars.php">
                            <i class="fas fa-list"></i> รายการรถ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customers.php">
                            <i class="fas fa-users"></i> ลูกค้า
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rentals.php">
                            <i class="fas fa-key"></i> การเช่า
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-car"></i> รายการรถยนต์
                </h5>
                <div class="d-flex">
                    <div class="input-group search-box me-2">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="ค้นหารถ...">
                    </div>
                    <a href="add_car.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> เพิ่มรถใหม่
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if($num > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัสรถ</th>
                                    <th>ยี่ห้อ</th>
                                    <th>รุ่น</th>
                                    <th>ปี</th>
                                    <th>สี</th>
                                    <th>เครื่องยนต์</th>
                                    <th>เกียร์</th>
                                    <th>ที่นั่ง</th>
                                    <th>ราคา</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cars as $row): ?>
                                    <tr>
                                        <td><?php echo $row['car_id']; ?></td>
                                        <td><?php echo $row['brand']; ?></td>
                                        <td><?php echo $row['model']; ?></td>
                                        <td><?php echo $row['year']; ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <?php echo $row['color']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $row['engine_type']; ?></td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?php echo $row['transmission']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $row['seats']; ?></td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?php echo number_format($row['price'], 2); ?> บาท
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit_car.php?id=<?php echo $row['car_id']; ?>" class="btn btn-warning btn-sm btn-action" title="แก้ไข">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete_car.php?id=<?php echo $row['car_id']; ?>" class="btn btn-danger btn-sm btn-action" title="ลบ" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> ไม่พบข้อมูลรถยนต์
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ค้นหารถแบบ Real-time
        document.querySelector('.search-box input').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
</body>
</html> 