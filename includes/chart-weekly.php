<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php 

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$devices = mysqli_query($db_connect, "Select * from sensor");

?>
<div class="container text-center">
<form method='GET'>
  <div class="row">
    <div class="col-10">
    <select class="form-select" name="device-select">
      <?php
      foreach ($devices as $row){
          ?><option name="device" value="<?php echo $row['dev_id']; ?>"><?php echo $row['dev_place']; ?></option><?php 
      }
      ?>
    </select>
    <label for="device-select" class="form-text">Sensor</label>
    </div>
    <div class="col-2">
      <input class="btn btn-secondary" type='submit' name="submit" value='Anzeigen'>
    </div>
  </div>
  </form>
</div>


<div>
  <canvas id="myChart"></canvas>
</div>

<?php

$dev_id = $_GET['device-select'];

$today = date("Y-m-d");
$todayMinusOne = date("Y-m-d", strtotime("-1 days"));
$todayMinusTwo = date("Y-m-d", strtotime("-2 days"));
$todayMinusThree = date("Y-m-d", strtotime("-3 days"));
$todayMinusFour = date("Y-m-d", strtotime("-4 days"));
$todayMinusFive = date("Y-m-d", strtotime("-5 days"));
$todayMinusSix = date("Y-m-d", strtotime("-6 days"));

$today_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$today%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($today_Data_temp);
$avgToday_temp = $mysql_row["avg_temp"];
$avgToday_humidity = $mysql_row["avg_hum"];

$todayMinusOne_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$todayMinusOne%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($todayMinusOne_Data_temp);
$avgTodayMinusOne_temp = $mysql_row["avg_temp"];
$avgTodayMinusOne_humidity = $mysql_row["avg_hum"];

$todayMinusTwo_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$todayMinusTwo%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($todayMinusTwo_Data_temp);
$avgTodayMinusTwo_temp = $mysql_row["avg_temp"];
$avgTodayMinusTwo_humidity = $mysql_row["avg_hum"];

$todayMinusThree_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$todayMinusThree%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($todayMinusThree_Data_temp);
$avgTodayMinusThree_temp = $mysql_row["avg_temp"];
$avgTodayMinusThree_humidity = $mysql_row["avg_hum"];

$todayMinusFour_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$todayMinusThree%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($todayMinusFour_Data_temp);
$avgTodayMinusFour_temp = $mysql_row["avg_temp"];
$avgTodayMinusFour_humidity = $mysql_row["avg_hum"];

$todayMinusFive_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$todayMinusFive%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($todayMinusFive_Data_temp);
$avgTodayMinusFive_temp = $mysql_row["avg_temp"];
$avgTodayMinusFive_humidity = $mysql_row["avg_hum"];

$todayMinusSix_Data_temp = mysqli_query($db_connect, "SELECT round(avg(dev_value_2), 2) as avg_temp, round(avg(dev_value_3), 2) as avg_hum FROM data where ttn_timestamp like '$todayMinusSix%' and dev_id='$dev_id'");
$mysql_row = mysqli_fetch_array($todayMinusSix_Data_temp);
$avgTodayMinusSix_temp = $mysql_row["avg_temp"];
$avgTodayMinusSix_humidity = $mysql_row["avg_hum"];

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