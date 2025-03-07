<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: cars.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการรถยนต์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .welcome-container {
            text-align: center;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 90%;
        }
        .welcome-header {
            margin-bottom: 2rem;
        }
        .welcome-header i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #f1c40f;
        }
        .welcome-header h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .welcome-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .feature-item {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .feature-item:hover {
            transform: translateY(-5px);
        }
        .feature-item i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #f1c40f;
        }
        .feature-item h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .feature-item p {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        .btn-login {
            background-color: #f1c40f;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 30px;
            color: #2c3e50;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #f39c12;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-container">
            <div class="welcome-header">
                <i class="fas fa-car"></i>
                <h1>ระบบจัดการรถยนต์</h1>
                <p>ระบบจัดการข้อมูลรถยนต์ที่ใช้งานง่าย สะดวก รวดเร็ว</p>
            </div>

            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-list"></i>
                    <h3>จัดการข้อมูลรถ</h3>
                    <p>เพิ่ม แก้ไข ลบ และค้นหาข้อมูลรถยนต์ได้อย่างรวดเร็ว</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <h3>จัดการลูกค้า</h3>
                    <p>เก็บข้อมูลลูกค้าและประวัติการเช่าได้อย่างครบถ้วน</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-key"></i>
                    <h3>จัดการการเช่า</h3>
                    <p>ติดตามสถานะการเช่าและจัดการการคืนรถได้อย่างมีประสิทธิภาพ</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line"></i>
                    <h3>รายงานและสถิติ</h3>
                    <p>ดูรายงานและสถิติต่างๆ ได้อย่างละเอียด</p>
                </div>
            </div>

            <a href="login.php" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 