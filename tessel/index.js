var tessel = require('tessel');
var ble = require('ble-ble113a').use(tessel.port.A);
var devices = {};
var allowedDevices = ["182.212.223.35.22.207"];

ble.on('ready', function() {
  startScan();
});

ble.on('discover', function(peripheral) {
  if(allowedDevices.indexOf(peripheral.address._str) > -1)
    devices[peripheral.address._str] = peripheral.rssi;
});

function startScan(){
  //console.log("Scanning...");
  ble.startScanning();
  setTimeout(stopScan, 2000);
}

function stopScan(){
  //console.log("Stopping...");
  ble.stopScanning();
  for(var entry in devices){
    console.log(entry+":"+devices[entry]);
  }
  startScan();
}
