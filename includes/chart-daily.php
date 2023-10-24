<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<?php 

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$devices = mysqli_query($db_connect, "Select * from sensor");

?>
<div class="container text-center">
<form method='GET' onsubmit="return checkInput()">
  <div class="row">
    <div class="col-2">
        <input type="date" class="form-control" id="date" name="date" value="">
        <label for="date" class="form-text">Datum</label>
    </div>
    <div class="col-8">
    <select class="form-select" name="device-select" id="device-select">
        <option name="choose" id="choose" value="choose" >Bitte wählen</option>
      <?php
      foreach ($devices as $row){
          ?><option name="<?php echo $row['dev_id']; ?>" value="<?php echo $row['dev_id']; ?>" id="<?php echo $row['dev_id']; ?>"><?php echo $row['dev_place']; ?></option><?php 
      }
      ?>
    </select>
    <label for="device-select" id="device-select-label"class="form-text">Sensor</label>
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
$today = $_GET['date'];

$query = mysqli_query($db_connect, "SELECT datetime, dev_value_2 as temp1, dev_value_1 as temp2, dev_value_3 as hum FROM data where datetime like '$today%' and dev_id='$dev_id'");
if (mysqli_num_rows($query) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($query)) {
    $temps1 = $temps1 . $row["temp1"] . ",";
    $temps2 = $temps2 . $row["temp2"] . ",";
    $hum = $hum . $row["hum"] . ",";
    $time = explode(" ",$row["datetime"]);
    $dates = $dates  ."'" . $time[1] . "'" . ",";
  }
}
$finaltemps1 =  rtrim($temps1, ", ");
$finaltemps2 =  rtrim($temps2, ", ");
$finalhum =  rtrim($hum, ", ");
$finaldates = rtrim($dates, ", ");
?>

<script>
function checkInput() {
    if(document.getElementById('device-select').value == "choose") {
        document.getElementById('device-select').setAttribute("class", "form-control is-invalid");
        document.getElementById('device-select-label').setAttribute("class", "invalid-feedback");
        document.getElementById('device-select-label').innerHTML = "Bitte Sensor auswählen";
        return false;
    }
    return true;
}



const urlParams = new URL(window.location.toLocaleString()).searchParams;
var date = urlParams.get('date');
var device = urlParams.get('device-select');
if(date != null) {
    document.getElementById('date').value = date;
} else {
    document.getElementById('date').valueAsDate = new Date();
}
if(device != null) {
    document.getElementById(device).setAttribute('selected', 'selected');
} else {
    document.getElementById('choose').setAttribute('selected', 'selected');
}

  const ctx = document.getElementById('chartDaily');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?php echo $finaldates; ?>],
      datasets: [{
        label: 'Temperatur 1',
        data: [<?php echo $finaltemps1;?>],
        borderWidth: 1
      },{
        label: 'Temperatur 2',
        data: [<?php echo $finaltemps2;?>],
        borderWidth: 1
      }, {
        label: 'Luftfeuchtigkeit',
        data: [<?php echo $finalhum;?>],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      x: {
        type: 'time',
        time: {
          // Luxon format string
          tooltipFormat: 'H:mm'
        },
      }, scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  });
</script>