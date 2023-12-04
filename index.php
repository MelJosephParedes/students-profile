<?php
require_once("db.php");
include_once("student.php");

$db = new Database();
$pdo = $db->getConnection();
$student = new Student($db);

$sql = "SELECT
                SUM(CASE WHEN students.gender = 1 THEN 1 ELSE 0 END) AS male_count,
                SUM(CASE WHEN students.gender = 0 THEN 1 ELSE 0 END) AS female_count
        FROM students
        JOIN student_details ON students.id = student_details.student_id
        JOIN province ON student_details.province = province.id
        WHERE province.name = 'Adrienfurt';";

$stmt = $pdo->query($sql);

$data = array();

if ($stmt) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    $stmt->closeCursor();
} else {
    echo "No records matching your query were found.";
}
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
    </script>
</head>
<body>
    <!-- Include the header -->
    <?php include('templates/header.html'); ?>
    <?php include('includes/navbar.php'); ?>

    <div class="content" style="width: 600px; height: 1000px;">
        <h2>Adrienfurt's Male and Female Count</h2>
        <canvas id="AdrienfurtCount"></canvas>
    </div>
    <script>
            const data = <?php echo json_encode($data); ?>;
            const labels = ['Male', 'Female']
            const datasetDataCount = [data[0].male_count, data[0].female_count];

            const ctx = document.getElementById('AdrienfurtCount').getContext('2d');
            const AdrienfurtCount = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: datasetDataCount,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {}
            });
        </script>

        <!-- Include the footer -->
    <?php include('templates/footer.html'); ?>
</body>
</html>
