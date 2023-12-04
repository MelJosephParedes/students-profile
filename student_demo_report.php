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
    <title>Student Demographic Report</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include('templates/header.html'); ?>
    <?php include('includes/navbar.php'); ?>

    <div class="content">
    <h2>Student Demographic Report</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Contact Number</th>
                <th>Street</th>
                <th>Town City</th>
                <th>Province</th>
                <th>ZIP Code</th>
                
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
    
            <?php
            $results = $student->displayAllDemoReport(); 
            
            foreach ($results as $result) {
            ?>
            
            <tr>
                <?php $birthday = new DateTime($result['birthday']); ?>
                
                <td><?php echo $result['first_name']; ?></td>
                <td><?php echo $result['middle_name']; ?></td>
                <td><?php echo $result['last_name']; ?></td>
                <td><?php echo $result['gender'] == 1 ? 'M' : 'F'; ?></td>
                <td><?php echo $birthday->format('M j Y'); ?></td>
                <td><?php echo $result['contact_number']; ?></td>
                <td><?php echo $result['street']; ?></td>
                <td><?php echo $result['town_city']; ?></td>
                <td><?php echo $result['province']; ?></td>
                <td><?php echo $result['zip_code']; ?></td>
            </tr>
            <?php } ?>

           
        </tbody>
    </table>

    <?php include('templates/footer.html'); ?>


    <p></p>

</body>
</html>