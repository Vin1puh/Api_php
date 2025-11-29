<?php
class Worker
{
    private $conn;
    private $table_name = "assembly_registry";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createAssembly($assembly_date, $worker_name, $product_code, $product_name, $quantity, $work_cost)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (assembly_date, worker_name, product_code, product_name, quantity, work_cost) 
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $assembly_date);
        $stmt->bindParam(2, $worker_name);
        $stmt->bindParam(3, $product_code);
        $stmt->bindParam(4, $product_name);
        $stmt->bindParam(5, $quantity);
        $stmt->bindParam(6, $work_cost);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateAssembly($id, $assembly_date, $worker_name, $product_code, $product_name, $quantity, $work_cost)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET assembly_date = ?, worker_name = ?, product_code = ?, product_name = ?, quantity = ?, work_cost = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $assembly_date);
        $stmt->bindParam(2, $worker_name);
        $stmt->bindParam(3, $product_code);
        $stmt->bindParam(4, $product_name);
        $stmt->bindParam(5, $quantity);
        $stmt->bindParam(6, $work_cost);
        $stmt->bindParam(7, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteAssembly($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAssemblyById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}