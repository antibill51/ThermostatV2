<?php
/*****************************************************************************/
/*** File   : verif.inc.php                                                ***/
/*** Author : R.SYREK                                                      ***/
/*** WWW    : http://domotique-home.fr                                     ***/
/*** Note   : Configuration file                                           ***/
/*****************************************************************************/
include_once('config/config.inc.php');
$stock = htmlentities($_POST['stock']); 
$prixsac = htmlentities($_POST['prixsac']);
$reliquat = htmlentities($_POST['reliquat']);
$date1 = htmlentities($_POST['date1']);
$date1 = substr($date1,6,4)."-".substr($date1,3,2)."-".substr($date1,0,2);
$date1 = date('Y-m-d', strtotime($date1));
$date2 = htmlentities($_POST['date2']);
$date2 = substr($date2,6,4)."-".substr($date2,3,2)."-".substr($date2,0,2);
$date2 = date('Y-m-d', strtotime($date2));
$date3 = htmlentities($_POST['date3']);
$date3 = substr($date3,6,4)."-".substr($date3,3,2)."-".substr($date3,0,2);
$date3 = date('Y-m-d', strtotime($date3));
$info = htmlentities($_POST['info']);
$PushingBox = htmlentities($_POST['PushingBox']);
$PushingBoxTitre1 = htmlentities(addslashes($_POST['PushingBoxTitre1']));
$PushingBoxMsg1 = htmlentities(addslashes($_POST['PushingBoxMsg1']));
$PushingBoxTitre2 = htmlentities(addslashes($_POST['PushingBoxTitre2']));
$PushingBoxMsg2 = htmlentities(addslashes($_POST['PushingBoxMsg2']));
$PushingBoxTitre3 = htmlentities(addslashes($_POST['PushingBoxTitre3']));
$PushingBoxMsg3 = htmlentities(addslashes($_POST['PushingBoxMsg3']));
$msg = htmlentities($_POST['msg']);

if ($msg == 1)
{
if(empty($stock)) 
{
echo "<script type=\"text/javascript\">alert(\"Veuillez renseigner le champ \253Nombre de sacs achet\351s\273.\");</script>";
header ("Refresh: 0;URL=admin.php");
exit();
}
if(empty($prixsac)) 
{ 
echo "<script type=\"text/javascript\">alert(\"Veuillez renseigner le champ \253Prix de sac\273\");</script>";
header ("Refresh: 0;URL=admin.php");
exit();
} 

try
{
	$bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$reponse = $bdd->query("SELECT MAX(id) as DId FROM domotique_granules_stock");
$donnees= $reponse->fetch();
$lastID  = $donnees['DId'];
$bdd->exec("UPDATE domotique_granules_stock SET stockIni = $stock, prixsac = $prixsac, reliquat = $reliquat WHERE id = $lastID");

echo "<script type=\"text/javascript\">alert(\"Les donn\351es ont bien \351t\351 enregistr\351es.\");</script>";
header ("Refresh: 0;URL=admin.php");
}

if ($msg == 11)
{
if(empty($stock)) 
{
echo "<script type=\"text/javascript\">alert(\"Veuillez renseigner le champ \253Nombre de sacs achet\351s\273.\");</script>";
header ("Refresh: 0;URL=admin.php");
exit();
}
if(empty($prixsac)) 
{ 
echo "<script type=\"text/javascript\">alert(\"Veuillez renseigner le champ \253Prix de sac\273\");</script>";
header ("Refresh: 0;URL=admin.php");
exit();
} 

try
{
	$bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->exec("INSERT INTO domotique_granules_stock(stockIni, prixsac, reliquat) VALUES($stock, $prixsac, $reliquat)");

echo "<script type=\"text/javascript\">alert(\"Les donn\351es ont bien \351t\351 enregistr\351es.\");</script>";
header ("Refresh: 0;URL=admin.php");
}

if ($msg == 2)
{
try
{
	$bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->exec("UPDATE domotique_granules_entretiens SET regulier = '$date1', mensuel = '$date2', annuel = '$date3' WHERE id = 1");

echo "<script type=\"text/javascript\">alert(\"Les donn\351es ont bien \351t\351 enregistr\351es.\");</script>";
header ("Refresh: 0;URL=admin.php");
}

if ($msg == 3)
{
try
{
	$bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->exec("UPDATE domotique_granules_entretiens SET info = $info WHERE id = 1");

echo "<script type=\"text/javascript\">alert(\"Les donn\351es ont bien \351t\351 enregistr\351es.\");</script>";
header ("Refresh: 0;URL=admin.php");
}

if ($msg == 4)
{
try
{
	$bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$bdd->exec("UPDATE domotique_granules_entretiens SET PushingBox = '$PushingBox', PushingBoxTitre1 = '$PushingBoxTitre1', PushingBoxMsg1 = '$PushingBoxMsg1', PushingBoxTitre2 = '$PushingBoxTitre2', PushingBoxMsg2 = '$PushingBoxMsg2', PushingBoxTitre3 = '$PushingBoxTitre3', PushingBoxMsg3 = '$PushingBoxMsg3' WHERE id = 1");

echo "<script type=\"text/javascript\">alert(\"Les donn\351es ont bien \351t\351 enregistr\351es.\");</script>";
header ("Refresh: 0;URL=admin.php");
}
?>
