<?php
require_once("../db.php");
require_once("../town_city.php");

$db = new Database();
$connection = $db->getConnection();
$towncity = new TownCity($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Town City Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Town City Records</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
       
            <?php
            $results = $towncity->getAll(); 
            foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['name']; ?></td>
                <td>
                    <a href="town_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    |
                    <a href="town_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="town_add.php">Add City Record</a>

        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>
