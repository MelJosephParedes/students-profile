<?php
require('config/config.php');
require('config/db.php');

$sql = "SELECT employees.id, CONCAT(employees.first_name,' ', employees.last_name) AS EmployeeName, COUNT(DISTINCT orders.id) AS AssistedOrders
        FROM employees JOIN orders ON employees.id = orders.employee_id JOIN order_details ON orders.id = order_details.order_id
        GROUP BY employees.id, employees.first_name, employees.last_name ORDER BY AssistedOrders DESC;";
$result = mysqli_query($conn, $sql);

$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    mysqli_free_result($result);
    mysqli_close($conn);
} else {
    echo "No records matching your query were found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expensive Products</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    
</head>
<body>
<div class="col-md-6">
    <div class="card">
        <div class="header">
            <h4 class="title">Assisted Orders</h4>
            <p class="category">Orders</p>    
        </div>

        <div class="content">
            <canvas id="Assisted Orders"></canvas>
        </div>
        <script>
            const data = <?php echo json_encode($data); ?>;
            const label_barchart = data.map(item => item.EmployeeName);
            const assistedOrders = data.map(item => item.AssistedOrders);

            const ctx = document.getElementById('Assisted Orders').getContext('2d');
            const myChartTopFive = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label_barchart,
                    datasets: [{
                        label: 'Assisted Orders',
                        data: assistedOrders,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                        beginAtZero: true
                        }
                    }   
                }
            });
        </script>
    </div>
</div>

</body>
</html>
