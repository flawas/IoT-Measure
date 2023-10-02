<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div>
  <canvas id="myChart"></canvas>
</div>

<?php
//include("../config.php");
$today = date("Y-m-d");
$todayMinusOne = date("Y-m-d", strtotime("-1 days"));
$todayMinusTwo = date("Y-m-d", strtotime("-2 days"));
$todayMinusThree = date("Y-m-d", strtotime("-3 days"));
$todayMinusFour = date("Y-m-d", strtotime("-4 days"));
$todayMinusFive = date("Y-m-d", strtotime("-5 days"));
$todayMinusSix = date("Y-m-d", strtotime("-6 days"));

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$today_data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$today%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($today_data);
$avgToday = $mysql_row["average"];

$todayMinusOne_Data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusOne%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusOne_Data);
$avgTodayMinusOne = $mysql_row["average"];

$todayMinusTwo_Data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusTwo%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusTwo_Data);
$avgTodayMinusTwo = $mysql_row["average"];

$todayMinusThree_Data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusThree%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusThree_Data);
$avgTodayMinusThree = $mysql_row["average"];

$todayMinusFour_Data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusFour%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusFour_Data);
$avgTodayMinusFour = $mysql_row["average"];

$todayMinusFive_Data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusFive%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusFive_Data);
$avgTodayMinusFive = $mysql_row["average"];

$todayMinusSix_Data = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusSix%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusSix_Data);
$avgTodayMinusSix = $mysql_row["average"];

?>


<script>

  const ctx = document.getElementById('myChart');
  var today = new Date();
  var todayMinusOne = new Date();
  todayMinusOne.setDate(todayMinusOne.getDate() - 1);

  var todayMinusTwo = new Date();
  todayMinusTwo.setDate(todayMinusTwo.getDate() - 2);

  var todayMinusThree = new Date();
  todayMinusThree.setDate(todayMinusTwo.getDate() - 3);

  var todayMinusFour = new Date();
  todayMinusFour.setDate(todayMinusTwo.getDate() - 4);

  var todayMinusFive = new Date();
  todayMinusFive.setDate(todayMinusTwo.getDate() - 5);

  var todayMinusSix = new Date();
  todayMinusSix.setDate(todayMinusTwo.getDate() - 6);


  var days = new Array(7);
  days[0] = "Sonntag";
  days[1] = "Montag";
  days[2] = "Dienstag";
  days[3] = "Mittwoch";
  days[4] = "Donnerstag";
  days[5] = "Freitag";
  days[6] = "Samstag";
  var todayName = days[today.getDay()];
  var todayMinusOneName = days[todayMinusOne.getDay()];
  var todayMinusTwoName = days[todayMinusTwo.getDay()];
  var todayMinusThreeName = days[todayMinusThree.getDay()];
  var todayMinusFourName = days[todayMinusFour.getDay()];
  var todayMinusFiveName = days[todayMinusFive.getDay()];
  var todayMinusSixName = days[todayMinusSix.getDay()];


  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [todayMinusSixName, todayMinusFiveName, todayMinusFourName, todayMinusThreeName, todayMinusTwoName, todayMinusOneName, todayName],
      datasets: [{
        label: 'Durchschnitt Temperatur',
        data: [<?php echo $avgTodayMinusSix; ?>, <?php echo $avgTodayMinusFive; ?>, <?php echo $avgTodayMinusFour; ?>, <?php echo $avgTodayMinusThree; ?>, <?php echo $avgTodayMinusTwo; ?>, <?php echo $avgTodayMinusOne; ?>, <?php echo $avgToday; ?>],
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