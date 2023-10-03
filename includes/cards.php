<div class="container text-center">
  <div class="row row-cols-1 row-cols-md-3">

<?php 

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$today = date("Y-m-d");

$device_data = mysqli_query($db_connect, "select * from sensor");
$device_row = mysqli_fetch_array($device_data);
$device_cnt = mysqli_num_rows($device_data);

// Alle Sensoren ausgeben
$sql = "select * from sensor";
$result = $db_connect->query($sql)->fetch_all(MYSQLI_ASSOC);

foreach ($result as $row){
  $row_device_id = $row['dev_id'];
  // Sensor-Daten abfragen
  $sensor_data = mysqli_query($db_connect, "select * from data where dev_id='$row_device_id' order by id DESC limit 2");
  $sensor_row = mysqli_fetch_array($sensor_data);

  ?>
  <div class="col-sm-6 md-4 mb-3">
    <div class="card ">
      <div class="card-header"><?php echo $row['dev_type'];?></div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $row['dev_place'];?></h5>
          <p class="card-text"><?php echo $sensor_row['dev_value_2'];?> Grad Celsius</p>
          <p class="card-text"><?php echo $sensor_row['dev_value_3'];?> % Luftfeuchtigkeit</p>
      </div>
      <div class="card-footer">
        <small class="text-body-secondary">Letztes Update <?php echo $sensor_row["datetime"]; ?></small>
      </div>
    </div>
  </div>
<?php 
}
?>

  </div>
</div>