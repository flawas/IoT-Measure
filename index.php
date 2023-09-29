<?php
/*
 *  Version 1.1
 *  Created 2020-NOV-27
 *  Update 2021-OCT-11
 *  https://wwww.aeq-web.com
 */

require 'config.php';

$db_connect = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME) or die(mysql_error());
$sel_data = mysqli_query($db_connect, "SELECT * FROM `data` ORDER BY `data`.`id` DESC");

$mysql_row = mysqli_fetch_array($sel_data);
$row_cnt = mysqli_num_rows($sel_data);

$dev_name = $mysql_row["dev_id"];
$datetime = $mysql_row["datetime"];
$gateway = $mysql_row["gtw_id"];
$rssi = $mysql_row["gtw_rssi"];
$temperature = $mysql_row["dev_value_1"];
$humidity = $mysql_row["dev_value_3"];
$battery = $mysql_row["dev_value_4"];

if ($row_cnt > 0) {
    $show_table = "";
} else {
    $show_table = "display: none;";
    echo 'Error: No values in database!';
}

?>
<html>
    <head>
        <style>
            #ttnvalues {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 400px;
                text-align: center;
            }

            #ttnvalues td, #ttnvalues th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #ttnvalues tr:nth-child(even){background-color: #f2f2f2;}

            #ttnvalues tr:hover {background-color: #ddd;}

            #ttnvalues th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                background-color: #6699ff;
                color: white;
            }
        </style>
    </head>
    <body>

        <table id="ttnvalues" style="<?php echo $show_table; ?>">
            <tr>
                <th><?php echo $dev_name; ?></th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Time</td>
                <td><?php echo $datetime; ?></td>
            </tr>
            <tr>
                <td>Temperature</td>
                <td><?php echo $temperature; ?> &deg;C</td>
            </tr>
            <tr>
                <td>Humidity</td>
                <td><?php echo $humidity; ?> %</td>
            </tr>
            <tr>
                <td>Battery</td>
                <td><?php echo $battery; ?> V</td>
            </tr>
            <tr>
                <td>Gateway</td>
                <td><?php echo $gateway; ?></td>
            </tr>
            <tr>
                <td>RSSI</td>
                <td><?php echo $rssi; ?></td>
            </tr>
        </table>
    </body>
</html>