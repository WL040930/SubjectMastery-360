<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Pie Chart Example</h1>
    <canvas id="myPieChart" width="400" height="400"></canvas>

    <script>
        // Data for the pie chart
        var pieData = {
            labels: ['Category A', 'Category B', 'Category C'],
            datasets: [{
                data: [30, 40, 30],
                backgroundColor: ['red', 'green', 'blue'],
            }]
        };

        // Get the context of the canvas element
        var ctx = document.getElementById('myPieChart').getContext('2d');

        // Create a pie chart
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: pieData,
        });
    </script>
</body>
</html>
