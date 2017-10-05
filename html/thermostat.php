<html>
	<head>
			<meta charset="UTF-8" />
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
			<title>Thermostat</title>
			<link href="css/style.css" rel="stylesheet" type="text/css" />
			<meta name="Thermostat" content="Thermostat" />
	</head>
<?php
    header("refresh: 30;");
if(isset($_POST["setprog-rdc"]) && ($_POST["setprog-rdc"] != 0)) {

$setprogrdc = $_POST["setprog-rdc"];
$fp = fopen("/var/bin/prog-rdc", "w+");
$savestring = $setprogrdc;
fwrite($fp, $savestring);
fclose($fp);
}
if(isset($_POST["setprog-1"]) && ($_POST["setprog-1"] != 0)) {

$setprog1 = $_POST["setprog-1"];
$fp = fopen("/var/bin/prog-1", "w+");
$savestring = $setprog1;
fwrite($fp, $savestring);
fclose($fp);

}if(isset($_POST["setprog-2"]) && ($_POST["setprog-2"] != 0)) {

$setprog2 = $_POST["setprog-2"];
$fp = fopen("/var/bin/prog-2", "w+");
$savestring = $setprog2;
fwrite($fp, $savestring);
fclose($fp);
}




if(isset($_POST["setmode-rdc"]) && ($_POST["setmode-rdc"] != 0)) {

$setmoderdc = $_POST["setmode-rdc"];
$fp = fopen("/var/bin/mode-rdc", "w+");
$savestring = $setmoderdc;
fwrite($fp, $savestring);
fclose($fp);
}

if(isset($_POST["setmode-1"]) && ($_POST["setmode-1"] != 0)) {

$setmode1 = $_POST["setmode-1"];
$fp = fopen("/var/bin/mode-1", "w+");
$savestring = $setmode1;
fwrite($fp, $savestring);
fclose($fp);
}

if(isset($_POST["setmode-2"]) && ($_POST["setmode-2"] != 0)) {

$setmode2 = $_POST["setmode-2"];
$fp = fopen("/var/bin/mode-2", "w+");
$savestring = $setmode2;
fwrite($fp, $savestring);
fclose($fp);
}




if(isset($_POST["settemp-rdc"]) && ($_POST["settemp-rdc"] != 0)) {

$settemprdc = $_POST["settemp-rdc"];
$fp = fopen("/var/bin/thermostat-rdc", "w+");
$savestring = $settemprdc;
fwrite($fp, $savestring);
fclose($fp);
}

if(isset($_POST["settemp-1"]) && ($_POST["settemp-1"] != 0)) {

$settemp1 = $_POST["settemp-1"];
$fp = fopen("/var/bin/thermostat-1", "w+");
$savestring = $settemp1;
fwrite($fp, $savestring);
fclose($fp);
}

if(isset($_POST["settemp-2"]) && ($_POST["settemp-2"] != 0)) {

$settemp2 = $_POST["settemp-2"];
$fp = fopen("/var/bin/thermostat-2", "w+");
$savestring = $settemp2;
fwrite($fp, $savestring);
fclose($fp);
}




?>
<div align = "center">
<body>
	<header>
		<div class="logo">
			<a href="index.php">
				<img src="images/logo.png" alt="Page de réglage des thermostats" />
			</a>
		</div>

	<div class="clear"></div>
	</header>
        <div class="content">
<h5>Niveau du réservoir : <?php echo $niveau = file_get_contents('/var/bin/niveau'); ?>%.</h5>

<a href="http://www.accuweather.com/fr/fr/vedene/166241/weather-forecast/166241" class="aw-widget-legal">
<!--
By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at http://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at http://www.accuweather.com/en/privacy.
-->
</a><div id="awcc1484474522968" class="aw-widget-current"  data-locationkey="1-166241_1_AL" data-unit="c" data-language="fr" data-useip="false" data-uid="awcc1484474522968"></div><script type="text/javascript" src="http://oap.accuweather.com/launch.js"></script>
<div id='tameteo' style='font-family:Arial;text-align:center;border:solid 1px #000000; background:#E0E0E0; width:300px; padding:4px'><a href='http://www.ta-meteo.fr/vedene' target='_blank' title='Météo Vedene' style='font-weight: bold;font-size:14px;text-decoration:none;color:#000000;line-height:14px;'>M&eacute;t&eacute;o Vedene</a><br/><a href='http://www.ta-meteo.fr' target='_blank' title='meteo'><img src='http://www.ta-meteo.fr/widget4/099b91779a0f4905abcf6a2c55d066e3.png?t=time()' border='0'></a><br/><a href='http://www.mein-wetter.com' style='font-size:10px;text-decoration:none;color:#000000;line-height:10px;' target='_blank' >&copy; mein-wetter.com</a></div>

	<div class="content">
		<article>
<h5>Température du rez de chaussée : <?php echo $temp = file_get_contents('/var/bin/temp-rdc'); ?>°C. <?php $onoff = file_get_contents('/var/bin/status-rdc');$onoff = str_replace('1' ,'Poële en fonctionnement',$onoff); $onoff = str_replace('2' ,'Pöele arreté',$onoff);$onoff = str_replace('3' ,'Poële en mode éco',$onoff); echo $onoff; ?></h5>

			<form name="termostat" method="post" class="label-top" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div>
					<label for="settemp-rdc" class="inline">Temperature réglée à</label>
					<select name="settemp-rdc" id="settemp-rdc" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet = file_get_contents('/var/bin/thermostat-rdc'); echo $curSet; ?> °C </option>
						<option value="20.0">20.0°C</option>
						<option value="19.5">19.5°C</option>
						<option value="19.0">19.0°C</option>
						<option value="18.5">18.5°C</option>
						<option value="18.0">18.0°C</option>
						<option value="17.5">17.5°C</option>
						<option value="17.0">17.0°C</option>
						<option value="16.5">16.5°C</option>
						<option value="16.0">16.0°C</option>
						<option value="15.5">15.5°C</option>
						<option value="15.0">15.0°C</option>
						<option value="12.0">12.0°C</option>
					</select>

					<label for="setmode-rdc" class="inline">Options</label>
					<select name="setmode-rdc" id="setmode-rdc" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet1 = file_get_contents('/var/bin/mode-rdc'); $curSet1 = str_replace('1' ,'Marche/Arret',$curSet1); $curSet1 = str_replace('2' ,'Marche/Eco',$curSet1); $curSet1 = str_replace('3' ,'Arret forcé',$curSet1); echo $curSet1; ?> </option>
						<option value="1">Marche/Arret</option>
						<option value="2">Marche/Eco</option>
						<option value="3">Arrêt forcé</option>
					</select>

					<select name="setprog-rdc" id="setprog-rdc" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet1 = file_get_contents('/var/bin/prog-rdc'); $curSet1 = str_replace('1' ,'Programmation',$curSet1); $curSet1 = str_replace('2' ,'Consigne manu',$curSet1); echo $curSet1; ?> </option>
						<option value="1">Programmation</option>
						<option value="2">Consigne manu</option>
					</select>

				</div>
			</form>

        <div>
            <img src="munin/localdomain/localhost.localdomain/temp_temp_rdc_thermostat_rdc_RDC_status_rdc-day.png" alt="myPic" />
        </div>
                        <h2 class="underline"></h2>
<h5>Température de la chambre : <?php echo $temp = file_get_contents('/var/bin/temp-1'); ?>°C. <?php $onoff = file_get_contents('/var/bin/status-1'); $onoff = str_replace('1' ,'Cannalisation en fonctionnement',$onoff); $onoff = str_replace('2' ,'Cannalisation arretée',$onoff); echo $onoff; ?></h5>

			<form name="termostat" method="post" class="label-top" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div>
					<label for="settemp-1" class="inline">Temperature réglée à</label>
					<select name="settemp-1" id="settemp-1" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet = file_get_contents('/var/bin/thermostat-1'); echo $curSet; ?> °C </option>
						<option value="20.0">20.0°C</option>
						<option value="19.5">19.5°C</option>
						<option value="19.0">19.0°C</option>
						<option value="18.5">18.5°C</option>
						<option value="18.0">18.0°C</option>
						<option value="17.5">17.5°C</option>
						<option value="17.0">17.0°C</option>
						<option value="16.5">16.5°C</option>
						<option value="16.0">16.0°C</option>
						<option value="15.5">15.5°C</option>
						<option value="15.0">15.0°C</option>
						<option value="12.0">12.0°C</option>
					</select>

					<label for="setmode-1" class="inline">Options</label>
					<select name="setmode-1" id="setmode-1" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet1 = file_get_contents('/var/bin/mode-1'); $curSet1 = str_replace('1' ,'Automatique',$curSet1); $curSet1 = str_replace('2' ,'Marche forcée',$curSet1); $curSet1 = str_replace('3' ,'Arret forcé',$curSet1); echo $curSet1; ?> </option>
						<option value="1">Automatique</option>
						<option value="2">Marche forcée</option>
						<option value="3">Arrêt forcé</option>
					</select>
					<select name="setprog-1" id="setprog-1" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet1 = file_get_contents('/var/bin/prog-1'); $curSet1 = str_replace('1' ,'Programmation',$curSet1); $curSet1 = str_replace('2' ,'Consigne manu',$curSet1); echo $curSet1; ?> </option>
						<option value="1">Programmation</option>
						<option value="2">Consigne manu</option>
					</select>
					
				</div>
			</form>

        <div>
            <img src="munin/localdomain/localhost.localdomain/temp_temp_1_thermostat_1_1_none-day.png" alt="myPic" />
        </div>
                        <h2 class="underline"></h2>
<h5>Température du second : <?php echo $temp = file_get_contents('/var/bin/temp-2'); ?>°C. <?php $onoff = file_get_contents('/var/bin/status-2'); $onoff = str_replace('1' ,'Cannalisation en fonctionnement',$onoff); $onoff = str_replace('2' ,'Cannalisation arretée',$onoff); echo $onoff; ?></h5>

			<form name="termostat" method="post" class="label-top" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div>
					<label for="settemp-2" class="inline">Temperature réglée à</label>
					<select name="settemp-2" id="settemp-2" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet = file_get_contents('/var/bin/thermostat-2'); echo $curSet; ?> °C </option>
						<option value="20.0">20.0°C</option>
						<option value="19.5">19.5°C</option>
						<option value="19.0">19.0°C</option>
						<option value="18.5">18.5°C</option>
						<option value="18.0">18.0°C</option>
						<option value="17.5">17.5°C</option>
						<option value="17.0">17.0°C</option>
						<option value="16.5">16.5°C</option>
						<option value="16.0">16.0°C</option>
						<option value="15.5">15.5°C</option>
						<option value="15.0">15.0°C</option>
						<option value="12.0">12.0°C</option>
					</select>

					<label for="setmode-2" class="inline">Options</label>
					<select name="setmode-2" id="setmode-2" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet1 = file_get_contents('/var/bin/mode-2'); $curSet1 = str_replace('1' ,'Automatique',$curSet1); $curSet1 = str_replace('2' ,'Marche forcée',$curSet1); $curSet1 = str_replace('3' ,'Arret forcé',$curSet1); echo $curSet1; ?> </option>
						<option value="1">Automatique</option>
						<option value="2">Marche forcée</option>
						<option value="3">Arrêt forcé</option>
					</select>

					<select name="setprog-2" id="setprog-2" onChange="this.form.submit()">
						<option value=null SELECTED><?php $curSet1 = file_get_contents('/var/bin/prog-2'); $curSet1 = str_replace('1' ,'Programmation',$curSet1); $curSet1 = str_replace('2' ,'Consigne manu',$curSet1); echo $curSet1; ?> </option>
						<option value="1">Programmation</option>
						<option value="2">Consigne manu</option>
					</select>
        <div>
            <img src="munin/localdomain/localhost.localdomain/temp_temp_2_thermostat_2_2_none-day.png" alt="myPic" />
        </div>
				</div>
			</form>


			<footer>
			</footer>
</body>
</div>
</html>
