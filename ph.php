<?php
require "cons.php"; // This includes your database connection

// Assuming your connection variable is $conn
$query = "SELECT id, PH FROM aeroponics ORDER BY id ASC"; // Adjust as necessary
$result = $conn->query($query);

$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id'],
        
        'PH' => (float) $row['PH'] 

    ];
}

$jsonData = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PH LEVEL</title>
    <link rel="shortcut icon" href="./img/aer.png" type="image/x-icon">
    <script src="./js/highcharts.js"></script>
</head>
<body>
<?php include "sidebar.php"; ?>
<div id="phChart" style="width:100%; height:400px;"></div>


<script>
// Step 4222: Use Highcharts to display the graph
document.addEventListener('DOMContentLoaded', function () {
    var myData = <?php echo $jsonData; ?>;

    Highcharts.chart('phChart', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'PH Levels Over Time'
        },
        xAxis: {
            categories: myData.map(function(data) { return data.id; }) // Assuming 'id' can be your x-axis (time or sequence)
        },
        yAxis: {
            title: {
                text: 'PH Level'
            }
        },
        series: [{
            name: 'PH Level',
            data: myData.map(function(data) { return data.PH; })
        }]
    });
});
</script>

</body>

<style>
   


/* CSS for the PH chart container */
#phChart {
    max-width: 60%; /* Set the maximum width of the chart container */
    height: 400px; /* You can adjust the height as needed */
    border: 2px solid #333; /* Adding a border to the chart container */
    margin: 20px auto; /* Top and bottom margin 20px, auto to center it horizontally */
    box-sizing: border-box; /* To make sure padding and borders are included in the width */
}




</style>
</html>
