<?php
// on se connecte à notre base
$base = mysql_connect ('localhost', 'root', '2a94r7ow');
mysql_select_db ('Thermostat', $base) ;

#Déclaration variable
//$i=0;
$temp_tab = array();
$timestamp = time();
$sql = 'SELECT *  FROM Sondes';
$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

while ($data = mysql_fetch_array($req)) {
	// on affiche les résultats
//	echo 'adresse : '.$data['Adresse'].'<br />';
//	echo 'Id : '.$data['Id'].'<br />';
 $Id = $data['Id'];
 $address = '/sys/bus/w1/devices/'.$data['Adresse'].'/w1_slave';
 $value = temp_read($address);
// echo '<br />'.$address.'<br />';
// echo $value.'<br />';
$float  = floatval($value);
//    echo $float;
//    echo gettype($float), "\n";
	if ($float >= 1 && $float <= 45) {
		 temp_write($Id, $timestamp, $float);
}
// echo $file_temp;
}
function temp_read($input)
{
 $file_temp = fopen($input, 'r');
 $i=0;
 while ($i < 2)
{
        $temp_line=fgets($file_temp);
        $temp_tab[]=$temp_line;
        $i++;
//	print $temp_line;
}

$temp_int = substr($temp_tab[1], -6, -4);
$temp_dec = substr($temp_tab[1],-4, -2);
settype($temp_final, "float");
$temp_final=$temp_int. ".".$temp_dec;

return $temp_final;

fclose($file_temp);

}
function temp_write($Id, $timestamp, $temp_final)
{
#Connection mysql
$link = mysqli_connect("localhost","root","2a94r7ow","Thermostat") or die("Error");

$query = "INSERT INTO Temperature (Id,Date,Temperature) VALUES('$Id','$timestamp','$temp_final')";

$result = mysqli_query($link, $query);
//print $result;
}
?>
