<?php
function drawChart() {
$today = date("Y-m-d");
$todayMinusOne = date("Y-m-d", strtotime("-1 days"));
$todayMinusTwo = date("Y-m-d", strtotime("-2 days"));
$todayMinusThree = date("Y-m-d", strtotime("-3 days"));
$todayMinusFour = date("Y-m-d", strtotime("-4 days"));
$todayMinusFive = date("Y-m-d", strtotime("-5 days"));
$todayMinusSix = date("Y-m-d", strtotime("-6 days"));

$today_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$today%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($today_Data_temp);
$avgToday_temp = $mysql_row["average"];
$today_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$today%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($today_Data_humidity);
$avgToday_humidity = $mysql_row["average"];

$todayMinusOne_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusOne%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusOne_Data_temp);
$avgTodayMinusOne_temp = $mysql_row["average"];
$todayMinusOne_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$todayMinusOne%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusOne_Data_humidity);
$avgTodayMinusOne_humidity = $mysql_row["average"];

$todayMinusTwo_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusTwo%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusTwo_Data_temp);
$avgTodayMinusTwo_temp = $mysql_row["average"];
$todayMinusTwo_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$todayMinusTwo%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusTwo_Data_humidity);
$avgTodayMinusTwo_humidity = $mysql_row["average"];

$todayMinusThree_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusThree%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusThree_Data_temp);
$avgTodayMinusThree_temp = $mysql_row["average"];
$todayMinusThree_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$todayMinusThree%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusThree_Data_humidity);
$avgTodayMinusThree_humidity = $mysql_row["average"];

$todayMinusFour_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusFour%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusFour_Data_temp);
$avgTodayMinusFour_temp = $mysql_row["average"];
$todayMinusFour_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$todayMinusFour%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusFour_Data_humidity);
$avgTodayMinusFour_humidity = $mysql_row["average"];

$todayMinusFive_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusFive%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusFive_Data_temp);
$avgTodayMinusFive_temp = $mysql_row["average"];
$todayMinusFive_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$todayMinusFive%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusFive_Data_humidity);
$avgTodayMinusFive_humidity = $mysql_row["average"];

$todayMinusSix_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as average FROM data where ttn_timestamp like '$todayMinusSix%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusSix_Data_temp);
$avgTodayMinusSix_temp = $mysql_row["average"];
$todayMinusSix_Data_humidity = mysqli_query($db_connect, "SELECT round(avg(dev_value_3), 2) as average FROM data where ttn_timestamp like '$todayMinusSix%' and dev_id='eui-a8404181f186f808'");
$mysql_row = mysqli_fetch_array($todayMinusSix_Data_humidity);
$avgTodayMinusSix_humidity = $mysql_row["average"];

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
        data: [<?php echo $avgTodayMinusSix_temp; ?>, <?php echo $avgTodayMinusFive_temp; ?>, <?php echo $avgTodayMinusFour_temp; ?>, <?php echo $avgTodayMinusThree_temp; ?>, <?php echo $avgTodayMinusTwo_temp; ?>, <?php echo $avgTodayMinusOne_temp; ?>, <?php echo $avgToday_temp; ?>],
        borderWidth: 1
      }, 
      {
        label: 'Durchschnitt Luftfeuchtigkeit',
        data: [<?php echo $avgTodayMinusSix_humidity; ?>, <?php echo $avgTodayMinusFive_humidity; ?>, <?php echo $avgTodayMinusFour_humidity; ?>, <?php echo $avgTodayMinusThree_humidity; ?>, <?php echo $avgTodayMinusTwo_humidity; ?>, <?php echo $avgTodayMinusOne_humidity; ?>, <?php echo $avgToday_humidity; ?>],
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
}


?>