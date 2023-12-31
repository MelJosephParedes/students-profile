<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php");
include_once("../townCity_details.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['name'],
    ];

    // Instantiate the Database and TownCity classes
    $database = new Database();
    $city = new TownCity($database);
    $townCity_id = $city->create($data);
    
    if ($townCity_id) {
        // townCity record successfully created
        
        // Retrieve townCity details from the form
        $townCityDetailsData = [
            'id' => $town_city_id, // Use the obtained townCity ID
            'name' => $_POST['name'],
            
            // Other townCity details fields
        ];

        // Create province details linked to the province
        $townCityDetails = new townCityDetails($database);
        
        if ($townCityDetails->create($townCityDetailsData)) {
            echo "Record inserted successfully.";
        } else {
            echo "Failed to insert the record.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Town Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add Town Data</h1>
    <form action="" method="post" class="centered-form">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <input type="submit" value="Add Town">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
