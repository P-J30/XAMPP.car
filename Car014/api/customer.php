<?php
class Customer {
    private $conn;
    private $table_name = "customers";

    public function __construct($db) {
        $this->conn = $db;
    }

    // อ่านข้อมูลลูกค้าทั้งหมด
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY customer_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // สร้างลูกค้าใหม่
    public function create($first_name, $last_name, $email, $phone_number, $address) {
        $query = "INSERT INTO " . $this->table_name . "
                (first_name, last_name, email, phone_number, address)
                VALUES
                (:first_name, :last_name, :email, :phone_number, :address)";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $first_name = htmlspecialchars(strip_tags($first_name));
        $last_name = htmlspecialchars(strip_tags($last_name));
        $email = htmlspecialchars(strip_tags($email));
        $phone_number = htmlspecialchars(strip_tags($phone_number));
        $address = htmlspecialchars(strip_tags($address));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":address", $address);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // อ่านข้อมูลลูกค้าตาม ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE customer_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // อัพเดทข้อมูลลูกค้า
    public function update($id, $first_name, $last_name, $email, $phone_number, $address) {
        $query = "UPDATE " . $this->table_name . "
                SET
                    first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    phone_number = :phone_number,
                    address = :address
                WHERE
                    customer_id = :id";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $first_name = htmlspecialchars(strip_tags($first_name));
        $last_name = htmlspecialchars(strip_tags($last_name));
        $email = htmlspecialchars(strip_tags($email));
        $phone_number = htmlspecialchars(strip_tags($phone_number));
        $address = htmlspecialchars(strip_tags($address));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":address", $address);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ลบข้อมูลลูกค้า
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE customer_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ค้นหาลูกค้า
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE first_name LIKE :keyword 
                OR last_name LIKE :keyword 
                OR email LIKE :keyword
                OR phone_number LIKE :keyword
                ORDER BY customer_id DESC";

        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?> 