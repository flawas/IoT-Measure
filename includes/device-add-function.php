
<?php 

require '../config.php';

// Create connection
$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());


$check = true;

if(!(isset($_POST['endDeviceID']))){
  $check = false;
}

if($_POST['endDeviceID'] == ""){
  $check = false;
}

if(!(isset($_POST['endDevicePlace']))){
  $check = false;
}

if($_POST['endDevicePlace'] == ""){
  $check = false;
}

if(!(isset($_POST['endDeviceType']))){
  $check = false;
}

if($_POST['endDeviceType'] == ""){
  $check = false;
}

if(!(isset($_POST['endDeviceManufacturer']))){
  $check = false;
}

if($_POST['endDeviceManufacturer'] == ""){
  $check = false;
}

if(!(isset($_POST['endDeviceModel']))){
  $check = false;
}

if($_POST['endDeviceModel'] == ""){
  $check = false;
}



if($check === TRUE) {


  $endDeviceID = $_POST['endDeviceID'];
  $endDevicePlace = $_POST['endDevicePlace'];
  $endDeviceType = $_POST['endDeviceType'];
  $endDeviceManufacturer = $_POST['endDeviceManufacturer'];
  $endDeviceModel = $_POST['endDeviceModel'];

  $sql = "INSERT INTO sensor (dev_id, dev_place, dev_type, dev_brand, dev_model)
  VALUES ('$endDeviceID', '$endDevicePlace', '$endDeviceType', '$endDeviceManufacturer', '$endDeviceModel')";

} else {
  header('Location: ../device-add.php?text=Fehler im Formular. Sensor wurde nicht hinzugefügt!&status=error');
  die();
}

if ($db_connect->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $db_connect->error;
  header('Location: ../device-add.php?text=Fehler, Sensor nicht hinzugefügt!&status=error');
  die();
}

$db_connect->close();

header('Location: ../device-add.php?text=Sensor erfolgreich hinzugefügt!&status=success');
die();

?>