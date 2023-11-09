<?php
/*
 *  Version 1.1
 *  Created 2020-NOV-27
 *  Update 2021-OCT-11
 *  https://wwww.aeq-web.com
 */

require 'config.php';
include_once("includes/functions.php");

$ttn_post = file('php://input');
$data = json_decode($ttn_post[0]);

$sensor_temperature = $data->uplink_message->decoded_payload->TempC_SHT;
$sensor_humidity = $data->uplink_message->decoded_payload->Hum_SHT;
$sensor_temperature_2 = $data->uplink_message->decoded_payload->TempC_DS;
$sensor_battery = $data->uplink_message->decoded_payload->BatV;
$sensor_raw_payload = $data->uplink_message->frm_payload;

$gtw_id = $data->uplink_message->rx_metadata[0]->gateway_ids->gateway_id;
$gtw_rssi = $data->uplink_message->rx_metadata[0]->rssi;
$gtw_snr = $data->uplink_message->rx_metadata[0]->snr;
$ttn_app_id = $data->end_device_ids->application_ids->application_id;
$ttn_dev_id = $data->end_device_ids->device_id;
$ttn_time = $data->received_at;

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$server_datetime = date("Y-m-d H:i:s");

mysqli_query($db_connect, "INSERT INTO `data` (`id`, `datetime`, `app_id`, `dev_id`, `ttn_timestamp`, `gtw_id`, `gtw_rssi`,"
        . " `gtw_snr`, `dev_raw_payload`, `dev_value_1`, `dev_value_2`, `dev_value_3`, `dev_value_4`) "
        . "VALUES (NULL, '$server_datetime', '$ttn_app_id', '$ttn_dev_id', '$ttn_time', '$gtw_id', '$gtw_rssi', '$gtw_snr',"
        . " '$sensor_raw_payload', '$sensor_temperature', '$sensor_temperature_2', '$sensor_humidity', '$sensor_battery');
");

if (WRITE_LOG == true) {
    file_put_contents('log.txt', $ttn_post[0] . PHP_EOL, FILE_APPEND);
}

if(SLACK_ENABLED == TRUE) {
    dbInputSlackNotification($ttn_dev_id, $sensor_humidity, $sensor_temperature, $sensor_temperature_2);
}
?>