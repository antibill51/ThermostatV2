<?php
$server ="localhost";
$user="Thermostat";
$pass="Thermostat";
$db="Thermostat";
mysql_connect($server,$user,$pass) or die ("Erreur SQL : ".mysql_error() );
mysql_select_db($db) or die ("Erreur SQL : ".mysql_error() );
?>
