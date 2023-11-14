<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php");
include_once("../province_details.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['name'],
    ];

    // Instantiate the Database and province classes
    $database = new Database();
    $province = new Province($database);
    $province_id = $province->create($data);
    
    if ($province_id) {
        // province record successfully created
        
        // Retrieve province details from the form
        $provinceDetailsData = [
            'id' => $province_id, // Use the obtained province ID
            'name' => $_POST['name'],
            
            // Other province details fields
        ];

        // Create province details linked to the province
        $provinceDetails = new provinceDetails($database);
        
        if ($provinceDetails->create($provinceDetailsData)) {
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
