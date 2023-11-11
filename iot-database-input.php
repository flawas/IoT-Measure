<?php
/*
 *  Version 1.1
 *  Created 2020-NOV-27
 *  Update 2021-OCT-11
 *  https://wwww.aeq-web.com
 */

require 'config.php';
include_once("includes/functions.php");

//$ttn_post = file('php://input');
//$data = json_decode($ttn_post[0]);

$ttn_post = file_get_contents('ttn.json');
$data = json_decode($ttn_post, true);


$join_eui = $data[0]['device_ids']['join_eui'];
$sensor_temperature = 0;
$sensor_humidity = 0;
$sensor_temperature_2 = 0;

if($join_eui == "A000000000000101") {
    
    $sensor_temperature = $data['uplink_message']['decoded_payload']['TempC1'];

    $sensor_battery = $data['uplink_message']['decoded_payload']['BatV'];
    $sensor_raw_payload = $data['uplink_message']['frm_payload'];
    $gtw_id = $data['uplink_message']['rx_metadata'][0]['gateway_ids']['gateway_id'];
    $gtw_rssi = $data['uplink_message']['rx_metadata'][0]['rssi'];
    $gtw_snr = $data['uplink_message']['rx_metadata'][0]['snr'];
    $ttn_app_id = $data['uplink_message']['rx_metadata'][0]['snr'];
    $ttn_app_id = $data['end_device_ids']['application_ids']['application_id'];
    $ttn_dev_id = $data['end_device_ids']['device_id'];
    $ttn_time = $data['received_at'];
}

if($join_eui == "A000000000000100") {
    $sensor_temperature = $data['data']['uplink_message']['decoded_payload']['TempC_SHT'];
    $sensor_humidity = $data['data']['uplink_message']['decoded_payload']['Hum_SHT'];
    $sensor_temperature_2 = $data['data']['uplink_message']['decoded_payload']['TempC_DS'];

    $sensor_battery = $data['data']['uplink_message']['decoded_payload']['BatV'];
    $sensor_raw_payload = $data['data']['uplink_message']['frm_payload'];
    $gtw_id = $data['data']['uplink_message']['rx_metadata'][0]['gateway_ids']['gateway_id'];
    $gtw_rssi = $data['data']['uplink_message']['rx_metadata'][0]['rssi'];
    $gtw_snr = $data['data']['uplink_message']['rx_metadata'][0]['snr'];
    $ttn_app_id = $data['data']['uplink_message']['rx_metadata'][0]['snr'];
    $ttn_app_id = $data['data']['end_device_ids']['application_ids']['application_id'];
    $ttn_dev_id = $data['data']['end_device_ids']['device_id'];
    $ttn_time = $data['data']['received_at'];
}

$server_datetime = date("Y-m-d H:i:s");

$sql = ("INSERT INTO `data` (`id`, `datetime`, `app_id`, `dev_id`, `ttn_timestamp`, `gtw_id`, `gtw_rssi`,"
. " `gtw_snr`, `dev_raw_payload`, `dev_value_1`, `dev_value_2`, `dev_value_3`, `dev_value_4`) "
. "VALUES (NULL, '$server_datetime', '$ttn_app_id', '$ttn_dev_id', '$ttn_time', '$gtw_id', '$gtw_rssi', '$gtw_snr',"
. " '$sensor_raw_payload', '$sensor_temperature', '$sensor_temperature_2', '$sensor_humidity', '$sensor_battery');");

echo $sql;
$db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

if ($db_connect->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

if (WRITE_LOG == true) {
    file_put_contents('log.txt', $ttn_post[0] . PHP_EOL, FILE_APPEND);
}

if(SLACK_ENABLED == TRUE) {
    dbInputSlackNotification($ttn_dev_id, $sensor_humidity, $sensor_temperature, $sensor_temperature_2);
}
?>