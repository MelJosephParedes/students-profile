<?php
include_once("db.php"); // Include the Database class file
include_once("town_add.php");
include_once("town_edit.php");
include_once("town_delete.php");
include_once("town.view.php");
class TownCity {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM town_city";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors (log or display)
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

}


$town_id_add = $town_add->create($data);

$town_id_edit = $town_edit->update($id, $data);

$town_id_delete = $town_delete->delete($id);

?>
