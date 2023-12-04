<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); // Include the Student class file
include_once("../student_details.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    // Fetch student data by ID from the database
    $db = new Database();
    $student = new Student($db);
    $studentData = $student->read($id); // Implement the read method in the Student class
    $studentDetails = new StudentDetails($db);
    $studentDetailsData = $studentDetails->read($id);

    if ($studentData) {
        // The student data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "Student not found.";
    }
    if($studentDetailsData){
        // retrieved
    } else {
        echo "Student details not found";
    }
} else {
    echo "Student ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'student_number' => $_POST['student_number'],
        'first_name' => $_POST['first_name'],
        'middle_name' => $_POST['middle_name'],
        'last_name' => $_POST['last_name'],
        'gender' => $_POST['gender'],
        'birthday' => $_POST['birthday'],
        'student_id' => $_POST['id'],
        'contact_number' => $_POST['contact_number'],
        'street' => $_POST['street'],
        'zip_code' => $_POST['zip_code'],
        'town_city' => $_POST['town_city'],
        'province' => $_POST['province'],
    ];

    $db = new Database();
    $student = new Student($db);
    $studentDetails = new StudentDetails($db);
    // Call the edit method to update the student data
    try {
    if ($student->update($id, $data)) {
        if ($studentDetails->update($id, $data)){
            echo "Record updated successfully.";
        } else {
            echo "Failed to update the student_details.";
        }
    
    } else {
        echo "Failed to update the record. test";
    } 
    } catch (PDOException $e){
        echo "Database Error:" . $e->getMessage();
    } 
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit Student</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Student Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $studentData['id']; ?>">
        
        <label for="student_number">Student Number:</label>
        <input type="text" name="student_number" id="student_number" value="<?php echo $studentData['student_number']; ?>">
        
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $studentData['first_name']; ?>">
        
        <label for="middle_name">Middle Name:</label>
        <input type="text" name= "middle_name" id="middle_name" value="<?php echo $studentData['middle_name']; ?>">
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $studentData['last_name']; ?>">
        
        <label for="gender">Gender:</label>
            <?php
                $connection = $db->getConnection();
                $sql = "SELECT id, gender FROM students WHERE id = :id";
                $stmt = $connection->prepare($sql);
                $stmt->bindValue(':id', $id);
                $stmt->execute();
                $studentGenders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<select name='gender' id='gender'>";
                foreach ($studentGenders as $studentGender) {
                $genderText = ($studentGender['gender'] == 1) ? 'Male' : 'Female';
                $selected = ($studentGender['gender'] == $studentDetailsData['gender']) ? 'selected' : '';
                echo "<option value='" . $studentGender['gender'] . "' $selected>" . $genderText . "</option>";
                }
                echo "</select>";
            ?>
        
        <label for="birthday">Birthdate:</label>
        <input type="date" name="birthday" id="birthday" value="<?php echo $studentData['birthday']; ?>">

        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" id="contact_number" value="<?php echo $studentDetailsData['contact_number']; ?>">

        <label for="street">Street:</label>
        <input type="text" name="street" id="street" value="<?php echo $studentDetailsData['street']; ?>">

        <label for="zip_code">ZIP Code:</label>
        <input type="text" name="zip_code" id="zip_code" value="<?php echo $studentDetailsData['zip_code']; ?>">

        <label for="town_city">Town City:</label>
            <?php
                $connection = $db->getConnection();
                $sql = "SELECT id, name FROM town_city WHERE id =".$studentDetailsData['town_city'];
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $town_cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<select name='town_city' id='town_city'>";
                foreach ($town_cities as $town_city) {
                    echo "<option value='" . $town_city['id'] . "'>" . $town_city['name'] . "</option>";
                }
                
                $sql = "SELECT id, name FROM town_city";
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $town_cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($town_cities as $town_city) {
                    echo "<option value='" . $town_city['id'] . "'>" . $town_city['name'] . "</option>";
                }
                echo "</select>";
            ?>
        
        <label for="province">Province:</label>
            <?php
                $connection = $db->getConnection();
                $sql = "SELECT id, name FROM province WHERE id =". $studentDetailsData['province'];
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $provinces = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<select name='province' id='province'>";
                foreach ($provinces as $province) {
                    echo "<option value='" . $province['id'] . "'>" . $province['name'] . "</option>";
                }

                $sql = "SELECT id, name FROM province";
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $provinces = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($provinces as $province) {
                    echo "<option value='" . $province['id'] . "'>" . $province['name'] . "</option>";
                }
                echo "</select>";
            ?>

        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
