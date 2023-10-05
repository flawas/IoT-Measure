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
    </div>
    <div class="col-2">
      <input class="btn btn-secondary" type='submit' name="submit" value='Anzeigen'>
    </div>
  </div>
  </form>
</div>


<div>
  <canvas id="chartDaily"></canvas>
</div>


<?php

$dev_id = $_GET['device-select'];

$today = date("Y-m-d");
$avgTemp = array();
$avgHumidity = array();
$hours = array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "17", "18", "19", "20", "21", "22", "23");


foreach($hours as $hour){
    $searchLike = $today." ".$hour."%";
    $avgTempHour = mysqli_query($db_connect, "SELECT round(avg(dev_value_2),2) as avg_temp, round(avg(dev_value_3),2) as avg_hum FROM data where datetime like '$searchLike' and dev_id='$dev_id'");
    $mysql_row = mysqli_fetch_array($avgTempHour);

    $avgTemp[$hour] = $mysql_row["avg_temp"];
    $avgHumidity[$hour] = $mysql_row["avg_hum"];
}

?>


<script>

  const ctx = document.getElementById('chartDaily');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
      datasets: [{
        label: 'Durchschnitt Temperatur',
        data: [<?php echo $avgTemp['00'] ; ?>, <?php echo $avgTemp['01']; ?>, <?php echo $avgTemp['02']; ?>, <?php echo $avgTemp['03']; ?>, <?php echo $avgTemp['04']; ?>, <?php echo $avgTemp['05']; ?>, <?php echo $avgTemp['06'] ?>, <?php echo $avgTemp['07'] ?>, <?php echo $avgTemp['08'] ?>, <?php echo $avgTemp['09'] ?>, <?php echo $avgTemp['10'] ?>
        , <?php echo $avgTemp['11'] ?>, <?php echo $avgTemp['12'] ?>, <?php echo $avgTemp['13'] ?>, <?php echo $avgTemp['14'] ?>, <?php echo $avgTemp['15'] ?>, <?php echo $avgTemp['16'] ?>, <?php echo $avgTemp['17'] ?>, <?php echo $avgTemp['18'] ?>, <?php echo $avgTemp['19'] ?>, <?php echo $avgTemp['20'] ?>
        , <?php echo $avgTemp['21'] ?>, <?php echo $avgTemp['22'] ?>, <?php echo $avgTemp['23'] ?>],
        borderWidth: 1
      }, 
      {
        label: 'Durchschnitt Luftfeuchtigkeit',
        data: [<?php echo $avgHumidity['00'] ; ?>, <?php echo $avgHumidity['01']; ?>, <?php echo $avgHumidity['02']; ?>, <?php echo $avgHumidity['03']; ?>, <?php echo $avgHumidity['04']; ?>, <?php echo $avgHumidity['05']; ?>, <?php echo $avgHumidity['06'] ?>, <?php echo $avgHumidity['07'] ?>, <?php echo $avgHumidity['08'] ?>, <?php echo $avgHumidity['09'] ?>, <?php echo $avgHumidity['10'] ?>
        , <?php echo $avgHumidity['11'] ?>, <?php echo $avgHumidity['12'] ?>, <?php echo $avgHumidity['13'] ?>, <?php echo $avgHumidity['14'] ?>, <?php echo $avgHumidity['15'] ?>, <?php echo $avgHumidity['16'] ?>, <?php echo $avgHumidity['17'] ?>, <?php echo $avgHumidity['18'] ?>, <?php echo $avgHumidity['19'] ?>, <?php echo $avgHumidity['20'] ?>
        , <?php echo $avgHumidity['21'] ?>, <?php echo $avgHumidity['22'] ?>, <?php echo $avgHumidity['23'] ?>],
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