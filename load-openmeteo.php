<?php 

require 'config.php';

$url = "https://api.open-meteo.com/v1/forecast?latitude=47.0321&longitude=8.4322&hourly=temperature_2m,relative_humidity_2m&forecast_days=1";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);

//$result = file_get_contents($url);
curl_close($curl);
// Will dump a beauty json :3
$values = json_decode($resp, true);
$time = $values["hourly"]["time"];
$temperature = $values["hourly"]["temperature_2m"];
$humidity = $values["hourly"]["relative_humidity_2m"];

$arrLength = count($time);
$sql = "";

// Create connection
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

for ($i = 0; $i < $arrLength; $i++) {
    $sql = ("INSERT INTO data_openmeteo (id, datetime, temperature, humidity) VALUES (NULL, '".$time[$i]."', '".$temperature[$i]."', '".$humidity[$i]."');");
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
}
$conn->close();
?>