<?php
/*****************************************************************************/
/*** File   : cron.php                                                     ***/
/*** Author : R.SYREK                                                      ***/
/*** WWW    : http://domotique-home.fr                                     ***/
/*** Note   : Cron file                                                    ***/
/*****************************************************************************/
include_once('config.inc.php');
$Conn = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($database, $Conn);
$regulier = mysql_query("SELECT `regulier` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$regulier = mysql_result($regulier,0);
$mensuel = mysql_query("SELECT `mensuel` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$mensuel = mysql_result($mensuel,0);
$annuel = mysql_query("SELECT `annuel` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$annuel = mysql_result($annuel,0);
//$annuel = date("d/m/Y", strtotime($annuel));
$info = mysql_query("SELECT `info` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$info = mysql_result($info,0);
$PushingBox = mysql_query("SELECT `PushingBox` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBox = mysql_result($PushingBox,0);
$PushingBoxTitre1 = mysql_query("SELECT `PushingBoxTitre1` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxTitre1 = mysql_result($PushingBoxTitre1,0);
$PushingBoxTitre1 = html_entity_decode($PushingBoxTitre1);
$PushingBoxTitre1 = urlencode($PushingBoxTitre1);
$PushingBoxMsg1 = mysql_query("SELECT `PushingBoxMsg1` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxMsg1 = mysql_result($PushingBoxMsg1,0);
$PushingBoxMsg1 = html_entity_decode($PushingBoxMsg1);
$PushingBoxMsg1 = urlencode($PushingBoxMsg1);
$PushingBoxTitre2 = mysql_query("SELECT `PushingBoxTitre2` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxTitre2 = mysql_result($PushingBoxTitre2,0);
$PushingBoxTitre2 = html_entity_decode($PushingBoxTitre2);
$PushingBoxTitre2 = urlencode($PushingBoxTitre2);
$PushingBoxMsg2 = mysql_query("SELECT `PushingBoxMsg2` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxMsg2 = mysql_result($PushingBoxMsg2,0);
$PushingBoxMsg2 = html_entity_decode($PushingBoxMsg2);
$PushingBoxMsg2 = urlencode($PushingBoxMsg2);
$PushingBoxTitre3 = mysql_query("SELECT `PushingBoxTitre3` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxTitre3 = mysql_result($PushingBoxTitre3,0);
$PushingBoxTitre3 = html_entity_decode($PushingBoxTitre3);
$PushingBoxTitre3 = urlencode($PushingBoxTitre3);
$PushingBoxMsg3 = mysql_query("SELECT `PushingBoxMsg3` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxMsg3 = mysql_result($PushingBoxMsg3,0);
$PushingBoxMsg3 = html_entity_decode($PushingBoxMsg3);
$PushingBoxMsg3 = urlencode($PushingBoxMsg3);

$maintenant = time();
$maintenant = date ("Y-m-d", time());

if ($info==1){
if ($maintenant==$regulier){
$url = "http://api.pushingbox.com/pushingbox?devid=$PushingBox&titre=$PushingBoxTitre1&msg=$PushingBoxMsg1";
$ch = curl_init($url);
curl_exec ($ch);
curl_close ($ch);
}

if ($maintenant==$mensuel){
$ch = curl_init("http://api.pushingbox.com/pushingbox?devid=$PushingBox&titre=$PushingBoxTitre2&msg=$PushingBoxMsg2");
curl_exec ($ch);
curl_close ($ch);
}

if ($maintenant==$annuel){
$ch = curl_init("http://api.pushingbox.com/pushingbox?devid=$PushingBox&titre=$PushingBoxTitre3&msg=$PushingBoxMsg3");
curl_exec ($ch);
curl_close ($ch);
}
}
?>