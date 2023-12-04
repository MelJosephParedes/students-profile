<?php
require('config/config.php');
require('config/db.php');

$sql = "SELECT customers.id, CONCAT(customers.first_name, ' ',customers.last_name) AS CustomerName, COUNT(DISTINCT orders.id) AS TotalOrders
        FROM customers JOIN orders ON customers.id = orders.customer_id GROUP BY customers.id, customers.first_name, customers.last_name
        ORDER BY TotalOrders DESC;";
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
    <title>Customers with More Than 15 Orders</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0" rel="stylesheet" />
</head>
<body>
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Customers with More Than 15 Orders</h4>
                <p class="category">Orders</p>
            </div>

            <div class="content" style="width: 1000; height:800px;">
                <canvas id="CustomerTotalOrders"></canvas>
            </div>
            <script>
                const data = <?php echo json_encode($data); ?>;
                const labels = data.map(item => item.CustomerName);
                const values = data.map(item => item.TotalOrders);

                const ctx = document.getElementById('CustomerTotalOrders').getContext('2d');
                const myDoughnutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
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
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            </script>
        </div>
    </div>
</body>
</html>