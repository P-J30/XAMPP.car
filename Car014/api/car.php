<?php
class Car {
    private $conn;
    private $table_name = "cars";

    public function __construct($db) {
        $this->conn = $db;
    }

    // อ่านข้อมูลรถทั้งหมด
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY car_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // สร้างรถใหม่
    public function create($brand, $model, $year, $color, $engine_type, $transmission, $seats, $price) {
        $query = "INSERT INTO " . $this->table_name . "
                (brand, model, year, color, engine_type, transmission, seats, price)
                VALUES
                (:brand, :model, :year, :color, :engine_type, :transmission, :seats, :price)";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $brand = htmlspecialchars(strip_tags($brand));
        $model = htmlspecialchars(strip_tags($model));
        $color = htmlspecialchars(strip_tags($color));
        $engine_type = htmlspecialchars(strip_tags($engine_type));
        $transmission = htmlspecialchars(strip_tags($transmission));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":brand", $brand);
        $stmt->bindParam(":model", $model);
        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":color", $color);
        $stmt->bindParam(":engine_type", $engine_type);
        $stmt->bindParam(":transmission", $transmission);
        $stmt->bindParam(":seats", $seats);
        $stmt->bindParam(":price", $price);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // อ่านข้อมูลรถตาม ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE car_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // อัพเดทข้อมูลรถ
    public function update($id, $brand, $model, $year, $color, $engine_type, $transmission, $seats, $price) {
        $query = "UPDATE " . $this->table_name . "
                SET
                    brand = :brand,
                    model = :model,
                    year = :year,
                    color = :color,
                    engine_type = :engine_type,
                    transmission = :transmission,
                    seats = :seats,
                    price = :price
                WHERE
                    car_id = :id";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $brand = htmlspecialchars(strip_tags($brand));
        $model = htmlspecialchars(strip_tags($model));
        $color = htmlspecialchars(strip_tags($color));
        $engine_type = htmlspecialchars(strip_tags($engine_type));
        $transmission = htmlspecialchars(strip_tags($transmission));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":brand", $brand);
        $stmt->bindParam(":model", $model);
        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":color", $color);
        $stmt->bindParam(":engine_type", $engine_type);
        $stmt->bindParam(":transmission", $transmission);
        $stmt->bindParam(":seats", $seats);
        $stmt->bindParam(":price", $price);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ลบข้อมูลรถ
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE car_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ค้นหารถ
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE brand LIKE :keyword 
                OR model LIKE :keyword 
                OR color LIKE :keyword
                ORDER BY car_id DESC";

        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?> 