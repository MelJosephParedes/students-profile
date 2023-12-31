<?php
include_once("student.php");
include_once("db.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Province Student Enrollment Report</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include('templates/header.html'); ?>
    <?php include('includes/navbar.php'); ?>

    <div class="content">
    <h2>Province Student Enrollment Report</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Province Name</th>
                <th>Total Students</th>
                <th>Total Town Cities</th>
                
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
    
            <?php
            $results = $student->displayAllProvinceEnroll(); 
            
            foreach ($results as $result) {
            ?>
            
            <tr>
                
                <td><?php echo $result['province_name']; ?></td>
                <td><?php echo $result['total_students']; ?></td>
                <td><?php echo $result['total_town_cities']; ?></td>
            </tr>
            <?php } ?>

           
        </tbody>
    </table>

    <?php include('templates/footer.html'); ?>


    <p></p>

</body>
</html>