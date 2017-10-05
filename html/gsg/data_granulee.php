<?php
/*****************************************************************************/
/*** File   : data_granulee.php                                            ***/
/*** Author : RSYREK                                                       ***/
/*** WWW    : http://domotique-home.fr                                     ***/
/*** Note   : Insert data into database                                    ***/
/*****************************************************************************/

require('config/config.inc.php');
$value = $_GET['value'];
$dmy = $_GET['dmy'];

try
{
	$bdd = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


//recherche de dernier prix enregistré
$reponse = $bdd->query("SELECT MAX(id) FROM `domotique_granules_stock`");
$resultats = $reponse->fetch();
$maxid = $resultats['MAX(id)'];

// On consomme 1 sac
if ($value == 1)
{
$bdd->exec("INSERT INTO domotique_granules_conso(value,id_stock) VALUES($value,$maxid)");
}

//extraction des dates d'entretien
$reponse = $bdd->query("SELECT `regulier`,`mensuel`,`annuel` FROM `domotique_granules_entretiens` where id = 1");
$resultats = $reponse->fetch();
//$regulier = time();
$regulier = $resultats['regulier'];
$mensuel = $resultats['mensuel'];
$annuel = $resultats['annuel'];
$reponse->closeCursor();
//echo "Date: $resultats";


//incremantation de la date regulier de X jours par defaut = 4
if ($value == 2)
{
if (!isset($dmy)){ $dmy = 4; }
$regulier = strtotime("+$dmy days");
//strtotime($regulier));
$regulier = date("Y-m-d", $regulier);
$bdd->exec("UPDATE domotique_granules_entretiens SET regulier = '$regulier' WHERE id = 1");
}

//incrementation de la date mensuel de X mois par defaut = 1
if ($value == 3)
{
if (!isset($dmy)){ $dmy = 1; }
$mensuel = strtotime(("+$dmy month"), strtotime($mensuel));
$mensuel = date("Y-m-d", $mensuel);
$bdd->exec("UPDATE domotique_granules_entretiens SET mensuel = '$mensuel' WHERE id = 1");
}

//incremantation de la date annuel de X annees par defaut = 1
if ($value == 4)
{
if (!isset($dmy)){ $dmy = 1; }
$annuel = strtotime(("+$dmy year"), strtotime($annuel));
$annuel = date("Y-m-d", $annuel);
$bdd->exec("UPDATE domotique_granules_entretiens SET annuel = '$annuel' WHERE id = 1");
}
$page = $_SERVER["HTTP_REFERER"];
header('Refresh:2; URL='.$page);

?>
