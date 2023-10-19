<h1>Senor hinzufügen</h1>
<form method='POST' action='includes/device-add-function.php'>
  <div class="form-group">
    <input type="text" class="form-control" id="endDeviceID" placeholder="eui-a8404181f186a539" name="endDeviceID">
    <label for="endDeviceID" class="form-text">End device ID</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="endDevicePlace" placeholder="Blauweidweg, Waschküche" name="endDevicePlace">
    <label for="endDevicePlace" class="form-text">Sensor Ort</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="endDeviceType" placeholder="Temperatursensor" name="endDeviceType">
    <label for="endDeviceType" class="form-text">Senor Typ</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="endDeviceManufacturer" placeholder="dragino" name="endDeviceManufacturer">
    <label for="endDeviceManufacturer" class="form-text">Sensor Marke</label>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="endDeviceModel" placeholder="lht65" name="endDeviceModel">
    <label for="endDeviceModel" class="form-text">Sensor Modell</label>
  </div>
  <br>
  <div class="form-group">
    <button type="submit" class="btn btn-outline-primary">Sensor erstellen</button>
  </div>
  
</form>