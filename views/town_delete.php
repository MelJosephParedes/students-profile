<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php"); // Include the townCity class file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL

    // Instantiate the Database and townCity classes
    $db = new Database();
    $city = new TownCity($db);

    // Call the delete method to delete the student record
    if ($city->delete($id)) {
        echo "Record deleted successfully.";
    } else {
        echo "Failed to delete the record.";
    }
}
?>
