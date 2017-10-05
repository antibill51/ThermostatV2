<?php
$handle = fopen("/sys/bus/w1/devices/w1_bus_master1/w1_master_slaves", "r");
if ($handle) {
    while (($sensors = fgets($handle)) !== false) {
           $sensor = "/sys/bus/w1/devices/".trim($sensors)."/w1_slave";
           $sensorhandle = fopen($sensor, "r");
             if ($sensorhandle) {
                 $thermometerReading = fread($sensorhandle, filesize($sensor));
                 fclose($sensorhandle);
                 // We want the value after the t= on the 2nd line
                 preg_match("/t=(.+)/", preg_split("/\n/", $thermometerReading)[1], $matches);
                 $celsius = round($matches[1]/1000,1); //round the results
                 print "Sensor ID#: $sensors = $celsius &deg;C <br>";
                 $sensors++;
             } else {
                print "No motherfucking temperature read!";
             }
    }
    fclose($handle);
} else {
    print "No motherfucking sensors found!";
}
?>
