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
    <div class="col-2">
        <input type="number" class="form-control" id="numberOfLogs" name="numberOfLogs">
        <label for="numberOfLogs" class="form-text" max="100">Anzahl Log-Einträge</label>
    </div>
    <div class="col-4">
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


<?php
$dev_id = $_GET['device-select'];
$date = $_GET['date'];
$numberOfLogs = $_GET['numberOfLogs'];

$sqlResponses = mysqli_query($db_connect, "SELECT * FROM data where datetime like '$date%' and dev_id='$dev_id' order by id DESC LIMIT $numberOfLogs");

?>

<table class="table table-hover table-sm">
  <thead>
    <tr>
      <th>#</th>
      <th>DB Zeitstempel</th>
      <th>App ID</th>
      <th>TTN Zeitstempel</th>
      <th>Device ID</th>
      <th>Gateway ID</th>
      <th>Gateway RSSI</th>
      <th>Gateway SNR</th>
      <th>Device Raw Payload</th>
      <th>Device Value 1</th>
      <th>Device Value 2</th>
      <th>Device Value 3</th>
      <th>Device Value 4</th>
    </tr>
  </thead>
  <tbody>
    

<?php
foreach ($sqlResponses as $sqlResponse){
    ?> 
    <tr><th scope="row"><?php echo $sqlResponse['id'];?></th><td><?php echo $sqlResponse['app_id'];?></td><td><?php echo $sqlResponse['dev_id'];?></td><td><?php echo $sqlResponse['ttn_timestamp'];?></td><th><?php echo $sqlResponse['gtw_id'];?></th>
    <td><?php echo $sqlResponse['gtw_rssi'];?></td><td><?php echo $sqlResponse['gtw_snr'];?></td><td><?php echo $sqlResponse['dev_raw_payload'];?></td><th><?php echo $sqlResponse['dev_value_1'];?></th><td><?php echo $sqlResponse['dev_value_2'];?></td>
    <td><?php echo $sqlResponse['dev_value_2'];?></td><td><?php echo $sqlResponse['dev_value_3'];?></td><td><?php echo $sqlResponse['dev_value_4'];?></td></tr>
    <?php 
}

?>
    
    </tbody>
</table>

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
var numberOfLogs = urlParams.get('numberOfLogs');
var device = urlParams.get('device-select');
var date = urlParams.get('date');
if(date != null) {
    document.getElementById('date').value = date;
} else {
    document.getElementById('date').valueAsDate = new Date();
}
if(numberOfLogs != null) {
    document.getElementById('numberOfLogs').value = numberOfLogs;
} else {
    document.getElementById('numberOfLogs').value = 25;
}
if(device != null) {
    document.getElementById(device).setAttribute('selected', 'selected');
} else {
    document.getElementById('choose').setAttribute('selected', 'selected');
}
</script>   