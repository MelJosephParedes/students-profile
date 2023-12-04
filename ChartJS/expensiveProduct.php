<?php
require('config/config.php');
require('config/db.php');

$sql = "SELECT product_name, list_price FROM northwind.products order by list_price desc limit 5;";
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
            <h4 class="title">Top 5 Expensive Products</h4>
            <p class="category">Products</p>    
        </div>

        <div class="content">
            <canvas id="myChartTopFive"></canvas>
        </div>
        <script>
            const data = <?php echo json_encode($data); ?>;
            const label_barchart = data.map(item => item.product_name);
            const list_price = data.map(item => item.list_price);

            const ctx = document.getElementById('myChartTopFive').getContext('2d');
            const myChartTopFive = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label_barchart,
                    datasets: [{
                        label: 'Expensive Products',
                        data: list_price,
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
