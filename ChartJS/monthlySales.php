<?php
require('config/config.php');
require('config/db.php');

$sql = "SELECT MONTH(orders.order_date) AS Month, SUM(order_details.unit_price * order_details.quantity) AS MonthlySales
        FROM orders JOIN order_details ON orders.id = order_details.order_id WHERE YEAR(orders.order_date) = 2006
        GROUP BY MONTH(orders.order_date) ORDER BY Month ASC;";
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
    <title>Monthly Sales</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0" rel="stylesheet" />
    <script src="assets/js/plugins/chartist.min.js"></script>
</head>
<body>
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Monthly Sales</h4>
                <p class="category">Sales</p>
            </div>

            <div class="content">
                <canvas id="MonthlySalesLineChart"></canvas>
            </div>
            <script> 
                var ctx = document.getElementById('MonthlySalesLineChart').getContext('2d');

                var data = <?php echo json_encode($data); ?>;
                var labels = data.map(item => item.Month);
                var values = data.map(item => item.MonthlySales);

                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Sales',
                            data: values,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
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