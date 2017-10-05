<?php
// appel du script de connexion
require("mysql_connect.php");
// On récupère le timestamp du dernier enregistrement
$sql="select max(`Date`) from Temperature";
$query=mysql_query($sql);
$list=mysql_fetch_array($query);
// On détermine le stop et le start de façon à récupérer dans la prochaine requête que les données des dernières xx heures
$stop=$list[0];
$start=$stop-(86400*2);

// Liste sonde/designation


function SensorList($type=null) {
 $SensorList = array();
 $cpt = 0;
 $req_list = "SELECT * FROM Sondes ORDER BY Id ASC";
 $qur_owlist = mysql_query($req_list) or die(mysql_error());
 while($dat_list = mysql_fetch_array($qur_owlist)) {
 $SensorList[$cpt]['sensor_id'] = $dat_list['Id'];
 $SensorList[$cpt]['Designation'] = $dat_list['Designation'];
 $cpt++;
 }
 return $SensorList;


}

// Recuperation données d un capteur 

function Fetch24HData($sensor_id) {
 global $start, $stop;
 $Fetch24HData = array();
 $cpt = 0;
$req_list = "SELECT * FROM `Temperature` WHERE `Id` = ".$sensor_id." AND `Date` >= '$start' AND `Date` <= '$stop' ORDER BY `Id` ASC";
 $qur_list = mysql_query($req_list) or die(mysql_error());
 while($dat_list = mysql_fetch_array($qur_list)) {
 $Fetch24HData['Date'][$cpt] = $dat_list['Date'];
 $Fetch24HData['Temperature'][$cpt] = $dat_list['Temperature'];
$cpt++;
 }
 return $Fetch24HData;
}




//

$SensorList = SensorList(); // renvoi id et designation
for ($i = 0; $i < sizeof($SensorList); $i++) { // pour le nombre de sondes on fait
$Fetch24HData = Fetch24HData($SensorList[$i]['sensor_id']);


//${'Designation'.['sensor_id']} = 'Temperature '.$SensorList[$i]['Designation'];
//${'Temperature'.['sensor_id']} = json_encode($Fetch24HData['Temperature']);
//${'Date'.['sensor_id']} = json_encode($Fetch24HData['Date']);

${'Designation'.$SensorList[$i]['sensor_id']} = 'Temperature '.$SensorList[$i]['Designation'];
${'Temperature'.$SensorList[$i]['sensor_id']} = json_encode($Fetch24HData['Temperature']);
${'Date'.$SensorList[$i]['sensor_id']} = json_encode($Fetch24HData['Date']);

 }
for ($i = 0; $i < sizeof($SensorList); $i++) {
echo ${'Designation'.$SensorList[$i]['sensor_id']};
echo ${'Temperature'.$SensorList[$i]['sensor_id']};
echo ${'Date'.$SensorList[$i]['sensor_id']};
//echo $Temperature[$i];
 }


 ?>


