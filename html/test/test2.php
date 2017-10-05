<?php
set_time_limit(0);
putenv('GDFONTPATH=' . realpath('.'));
// appel du script de connexion
require("mysql_connect.php");
// On récupère le timestamp du dernier enregistrement
$sql="select max(`Date`) from Temperature";
$query=mysql_query($sql);
$list=mysql_fetch_array($query);
// On détermine le stop et le start de façon à récupérer dans la prochaine requête que les données des dernières xx heures
$stop=$list[0];
$start=$stop-(86400*0.1);




//



$classPath = '../lib/pChart2.1.4/';
include($classPath.'/class/pData.class.php');
include($classPath.'/class/pDraw.class.php');
include($classPath.'/class/pImage.class.php');




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
$myData = new pData();



$SensorList = SensorList(); // renvoi id et designation
for ($i = 0; $i < sizeof($SensorList); $i++) { // pour le nombre de sondes on fait
$Fetch24HData = Fetch24HData($SensorList[$i]['sensor_id']);


//${'Designation'.['sensor_id']} = 'Temperature '.$SensorList[$i]['Designation'];
//${'Temperature'.['sensor_id']} = json_encode($Fetch24HData['Temperature']);
//${'Date'.['sensor_id']} = json_encode($Fetch24HData['Date']);

//${'Designation'.$SensorList[$i]} = 'Temperature '.$SensorList[$i]['Designation'];
//${'Temperature'.$SensorList[$i]} = json_encode($Fetch24HData['Temperature']);
//${'Date'.$SensorList[$i]} = json_encode($Fetch24HData['Date']);


//
$myData->addPoints($Fetch24HData['Temperature'],$SensorList[$i]['sensor_id']);
$myData->setSerieDescription($SensorList[$i]['sensor_id'],"Température ".$SensorList[$i]['Designation']);
$myData->setSerieOnAxis($SensorList[$i]['sensor_id'],0);




 }
for ($i = 0; $i < sizeof($SensorList); $i++) {
//echo ${'Designation'.$SensorList[$i]};
//echo ${'Temperature'.$SensorList[$i]};
//echo ${'Date'.$SensorList[$i]};
//echo $Temperature[$i];
 }


//
$myData->addPoints($Fetch24HData['Date'],"Absissa");
$myData->setAbscissa("Absissa");
 
 
$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
$myData->setAxisName(0,"Temp&eacute;ratures");
$myData->setAxisUnit(0,"°C");
 
$myPicture = new pImage(1000,400,$myData);
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>20));
 
$myPicture->setFontProperties(array("FontName"=>"Forgotte.ttf","FontSize"=>18));
$TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE
, "R"=>0, "G"=>0, "B"=>0);
$myPicture->drawText(500,25,"Températures",$TextSettings);
 
$myPicture->setShadow(FALSE);
$myPicture->setGraphArea(75,50,975,360);
$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"Bedizen.ttf","FontSize"=>10));
 
$Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
, "Mode"=>SCALE_MODE_FLOATING
, "LabelingMethod"=>LABELING_ALL
, "GridR"=>255, "GridG"=>255, "GridB"=>255, "GridAlpha"=>50, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50, "LabelRotation"=>0, "CycleBackground"=>1, "DrawXLines"=>1, "DrawSubTicks"=>1, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50, "DrawYLines"=>ALL);
$myPicture->drawScale($Settings);
 
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>10));
 
$Config = "";
$myPicture->drawSplineChart($Config);
 
$Config = array("FontR"=>0, "FontG"=>0, "FontB"=>0, "FontName"=>"Forgotte.ttf", "FontSize"=>12, "Margin"=>6, "Alpha"=>30, "BoxSize"=>5, "Style"=>LEGEND_NOBORDER
, "Mode"=>LEGEND_HORIZONTAL
, "Family"=>LEGEND_FAMILY_LINE
);
$myPicture->drawLegend(540,66,$Config);
 
$myPicture->stroke();
?>
