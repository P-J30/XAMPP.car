<?php
session_start();
require_once 'config/database.php';
require_once 'api/rental.php';

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// สร้าง instance ของ Database และ Rental
$database = new Database();
$db = $database->getConnection();
$rental = new Rental($db);

// ค้นหาการเช่า
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $stmt = $rental->search($search);
} else {
    $stmt = $rental->read();
}

// ตรวจสอบว่ามีข้อมูลหรือไม่
$has_data = $stmt->rowCount() > 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรถยนต์ - จัดการการเช่า</title>
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-key"></i> รายการการเช่า
                </h5>
                <a href="add_rental.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> เพิ่มการเช่าใหม่
                </a>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-box" placeholder="ค้นหาการเช่า..." value="<?php echo $search; ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> ค้นหา
                        </button>
                    </div>
                </form>

                <?php if (!$has_data): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> ยังไม่มีข้อมูลการเช่า กรุณาเพิ่มการเช่าใหม่
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัสการเช่า</th>
                                    <th>รถ</th>
                                    <th>ลูกค้า</th>
                                    <th>วันที่เช่า</th>
                                    <th>วันที่คืน</th>
                                    <th>สถานะ</th>
                                    <th>ราคารวม</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo $row['rental_id']; ?></td>
                                        <td><?php echo $row['car_brand'] . ' ' . $row['car_model']; ?></td>
                                        <td><?php echo $row['customer_name']; ?></td>
                                        <td><?php echo isset($row['rental_date']) ? date('d/m/Y', strtotime($row['rental_date'])) : '-'; ?></td>
                                        <td><?php echo isset($row['return_date']) ? date('d/m/Y', strtotime($row['return_date'])) : '-'; ?></td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch($row['rental_status']) {
                                                case 'Pending':
                                                    $status_class = 'warning';
                                                    break;
                                                case 'Completed':
                                                    $status_class = 'success';
                                                    break;
                                                case 'Cancelled':
                                                    $status_class = 'danger';
                                                    break;
                                                default:
                                                    $status_class = 'secondary';
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $status_class; ?>">
                                                <?php echo $row['rental_status']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo number_format($row['total_price'], 2); ?> บาท</td>
                                        <td>
                                            <a href="edit_rental.php?id=<?php echo $row['rental_id']; ?>" class="btn btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete_rental.php?id=<?php echo $row['rental_id']; ?>" class="btn btn-danger btn-action" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลการเช่านี้?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 