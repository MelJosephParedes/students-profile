<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php"); // Include the town_city class file

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch towncity data by ID from the database
    $db = new Database();
    $city = new TownCity($db);
    $townCityData = $city->read($id); // Implement the read method in the towncity class

    if ($townCityData) {
        // The towncity data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "City not found.";
    }
} else {
    echo "towncity ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        
    ];

    $db = new Database();
    $city = new TownCity($db);

    // Call the edit method to update the towncity data
    if ($city->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit City</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit City Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $townCityData['id']; ?>">
        
        <label for="Name">City Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $townCityData['name']; ?>">
        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
