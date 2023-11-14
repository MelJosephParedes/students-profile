<?php
include_once("db.php"); // Include the file with the Database class

class provinceDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a townCity detail entry and link it to a province
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO province_details(id, name) VALUES(:id, :name);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':name', $data['name']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
        
    }

    // Other CRUD methods for province details
}

?>