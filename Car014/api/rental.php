<?php
class Rental {
    private $conn;
    private $table_name = "rentals";

    public function __construct($db) {
        $this->conn = $db;
    }

    // อ่านข้อมูลการเช่าทั้งหมด
    public function read() {
        $query = "SELECT r.*, 
                    c.brand as car_brand, c.model as car_model,
                    CONCAT(cust.first_name, ' ', cust.last_name) as customer_name
                FROM " . $this->table_name . " r
                LEFT JOIN cars c ON r.car_id = c.car_id
                LEFT JOIN customers cust ON r.customer_id = cust.customer_id
                ORDER BY r.rental_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // สร้างการเช่าใหม่
    public function create($car_id, $customer_id, $rental_start_date, $rental_end_date, $total_price, $rental_status) {
        $query = "INSERT INTO " . $this->table_name . "
                (car_id, customer_id, rental_start_date, rental_end_date, total_price, rental_status)
                VALUES
                (:car_id, :customer_id, :rental_start_date, :rental_end_date, :total_price, :rental_status)";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $car_id = htmlspecialchars(strip_tags($car_id));
        $customer_id = htmlspecialchars(strip_tags($customer_id));
        $rental_start_date = htmlspecialchars(strip_tags($rental_start_date));
        $rental_end_date = htmlspecialchars(strip_tags($rental_end_date));
        $total_price = htmlspecialchars(strip_tags($total_price));
        $rental_status = htmlspecialchars(strip_tags($rental_status));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":car_id", $car_id);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->bindParam(":rental_start_date", $rental_start_date);
        $stmt->bindParam(":rental_end_date", $rental_end_date);
        $stmt->bindParam(":total_price", $total_price);
        $stmt->bindParam(":rental_status", $rental_status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // อ่านข้อมูลการเช่าตาม ID
    public function readOne($id) {
        $query = "SELECT r.*, 
                    c.brand as car_brand, c.model as car_model,
                    CONCAT(cust.first_name, ' ', cust.last_name) as customer_name
                FROM " . $this->table_name . " r
                LEFT JOIN cars c ON r.car_id = c.car_id
                LEFT JOIN customers cust ON r.customer_id = cust.customer_id
                WHERE r.rental_id = :id
                LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // อัพเดทข้อมูลการเช่า
    public function update($id, $car_id, $customer_id, $rental_start_date, $rental_end_date, $total_price, $rental_status) {
        $query = "UPDATE " . $this->table_name . "
                SET
                    car_id = :car_id,
                    customer_id = :customer_id,
                    rental_start_date = :rental_start_date,
                    rental_end_date = :rental_end_date,
                    total_price = :total_price,
                    rental_status = :rental_status
                WHERE
                    rental_id = :id";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $id = htmlspecialchars(strip_tags($id));
        $car_id = htmlspecialchars(strip_tags($car_id));
        $customer_id = htmlspecialchars(strip_tags($customer_id));
        $rental_start_date = htmlspecialchars(strip_tags($rental_start_date));
        $rental_end_date = htmlspecialchars(strip_tags($rental_end_date));
        $total_price = htmlspecialchars(strip_tags($total_price));
        $rental_status = htmlspecialchars(strip_tags($rental_status));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":car_id", $car_id);
        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->bindParam(":rental_start_date", $rental_start_date);
        $stmt->bindParam(":rental_end_date", $rental_end_date);
        $stmt->bindParam(":total_price", $total_price);
        $stmt->bindParam(":rental_status", $rental_status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ลบข้อมูลการเช่า
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE rental_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ค้นหาการเช่า
    public function search($keyword) {
        $query = "SELECT r.*, 
                    c.brand as car_brand, c.model as car_model,
                    CONCAT(cust.first_name, ' ', cust.last_name) as customer_name
                FROM " . $this->table_name . " r
                LEFT JOIN cars c ON r.car_id = c.car_id
                LEFT JOIN customers cust ON r.customer_id = cust.customer_id
                WHERE c.brand LIKE :keyword 
                OR c.model LIKE :keyword 
                OR cust.first_name LIKE :keyword 
                OR cust.last_name LIKE :keyword 
                OR r.rental_status LIKE :keyword
                ORDER BY r.rental_id DESC";

        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?> 