<?php 

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$today = date("Y-m-d");
$sel_data = mysqli_query($db_connect, "select * from data where ttn_timestamp like '$today%' and dev_id='eui-a8404181f186f808' order by id DESC");
$mysql_row = mysqli_fetch_array($sel_data);
$row_cnt = mysqli_num_rows($sel_data);

$dev_name = $mysql_row["dev_id"];
$datetime = $mysql_row["datetime"];
$gateway = $mysql_row["gtw_id"];
$rssi = $mysql_row["gtw_rssi"];
$temperature = $mysql_row["dev_value_2"];
$humidity = $mysql_row["dev_value_3"];
$battery = $mysql_row["dev_value_4"];

if ($row_cnt > 0) {
    $show_table = "";
} else {
    $show_table = "display: none;";
    echo 'Error: No values in database!';
}

?>


<div class="card text-bg-light mb-3" style="max-width: 18rem;">
  <div class="card-header">Waschküche</div>
  <div class="card-body">
    <p class="card-text"><?php echo $datetime;?></p>
    <p class="card-text"><?php echo $temperature;?> Grad Celsius</p>
    <p class="card-text"><?php echo $humidity;?> % Luftfeuchtigkeit</p>
  </div>
</div>