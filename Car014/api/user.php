<?php
class User {
    private $conn;
    private $table_name = "users";

    public $user_id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $role_id;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ตรวจสอบการล็อกอิน
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role_id'] = $row['role_id'];
                return true;
            }
        }
        return false;
    }

    // เพิ่มผู้ใช้ใหม่
    public function create($username, $password, $first_name, $last_name, $email, $phone_number, $role_id) {
        // ตรวจสอบว่ามีข้อมูลในตาราง roles หรือไม่
        $check_role = "SELECT role_id FROM roles WHERE role_id = :role_id";
        $stmt = $this->conn->prepare($check_role);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // ถ้าไม่มีข้อมูลในตาราง roles ให้เพิ่มข้อมูล
            $insert_role = "INSERT INTO roles (role_id, role_name, description) VALUES 
                (1, 'admin', 'ผู้ดูแลระบบ'),
                (2, 'staff', 'พนักงาน'),
                (3, 'customer', 'ลูกค้า')";
            $this->conn->exec($insert_role);
        }

        // สร้างผู้ใช้ใหม่
        $query = "INSERT INTO " . $this->table_name . "
                (username, password, first_name, last_name, email, phone_number, role_id)
                VALUES
                (:username, :password, :first_name, :last_name, :email, :phone_number, :role_id)";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $username = htmlspecialchars(strip_tags($username));
        $first_name = htmlspecialchars(strip_tags($first_name));
        $last_name = htmlspecialchars(strip_tags($last_name));
        $email = htmlspecialchars(strip_tags($email));
        $phone_number = htmlspecialchars(strip_tags($phone_number));

        // เข้ารหัสรหัสผ่าน
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":role_id", $role_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?> 