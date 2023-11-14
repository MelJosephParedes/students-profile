<?php
include_once("db.php");
class town_read{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM town_city WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $town_Data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $town_Data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}
?>