<?php
class Database
{
    private $host = "192.168.110.160";
    private $username = "user8";
    private $password = "Aa_000000";
    private $database = "dbuser8";
    private $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->conn->exec("set names utf8");

            $this->createTables();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->conn;
    }

    private function createTables()
    {
        $query1 = "CREATE TABLE IF NOT EXISTS pricelist (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_code VARCHAR(50) UNIQUE NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            assembly_cost DECIMAL(10,2) NOT NULL
        )";

        $query2 = "CREATE TABLE IF NOT EXISTS assembly_registry (
            id INT AUTO_INCREMENT PRIMARY KEY,
            assembly_date DATE NOT NULL,
            worker_name VARCHAR(100) NOT NULL,
            product_code VARCHAR(50) NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            quantity INT NOT NULL,
            work_cost DECIMAL(10,2) NOT NULL
        )";

        try {
            $this->conn->exec($query1);
            $this->conn->exec($query2);

            $this->insertTestData();
        } catch (PDOException $e) {
            echo "Error creating tables: " . $e->getMessage();
        }
    }

    private function insertTestData()
    {
        try {
            $checkPricelist = $this->conn->query("SELECT COUNT(*) FROM pricelist")->fetchColumn();
            $checkRegistry = $this->conn->query("SELECT COUNT(*) FROM assembly_registry")->fetchColumn();

            if ($checkPricelist == 0) {
                $prices = [
                    ['P001', 'Смартфон X1', 1500.00],
                    ['P002', 'Планшет Tab2', 2000.00],
                    ['P003', 'Ноутбук Pro', 3500.00],
                    ['P004', 'Монитор 24"', 800.00],
                    ['P005', 'Клавиатура Mech', 300.00],
                    ['P006', 'Мышь Wireless', 200.00],
                    ['P007', 'Наушники Pro', 600.00]
                ];

                $stmt = $this->conn->prepare("INSERT INTO pricelist (product_code, product_name, assembly_cost) VALUES (?, ?, ?)");
                foreach ($prices as $price) {
                    $stmt->execute($price);
                }
            }

            if ($checkRegistry == 0) {
                $assemblies = [
                    ['2024-01-15', 'Иванов', 'P001', 'Смартфон X1', 5, 7500.00],
                    ['2024-01-15', 'Петров', 'P002', 'Планшет Tab2', 3, 6000.00],
                    ['2024-01-16', 'Сидоров', 'P003', 'Ноутбук Pro', 2, 7000.00],
                    ['2024-01-16', 'Иванов', 'P001', 'Смартфон X1', 8, 12000.00],
                    ['2024-01-17', 'Козлов', 'P004', 'Монитор 24"', 10, 8000.00],
                    ['2024-01-17', 'Петров', 'P005', 'Клавиатура Mech', 15, 4500.00],
                    ['2024-01-18', 'Сидоров', 'P006', 'Мышь Wireless', 20, 4000.00],
                    ['2024-01-18', 'Иванов', 'P007', 'Наушники Pro', 6, 3600.00],
                    ['2024-01-19', 'Козлов', 'P002', 'Планшет Tab2', 4, 8000.00],
                    ['2024-01-19', 'Петров', 'P003', 'Ноутбук Pro', 1, 3500.00],
                    ['2024-01-20', 'Смирнов', 'P001', 'Смартфон X1', 7, 10500.00],
                    ['2024-01-20', 'Иванов', 'P004', 'Монитор 24"', 12, 9600.00],
                    ['2024-01-21', 'Петров', 'P006', 'Мышь Wireless', 18, 3600.00],
                    ['2024-01-21', 'Козлов', 'P007', 'Наушники Pro', 9, 5400.00],
                    ['2024-01-22', 'Сидоров', 'P005', 'Клавиатура Mech', 11, 3300.00]
                ];

                $stmt = $this->conn->prepare("INSERT INTO assembly_registry (assembly_date, worker_name, product_code, product_name, quantity, work_cost) VALUES (?, ?, ?, ?, ?, ?)");
                foreach ($assemblies as $assembly) {
                    $stmt->execute($assembly);
                }
            }
        } catch (PDOException $e) {
            echo "Error inserting test data: " . $e->getMessage();
        }
    }
}