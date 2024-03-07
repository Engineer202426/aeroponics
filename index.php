<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header('Location: ./login.php');
  exit;
}

require "cons.php"; 
$vsQuery = "SELECT VS FROM aeroponics ORDER BY id DESC LIMIT 1";
$vsResult = $conn->query($vsQuery);

$vsValue = 0; // Default value in case there is no data
if ($vsResult->num_rows > 0) {
    $latestVS = $vsResult->fetch_assoc()['VS'];
    switch ($latestVS) {
        case 'Empty':
            $vsValue = 0;
            break;
        case 'Moderate':
            $vsValue = 50;
            break;
        case 'Full':
            $vsValue = 100;
            break;
        default:
            $vsValue = 0; // Default case if the value is none of the expected ones
    }
} else {
    // Handle error or set default value if no entry is found
    $vsValue = 0;
}


function fetchChartData($conn, $column) {
  $query = "SELECT id, `$column` FROM aeroponics ORDER BY id ASC";
  $result = $conn->query($query);

  $data = [];
  while($row = $result->fetch_assoc()) {
      $data[] = [
          'id' => $row['id'],
          $column => (float) $row[$column]
      ];
  }

  return json_encode($data);
}

// Fetch data for each chart
$phData = fetchChartData($conn, 'PH');
$ecData = fetchChartData($conn, 'EC');
$wtData = fetchChartData($conn, 'WT');

# Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DASHBOARD</title>
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/aer.png" type="image/x-icon">
  <script type="text/javascript" src="./js/loader.js"></script>
  <script src="./js/highcharts.js"></script>
</head>

<body>
  <?php include "sidebar.php"; ?>
  
  <div class="container-fluid mt-3">
    <div class="row">
      <!-- Gauge Container -->
      <div class="col-lg-4 chart-container">
        <div id="vsGauge" class="chart"></div>
      </div>

      <!-- PH Chart Container -->
      <div class="col-lg-4 chart-container">
        <div id="phChart" class="chart" style="height:400px;"></div>
      </div>

      <!-- EC Chart Container -->
      <div class="col-lg-4 chart-container">
        <div id="ecChart" class="chart" style="height:400px;"></div>
      </div>
    </div>
    <div class="row">
      <!-- WT Chart Container -->
      <div class="col-lg-12 chart-container">
        <div id="wtChart" class="chart" style="height:400px;"></div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Volume', 0],
      ]);

      var options = {
        width: 400, height: 400,
        redFrom: 75, redTo: 100,
        yellowFrom:50, yellowTo: 75,
        greenFrom:0, greenTo: 50,
        minorTicks: 5,
        animation:{
          duration: 1200,
          easing: 'out',
        }
      };

      var chart = new google.visualization.Gauge(document.getElementById('vsGauge'));

      chart.draw(data, options);

      // Set the value with animation
      data.setValue(0, 1, <?php echo $vsValue; ?>);
      chart.draw(data, options);
    }


    function renderChart(container, title, data, yAxisTitle, seriesName) {
            Highcharts.chart(container, {
                chart: {
                    type: 'line'
                },
                title: {
                    text: title
                },
                xAxis: {
                    categories: data.map(function(item) { return item.id; })
                },
                yAxis: {
                    title: {
                        text: yAxisTitle
                    }
                },
                series: [{
                    name: seriesName,
                    data: data.map(function(item) { return item[seriesName]; })
                }]
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderChart('phChart', 'PH Levels Over Time', <?php echo $phData; ?>, 'PH Level', 'PH');
            renderChart('ecChart', 'EC Levels Over Time', <?php echo $ecData; ?>, 'EC Level', 'EC');
            renderChart('wtChart', 'Water Temperature Over Time', <?php echo $wtData; ?>, 'Water Temperature', 'WT');
        });
  </script>
</body>
</html>
<style>
    .container-fluid {
      padding-left: 250px;
    }

    .chart-container {
      padding: 15px;
    }

    .chart {
      border: 1px solid #333;
      margin-top: 15px;
      background: #fff; 
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
    }

    #vsGauge {
      height: 400px; 
      width: 100%; 
    }

    
    @media (max-width: 768px) {
      .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
      }
    }
  </style>