<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php"); // Include the province class file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL

    // Instantiate the Database and Province classes
    $db = new Database();
    $province = new Province($db);

    // Call the delete method to delete the provice record
    if ($province->delete($id)) {
        echo "Record deleted successfully.";
    } else {
        echo "Failed to delete the record.";
    }
}
?>
