<?php
class Worker
{
    private $conn;
    private $table_name = "assembly_registry";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getTopWorker()
    {
        $query = "
            SELECT 
                worker_name, 
                SUM(quantity) as total_assembled
            FROM 
                " . $this->table_name . "
            GROUP BY 
                worker_name
            ORDER BY 
                total_assembled DESC
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBestDay($workerName)
    {
        $query = "
            SELECT 
                assembly_date, 
                quantity,
                product_name
            FROM 
                " . $this->table_name . "
            WHERE 
                worker_name = ?
            ORDER BY 
                quantity DESC
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$workerName]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMonthlyEarnings()
    {
        $query = "
            SELECT 
                worker_name, 
                SUM(work_cost) as total_earnings
            FROM 
                " . $this->table_name . "
            GROUP BY 
                worker_name
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getWorstWorker()
    {
        $query = "
            SELECT 
                worker_name, 
                SUM(quantity) as total_assembled
            FROM 
                " . $this->table_name . "
            GROUP BY 
                worker_name
            ORDER BY 
                total_assembled ASC
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWorkersReport()
    {
        $query = "
            SELECT 
                worker_name, 
                assembly_date, 
                SUM(quantity) as total_assembled, 
                SUM(work_cost) as total_cost
            FROM 
                " . $this->table_name . "
            GROUP BY 
                worker_name, assembly_date
            ORDER BY 
                worker_name, assembly_date
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getWorkersDetailedReport()
    {
        $query = "
            SELECT 
                worker_name, 
                assembly_date,
                product_name,
                quantity,
                work_cost
            FROM 
                " . $this->table_name . "
            ORDER BY 
                worker_name, assembly_date, product_name
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAllData()
    {
        $query = "
            SELECT 
                ar.assembly_date,
                ar.worker_name,
                ar.product_code,
                ar.product_name,
                ar.quantity,
                ar.work_cost
            FROM 
                assembly_registry ar
            ORDER BY 
                ar.assembly_date, ar.worker_name
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}