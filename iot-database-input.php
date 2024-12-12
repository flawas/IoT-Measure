<?php
/*
 *  Version 1.1
 *  Created 2020-NOV-27
 *  Update 2021-OCT-11
 *  https://wwww.aeq-web.com
 */

require 'config.php';
include_once("includes/functions.php");

$ttn_post = file_get_contents('php://input');
$data = json_decode($ttn_post);

$uplink_message = $data->data->uplink_message;
$end_device_ids = $data->data->end_device_ids;

$sensor_battery = $uplink_message->decoded_payload->BatV ?? null;
$sensor_raw_payload = $uplink_message->frm_payload;
$gtw_id = $uplink_message->rx_metadata[0]->gateway_ids->gateway_id;
$gtw_rssi = $uplink_message->rx_metadata[0]->rssi;
$gtw_snr = $uplink_message->rx_metadata[0]->snr;

$ttn_app_id = $end_device_ids->application_ids->application_id;
$ttn_dev_id = $end_device_ids->device_id;
$ttn_time = $uplink_message->received_at;

$sensor_temperature = 0;
$sensor_humidity = 0;
$sensor_temperature_2 = 0;
$sensor_soilMoisture = 0;

if ($end_device_ids->join_eui == 'A000000000000101') {
    $sensor_temperature = $uplink_message->decoded_payload->TempC1;
}

if ($end_device_ids->join_eui == 'A000000000000100') {
    $sensor_temperature = $uplink_message->decoded_payload->TempC_SHT;
    $sensor_humidity = $uplink_message->decoded_payload->Hum_SHT;
    $sensor_temperature_2 = $uplink_message->decoded_payload->TempC_DS;
}

if ($end_device_ids->join_eui == '0000000000000000') {
    $sensor_temperature = $uplink_message->decoded_payload->temperature;
    $sensor_humidity = $uplink_message->decoded_payload->humidity;
    $sensor_soilMoisture = $uplink_message->decoded_payload->soilMoisture;
}

$server_datetime = date("Y-m-d H:i:s");

$sql = "INSERT INTO `data` (`datetime`, `app_id`, `dev_id`, `ttn_timestamp`, `gtw_id`, `gtw_rssi`, `gtw_snr`, `dev_raw_payload`, `dev_value_1`, `dev_value_2`, `dev_value_3`, `dev_value_4`, `dev_value_5`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if ($db_connect->connect_error) {
    die("Connection failed: " . $db_connect->connect_error);
}

$stmt = $db_connect->prepare($sql);
$stmt->bind_param("sssssssssssss", $server_datetime, $ttn_app_id, $ttn_dev_id, $ttn_time, $gtw_id, $gtw_rssi, $gtw_snr, $sensor_raw_payload, $sensor_temperature, $sensor_temperature_2, $sensor_humidity, $sensor_battery, $sensor_soilMoisture);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$db_connect->close();

if (getConfig('LogEnabled') == 1) {
    file_put_contents('sqllog.txt', $sql . PHP_EOL, FILE_APPEND);
    file_put_contents('log.txt', $ttn_post . PHP_EOL, FILE_APPEND);
}
?>