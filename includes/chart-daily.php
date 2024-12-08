<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<?php

$db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if ($db_connect->connect_error) {
    die("Connection failed: " . $db_connect->connect_error);
}

$devices = $db_connect->query("SELECT * FROM sensor");

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
                    <option name="choose" id="choose" value="choose">Bitte wählen</option>
                    <?php
                    while ($row = $devices->fetch_assoc()) {
                        ?><option name="<?php echo htmlspecialchars($row['dev_id']); ?>" value="<?php echo htmlspecialchars($row['dev_id']); ?>" id="<?php echo htmlspecialchars($row['dev_id']); ?>"><?php echo htmlspecialchars($row['dev_place']); ?></option><?php
                    }
                    ?>
                </select>
                <label for="device-select" id="device-select-label" class="form-text">Sensor</label>
            </div>
            <div class="col-2">
                <input class="btn btn-secondary" type='submit' name="submit" value='Anzeigen'>
            </div>
        </div>
    </form>
</div>

<script>
    const urlParams = new URL(window.location.toLocaleString()).searchParams;
    var date = urlParams.get('date');
    var device = urlParams.get('device-select');
    if (date != null) {
        document.getElementById('date').value = date;
    } else {
        document.getElementById('date').valueAsDate = new Date();
        location.href = location.href + "?date=" + new Date().toISOString().slice(0, 10);
    }
    if (device != null) {
        document.getElementById(device).setAttribute('selected', 'selected');
    } else {
        document.getElementById('choose').setAttribute('selected', 'selected');
    }
</script>

<div>
    <canvas id="chartDaily"></canvas>
</div>

<?php
$dev_id = $_GET['device-select'];
$today = $_GET['date'];

$query = $db_connect->prepare("SELECT datetime, dev_value_2 as temp1, dev_value_1 as temp2, dev_value_3 as hum, dev_value_5 as soil FROM data WHERE datetime LIKE ? AND dev_id=?");
$like_today = $today . '%';
$query->bind_param("ss", $like_today, $dev_id);
$query->execute();
$result = $query->get_result();

$temp1 = $temp2 = $hum = $soil = "";
while ($row = $result->fetch_assoc()) {
    $temp1  .= "{x: '" . $row["datetime"] . "', y: " . $row["temp1"] . "},";
    $temp2  .= "{x: '" . $row["datetime"] . "', y: " . $row["temp2"] . "},";
    $hum    .= "{x: '" . $row["datetime"] . "', y: " . $row["hum"] . "},";
    $soil   .= "{x: '" . $row["datetime"] . "', y: " . $row["soil"] . "},";
}
$finaltemps1 = rtrim($temp1, ", ");
$finaltemps2 = rtrim($temp2, ", ");
$finalhum = rtrim($hum, ", ");
$finalsoil = rtrim($soil, ", ");

$sensorvalues = $db_connect->prepare("SELECT * FROM sensor WHERE dev_id=?");
$sensorvalues->bind_param("s", $dev_id);
$sensorvalues->execute();
$sensorrow = $sensorvalues->get_result()->fetch_assoc();

$forecast = $db_connect->prepare("SELECT datetime, temperature as forecasttemp, humidity as forecasthum FROM data_openmeteo WHERE datetime LIKE ?");
$forecast->bind_param("s", $like_today);
$forecast->execute();
$forecast_result = $forecast->get_result();

$forecasttemp = $forecasthum = "";
while ($row = $forecast_result->fetch_assoc()) {
    $forecasttemp .= "{x: '" . $row["datetime"] . "', y: " . $row["forecasttemp"] . "},";
    $forecasthum .= "{x: '" . $row["datetime"] . "', y: " . $row["forecasthum"] . "},";
}
$finalforecasttemp = rtrim($forecasttemp, ", ");
$finalforecasthum = rtrim($forecasthum, ", ");

$query->close();
$sensorvalues->close();
$forecast->close();
$db_connect->close();
?>

<script>
    function checkInput() {
        if (document.getElementById('device-select').value == "choose") {
            document.getElementById('device-select').setAttribute("class", "form-control is-invalid");
            document.getElementById('device-select-label').setAttribute("class", "invalid-feedback");
            document.getElementById('device-select-label').innerHTML = "Bitte Sensor auswählen";
            return false;
        }
        return true;
    }

    const ctx = document.getElementById('chartDaily');
    const datasets = [];

    if ('<?php echo $finaltemps1; ?>' !== '') {
        datasets.push({
            label: '<?php echo htmlspecialchars($sensorrow['value_1_name']); ?>',
            data: [<?php echo $finaltemps1; ?>],
            borderWidth: 1,
        });
    }
    if ('<?php echo $finaltemps2; ?>' !== '') {
        datasets.push({
            label: '<?php echo htmlspecialchars($sensorrow['value_2_name']); ?>',
            data: [<?php echo $finaltemps2; ?>],
            borderWidth: 1,
        });
    }
    if ('<?php echo $finalhum; ?>' !== '') {
        datasets.push({
            label: '<?php echo htmlspecialchars($sensorrow['value_3_name']); ?>',
            data: [<?php echo $finalhum; ?>],
            borderWidth: 1,
        });
    }
    if ('<?php echo $finalsoil; ?>' !== '') {
        datasets.push({
            label: '<?php echo htmlspecialchars($sensorrow['value_5_name']); ?>',
            data: [<?php echo $finalsoil; ?>],
            borderWidth: 1,
        });
    }
    if ('<?php echo $finalforecasttemp; ?>' !== '') {
        datasets.push({
            label: 'Wettervorhersage Temperatur',
            data: [<?php echo $finalforecasttemp; ?>],
            borderWidth: 1,
        });
    }
    if ('<?php echo $finalforecasthum; ?>' !== '') {
        datasets.push({
            label: 'Wettervorhersage Luftfeuchtigkeit',
            data: [<?php echo $finalforecasthum; ?>],
            borderWidth: 1,
        });
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            datasets: datasets
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        displayFormats: {
                            hour: "HH:MM"
                        }
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 30,
                    },
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: "Point"
                    }
                },
                y: {
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: "Value"
                    }
                }
            }
        }
    });
</script>
