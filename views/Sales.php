<?php
class Sales {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "1cashier_db");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getSalesReport() {
        $query = "SELECT DATE(created_at) as sale_date, SUM(total_price) as total_sales FROM sales GROUP BY DATE(created_at)";
        
        $sales_data = [];
        if ($result = $this->conn->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $sales_data[] = $row;
            }
        }
        return $sales_data;
    }
}
?>
