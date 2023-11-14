<?php
include_once("db.php");
class town_add{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO students(name) VALUES(:name);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':name', $data['name']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
             
            if($stmt->rowCount() > 0)
            {
                return $this->db->getConnection()->lastInsertId();
            }

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}
?>