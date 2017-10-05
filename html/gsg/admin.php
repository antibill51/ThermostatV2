<?php
/*****************************************************************************/
/*** File   : admin.php                                                    ***/
/*** Author : R.SYREK                                                      ***/
/*** WWW    : http://domotique-home.fr                                     ***/
/*** Note   : Admin file                                                   ***/
/*****************************************************************************/ 
include_once('config/config.inc.php');  
$Conn = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
$annees_list = htmlspecialchars($_GET["an"]);
mysql_select_db($database, $Conn);
if (empty($annees_list) or !is_numeric($annees_list))
{
$annees_list = mysql_query("SELECT year(`time`) FROM `domotique_granules_stock` where id = (SELECT max(id) FROM `domotique_granules_stock`)", $Conn) or die(mysql_error());
$annees_list = mysql_result($annees_list,0);
}
else
{
$annees_list = htmlspecialchars($_GET["an"]);
}


//mysql_query("SET NAMES 'utf8'");
$reliquat =  mysql_query("SELECT `reliquat` FROM `domotique_granules_stock` where year(`time`) = $annees_list", $Conn) or die(mysql_error());
$reliquat = mysql_result($reliquat,0);
$stockini = mysql_query("SELECT `stockIni` FROM `domotique_granules_stock` where year(`time`) = $annees_list", $Conn) or die(mysql_error());
$stockini = mysql_result($stockini,0);
$prixsac = mysql_query("SELECT `prixsac` FROM `domotique_granules_stock` where year(`time`) = $annees_list", $Conn) or die(mysql_error());
$prixsac = mysql_result($prixsac,0);
$regulier = mysql_query("SELECT `regulier` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$regulier = mysql_result($regulier,0);
$regulier = date("d/m/Y", strtotime($regulier));
$mensuel = mysql_query("SELECT `mensuel` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$mensuel = mysql_result($mensuel,0);
$mensuel = date("d/m/Y", strtotime($mensuel));
$annuel = mysql_query("SELECT `annuel` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$annuel = mysql_result($annuel,0);
$annuel = date("d/m/Y", strtotime($annuel));
$info = mysql_query("SELECT `info` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$info = mysql_result($info,0);
$PushingBox = mysql_query("SELECT `PushingBox` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBox = mysql_result($PushingBox,0);
$PushingBoxTitre1 = mysql_query("SELECT `PushingBoxTitre1` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxTitre1 = mysql_result($PushingBoxTitre1,0);
$PushingBoxTitre1 = html_entity_decode($PushingBoxTitre1);
$PushingBoxMsg1 = mysql_query("SELECT `PushingBoxMsg1` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxMsg1 = mysql_result($PushingBoxMsg1,0);
$PushingBoxMsg1 = html_entity_decode($PushingBoxMsg1);
$PushingBoxTitre2 = mysql_query("SELECT `PushingBoxTitre2` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxTitre2 = mysql_result($PushingBoxTitre2,0);
$PushingBoxTitre2 = html_entity_decode($PushingBoxTitre2);
$PushingBoxMsg2 = mysql_query("SELECT `PushingBoxMsg2` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxMsg2 = mysql_result($PushingBoxMsg2,0);
$PushingBoxMsg2 = html_entity_decode($PushingBoxMsg2);
$PushingBoxTitre3 = mysql_query("SELECT `PushingBoxTitre3` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxTitre3 = mysql_result($PushingBoxTitre3,0);
$PushingBoxTitre3 = html_entity_decode($PushingBoxTitre3);
$PushingBoxMsg3 = mysql_query("SELECT `PushingBoxMsg3` FROM `domotique_granules_entretiens` where id = 1", $Conn) or die(mysql_error());
$PushingBoxMsg3 = mysql_result($PushingBoxMsg3,0);
$PushingBoxMsg3 = html_entity_decode($PushingBoxMsg3);
$last_date = mysql_query("SELECT `time` FROM `domotique_granules_conso` ORDER BY `id` DESC LIMIT 0,1", $Conn) or die(mysql_error());
$last_date = mysql_result($last_date,0);
$last_date = date("d/m/Y H:m", strtotime($last_date));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<script type="text/javascript" src="calendrier_js/calendrier.js"></script>
<script type="text/javascript" src="js/send_data.js"></script>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="calendrier_js/design.css" />
<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="Pcontainer">
<div id="topbar"><div id="topbarcentre"><h1>Administration</h1></div></div> 
<div class="spacer"></div>   
 
<div id="menubar">
<div id="txtmenubar">| <a href="graph.php">Historique</a> | <a href="index.php">Statistiques</a> | <a href="/index.php">Retour</a> |</div>
</div> 
<div class="spacer"></div> 

<div id="main">

<div id="column_left">
<div id="menucolumne"><div id="txtNoir">&curren; Param&eacute;trages</div> </div>
<form method="post" name="myForm" action="">
<div id="tabMois">
<div class="row">
    <span class="cell">Reliquat :</span>
    <span class="cell"><input type="text" name="reliquat" size="6" value=<?php echo $reliquat; ?>></span>
</div>
<div class="row">
    <span class="cell">Stock :</span>
    <span class="cell"><input type="text" name="stock" size="6" value=<?php echo $stockini; ?>></span>
</div>
<div class="row">
    <span class="cell">Total :</span>
    <span class="cell"><input type="text" name="totalstock" size="6" value=<?php echo ($stockini + $reliquat); ?> disabled="disabled" ></span>
</div>
<div class="row">
    <span class="cell">Prix de sac :</span>
    <span class="cell"><input type="text" name="prixsac" size="6" value=<?php echo $prixsac; ?>></span>
</div>
<div class="row"><span class="cell"></span><span class="cell"></span></div>
<div class="row">
 
<span class="cell"><input type="submit" onClick="javascript:document.myForm.action='verif.php'; document.getElementById('myField').value =1;" value="M.A.J." class = "btn"></span> 
<span class="cell"><input type="submit" onClick="javascript:document.myForm.action='verif.php'; document.getElementById('myField').value =11;" value="Nouveau" class = "btn"></span>    
</div>
</div>
<input type='hidden' id="myField" name='msg' value="">
</form>
<div class="spacer"></div>
<form method="post" action="verif.php">
<div id="tabMois">
<div class="row">
    <span class="cell">Entretien r&eacute;gulier (1)</span>
    <span class="cell">
    <table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
    <tr><td id="ds_calclass"></td></tr></table><input type="text" size="10" name="date1" value=<?php echo $regulier; ?> onclick="ds_sh(this);" />
    </span>
</div>
<div class="row">
    <span class="cell">Entretien mensuel (2)</span>
    <span class="cell">
    <table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
    <tr><td id="ds_calclass"></td></tr></table><input type="text" size="10" name="date2" value=<?php echo $mensuel; ?> onclick="ds_sh(this);" />
    </span>
</div>
<div class="row">
    <span class="cell">Entretien annuel (3)</span>
    <span class="cell">
    <table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
    <tr><td id="ds_calclass"></td></tr></table><input type="text" size="10" name="date3" value=<?php echo $annuel; ?> onclick="ds_sh(this);" />
    </span>
</div>
<div class="row"><span class="cell"></span><span class="cell"></span></div>
<div class="row">  
    <div class="topbarcentre"><input type="submit" value="Enregistrer" class = "btn"></div>
</div>
</div>
<input type='hidden' name='msg' value="2">
</form>
</div>

<div id="column_right">
<div id="menucolumne"><div id="txtNoir">&curren; Gestion</div> </div>
<div id="tabMois">
<div class="row">
    <span class="cell">Consommer un sac</span>
    <span class="cell"><INPUT type="BUTTON" value="+1" class = "btn"  onclick="submitForm()"></span>
</div>
<div class="row">
    <span class="cell">Derni&egrave;re conso:</span>
    <span class="cell"><?php echo $last_date; ?></span>
</div>
</div>
<form method="post" action="verif.php">
<div id="tabMois">
<div class="row">
    <span class="cell">Envoyer infos entretiens</span>
    <span class="cell">
    <INPUT type="radio" name="info" value=1 <?php if ($info==1){echo "checked";}?>>Oui
    <INPUT type="radio" name="info" value=0 <?php if ($info==0){echo "checked";}?>>Non
    </span>
</div>
<div class="spacer"></div>
<div class="row">  
    <div class="topbarcentre"><input type="submit" value="Enregistrer" class = "btn"></div>
</div>
</div>
<input type='hidden' name='msg' value="3">
</form>
<div class="spacer"></div>
</div>
<div class="spacer"></div>
<div id="navbarPush"><div id="menunavbar"><div id="txtNoir">&curren; PushingBox</div> </div>
<form method="post" action="verif.php">
<div id="tabMois">
<div class="row">
<span class="cell">Code</span>
<span class="cell"><input type="text" name="PushingBox" size="15" value="<?php echo $PushingBox; ?>"></span>
</div>
<div class="row">
<span class="cell">Titre (1)</span>
<span class="cell"><input type="text" name="PushingBoxTitre1" size="80" value="<?php echo $PushingBoxTitre1; ?>"></span>
</div>
<div class="row">
<span class="cell">Message (1)</span>
<span class="cell"><input type="text" name="PushingBoxMsg1" size="80" value="<?php echo $PushingBoxMsg1; ?>"></span>
</div>
<div class="row">
<span class="cell">Titre (2)</span>
<span class="cell"><input type="text" name="PushingBoxTitre2" size="80" value="<?php echo $PushingBoxTitre2; ?>"></span>
</div>
<div class="row">
<span class="cell">Message (2)</span>
<span class="cell"><input type="text" name="PushingBoxMsg2" size="80" value="<?php echo $PushingBoxMsg2; ?>"></span>
</div>
<div class="row">
<span class="cell">Titre (3)</span>
<span class="cell"><input type="text" name="PushingBoxTitre3" size="80" value="<?php echo $PushingBoxTitre3; ?>"></span>
</div>
<div class="row">
<span class="cell">Message (3)</span>
<span class="cell"><input type="text" name="PushingBoxMsg3" size="80" value="<?php echo $PushingBoxMsg3; ?>"></span>
</div>
<div class="spacer"></div>
<div class="row">  
    <div class="topbarcentre"><input type="submit" value="Enregistrer" class = "btn"></div>
</div>
<input type='hidden' name='msg' value="4">
</div>
</form>
</div>
<div class="spacer"></div>
<!-- Affichage footer -->
<div id="footer">
<?php include_once('footer.php');?>
</div>
</div>
</div>
</body></html>
