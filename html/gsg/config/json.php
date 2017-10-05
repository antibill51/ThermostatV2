<?php
/*****************************************************************************/
/*** File   : json.php                                                     ***/
/*** Author : R.SYREK                                                      ***/
/*** WWW    : http://domotique-home.fr                                     ***/
/*** Note   : json file                                                    ***/
/*****************************************************************************/
require('config.inc.php');
$json = htmlspecialchars($_GET["json"]);
//on determine l'année en cours par deffaut
$annees_list = htmlspecialchars($_GET["an"]);
if (empty($annees_list) or !is_numeric($annees_list))
{
$annees_list = date('Y');
}
else
{
$annees_list = htmlspecialchars($_GET["an"]);
}
 
$Conn = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($database, $Conn);
$query_Stats = "SELECT * FROM `domotique_granules_conso`";
$Stats = mysql_query($query_Stats, $Conn) or die(mysql_error());
$row_Stats = mysql_fetch_assoc($Stats);
$totalRows_Stats = mysql_num_rows($Stats);
$reliquat =  mysql_query("SELECT `reliquat` FROM `domotique_granules_stock` where year(`time`) = $annees_list ", $Conn) or die(mysql_error());
$num_rows = mysql_num_rows($reliquat);
if ($num_rows > 0) {$reliquat = mysql_result($reliquat,0);} else {$reliquat = 0;}
$stockini = mysql_query("SELECT `stockIni` FROM `domotique_granules_stock` where year(`time`) = $annees_list ", $Conn) or die(mysql_error());
$num_rows = mysql_num_rows($stockini);
if ($num_rows > 0) {$stockini = mysql_result($stockini,0);} else {$stockini = 0;}
$prixsac = mysql_query("SELECT `prixsac` FROM `domotique_granules_stock` where year(`time`) = $annees_list ", $Conn) or die(mysql_error());
$num_rows = mysql_num_rows($prixsac);
if ($num_rows > 0) {$prixsac = mysql_result($prixsac,0);} else {$prixsac = 0;}
$prixsacAV = mysql_query("SELECT `prixsac` FROM `domotique_granules_stock` where year(`time`) = ($annees_list-1) ", $Conn) or die(mysql_error());
$num_rows = mysql_num_rows($prixsacAV);
if ($num_rows > 0) {$prixsacAV = mysql_result($prixsacAV,0);} else {$prixsacAV = 0;}
$er = mysql_query("SELECT `regulier` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$er = mysql_result($er,0);
$em = mysql_query("SELECT `mensuel` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$em = mysql_result($em,0);
$ea = mysql_query("SELECT `annuel` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$ea = mysql_result($ea,0);
$last_date = mysql_query("SELECT `time` FROM `domotique_granules_conso` ORDER BY `id` DESC LIMIT 0,1", $Conn) or die(mysql_error());
$last_date = mysql_result($last_date,0);

//Creation de tableau annees avec les valeurs uniques
$veriff = "";
$res = mysql_query("SELECT year(`time`) FROM `domotique_granules_conso`", $Conn) or die(mysql_error());
while($data=mysql_fetch_array($res)) {
    $donneee = $data["year(`time`)"];
    if ($donneee == $veriff)
    {
    //$veriff = $donneee;
    } 
    else {
    $veriff = $donneee;
    $annees[] = $donneee; 

    }
    }

$jan = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 1 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$fev = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 2 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$mar = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 3 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$avr = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 4 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$mai = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 5 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$jun = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 6 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$jui = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 7 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$aou = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 8 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$sep = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 9 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$oct = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 10 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$nov = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 11 and year(`time`) = $annees_list", $Conn) or die(mysql_error());
$dec = mysql_query("SELECT month(`time`) FROM `domotique_granules_conso` Where month(`time`) = 12 and year(`time`) = $annees_list", $Conn) or die(mysql_error());

$array = array(
"Janvier $annees_list" => mysql_num_rows($jan),
"Fevrier $annees_list" => mysql_num_rows($fev),
"Mars $annees_list" => mysql_num_rows($mar),
"Avril $annees_list" => mysql_num_rows($avr),
"Mai $annees_list" => mysql_num_rows($mai),
"Juin $annees_list" => mysql_num_rows($jun),
"Juillet $annees_list" => mysql_num_rows($jui),
"Aout $annees_list" => mysql_num_rows($aou),
"Septembre $annees_list" => mysql_num_rows($sep),
"Octobre $annees_list" => mysql_num_rows($oct),
"Novembre $annees_list" => mysql_num_rows($nov),
"Decembre $annees_list" => mysql_num_rows($dec),
);

//calcule mois actifs 
 $compteur = 0;
 if ($array["Janvier $annees_list"]!= 0) {++$compteur;}
 if ($array["Fevrier $annees_list"]!= 0) {++$compteur;}
 if ($array["Mars $annees_list"]!= 0) {++$compteur;}
 if ($array["Avril $annees_list"]!= 0) {++$compteur;}
 if ($array["Mai $annees_list"]!= 0) {++$compteur;}
 if ($array["Juin $annees_list"]!= 0) {++$compteur;}
 if ($array["Juillet $annees_list"]!= 0) {++$compteur;}
 if ($array["Aout $annees_list"]!= 0) {++$compteur;}
 if ($array["Septembre $annees_list"]!= 0) {++$compteur;}
 if ($array["Octobre $annees_list"]!= 0) {++$compteur;}
 if ($array["Novembre $annees_list"]!= 0) {++$compteur;}
 if ($array["Decembre $annees_list"]!= 0) {++$compteur;}

 //calcule de total sac consomés
 $TotalSacConsomes = array_sum($array);
 
 //calcule cout consomé
 if ($annees_list == date('Y')){
 if ($TotalSacConsomes<=$reliquat){
 $CoutConsome = $TotalSacConsomes * $prixsacAV;
 }
 else{
 $CoutConsome = ($reliquat * $prixsacAV) + (($TotalSacConsomes - $reliquat) * $prixsac);
 }
 }
 else {
 $CoutConsome =  mysql_query("SELECT `totalcout` FROM `Cout_consomme_an` where annee = $annees_list ", $Conn) or die(mysql_error());
$num_rows = mysql_num_rows($CoutConsome);
if ($num_rows > 0) {$CoutConsome = mysql_result($CoutConsome,0);} else {$CoutConsome = 0;}
 //$CoutConsome = mysql_result($CoutConsome,0);
 }
 
 //creation du tableau conso et cout annuel
$TabArray = array(); 
$TabHisto =  mysql_query("SELECT * FROM `Cout_consomme_an` ", $Conn) or die(mysql_error());
$nbr_ligne = mysql_num_rows($TabHisto);
while ($r = mysql_fetch_array($TabHisto)) {
$TabArray[] = $r;
}
for($i = 0; $i<$nbr_ligne; $i++)
    {
    $Tannee = $Tannee.$TabArray[$i]['annee'].',';
    $Ttotalconso = $Ttotalconso.$TabArray[$i]['totalconso'].',';
    $Ttotalcout =  $Ttotalcout.round($TabArray[$i]['totalcout'], 2).',';
    }
$Tannee = substr("$Tannee",0,-1);
$Ttotalconso = substr("$Ttotalconso",0,-1);
$Ttotalcout = substr("$Ttotalcout",0,-1); 
 
 //creation Json
 if ($json == 1)
 {
$json_data = array();
$json_data["Soft"] = 'Gestion Granulés';
$json_data["Auteur"] = 'R.Syrek';
$json_data["Site"] = 'Domotique-Home.fr';
$json_data["date"]  = time();
$json_data["StockIni"] = $stockini;
$json_data["Reliquat"] = $reliquat;
$json_data["PrixSac"] = $prixsac;
$json_data["NbrSacConso"] = $TotalSacConsomes;
$json_data["NbrMoisPariode"] = $compteur;
$json_data["Janvier $annees_list"] = $array["Janvier $annees_list"];
$json_data["Fevrier $annees_list"] = $array["Fevrier $annees_list"];
$json_data["Mars $annees_list"] = $array["Mars $annees_list"];
$json_data["Avril $annees_list"] = $array["Avril $annees_list"];
$json_data["Mai $annees_list"] = $array["Mai $annees_list"];
$json_data["Juin $annees_list"] = $array["Juin $annees_list"];
$json_data["Jullet $annees_list"] = $array["Juillet $annees_list"];
$json_data["Aout $annees_list"] = $array["Aout $annees_list"];
$json_data["Septembre $annees_list"] = $array["Septembre $annees_list"];
$json_data["Octobre $annees_list"] = $array["Octobre $annees_list"];
$json_data["Novembre $annees_list"] = $array["Novembre $annees_list"];
$json_data["Decembre $annees_list"] = $array["Decembre $annees_list"];
$json_data["er"] = $er;
$json_data["em"] = $em;
$json_data["ea"] = $ea;
$json_data["last_date"] = $last_date;

$json_output = json_encode($json_data);  
echo $json_output;
 }
?>

