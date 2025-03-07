<?php
class Car {
    private $conn;
    private $table_name = "cars";

    public $car_id;
    public $brand;
    public $model;
    public $year;
    public $color;
    public $engine_type;
    public $transmission;
    public $seats;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ดึงข้อมูลรถทั้งหมด
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // เพิ่มข้อมูลรถใหม่
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    brand = :brand,
                    model = :model,
                    year = :year,
                    color = :color,
                    engine_type = :engine_type,
                    transmission = :transmission,
                    seats = :seats,
                    price = :price";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->engine_type = htmlspecialchars(strip_tags($this->engine_type));
        $this->transmission = htmlspecialchars(strip_tags($this->transmission));
        $this->seats = htmlspecialchars(strip_tags($this->seats));
        $this->price = htmlspecialchars(strip_tags($this->price));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":brand", $this->brand);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":engine_type", $this->engine_type);
        $stmt->bindParam(":transmission", $this->transmission);
        $stmt->bindParam(":seats", $this->seats);
        $stmt->bindParam(":price", $this->price);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // อัพเดทข้อมูลรถ
    public function update() {
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
                    car_id = :car_id";

        $stmt = $this->conn->prepare($query);

        // ทำความสะอาดข้อมูล
        $this->car_id = htmlspecialchars(strip_tags($this->car_id));
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->engine_type = htmlspecialchars(strip_tags($this->engine_type));
        $this->transmission = htmlspecialchars(strip_tags($this->transmission));
        $this->seats = htmlspecialchars(strip_tags($this->seats));
        $this->price = htmlspecialchars(strip_tags($this->price));

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(":car_id", $this->car_id);
        $stmt->bindParam(":brand", $this->brand);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":engine_type", $this->engine_type);
        $stmt->bindParam(":transmission", $this->transmission);
        $stmt->bindParam(":seats", $this->seats);
        $stmt->bindParam(":price", $this->price);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ลบข้อมูลรถ
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE car_id = ?";
        $stmt = $this->conn->prepare($query);
        $this->car_id = htmlspecialchars(strip_tags($this->car_id));
        $stmt->bindParam(1, $this->car_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?> 