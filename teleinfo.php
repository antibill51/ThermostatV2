<?php
set_time_limit(30);
echo 'Téléinformation compteur EDF'."\n\n";

include "/home/pi/php_serial.class.php";  

$serial = new phpSerial();
$serial->deviceSet("/dev/ttyAMA0");

$serial->confBaudRate(1200);
$serial->confParity("even");
$serial->confCharacterLength(7);
$serial->confStopBits(1);
$serial->confFlowControl("none");

$serial->deviceOpen();  

$read = $serial->readPort();

// Données à récupérer
$teleinformation['ACDO'] = '';
$teleinformation['PTEC'] = '';
$teleinformation['OPTARIF'] = '';
$teleinformation['ISOUSC'] = '';
$teleinformation['HCHC'] = '';
$teleinformation['HCHP'] = '';
$teleinformation['IINST'] = '';
$teleinformation['timestamp'] = time();
// Récupération des données
if(isset($read)){

	$continuer_lecture = true;
	$trame_commence = false;
	
	while( $continuer_lecture ){
		$read = $serial->readPort();
		$ligne = '';
		for($i = 0; $i < strlen($read); $i++)
		{
			$ligne .= $read[$i];
		}
		$ligne = trim($ligne);
		if ( $ligne != '' ){
			// Une ligne complète
			//echo $ligne."\n";
			
			$data_ligne = explode(' ', $ligne);
			if ( $data_ligne[0] == 'ADCO' ){
				if ( !$trame_commence ){
					// Début de trame
					$trame_commence = true;
				}
				else{
					// Début d'une autre trame
					// Fin lecture
					$continuer_lecture = false;
				}
			}
			
			if ( $continuer_lecture && $trame_commence ){
				echo $ligne."\n";
				
				if ( $data_ligne[0] == 'ADCO' )
					$teleinformation['ACDO'] = $data_ligne[1];
					
				if ( $data_ligne[0] == 'PTEC' )
					$teleinformation['PTEC'] = $data_ligne[1];
                                
                                if ( $data_ligne[0] == 'ISOUSC' )
                                        $teleinformation['ISOUSC'] = $data_ligne[1];
				
				if ( $data_ligne[0] == 'OPTARIF' )
					$teleinformation['OPTARIF'] = $data_ligne[1];
				
				if ( $data_ligne[0] == 'HCHC' )
					$teleinformation['HCHC'] = $data_ligne[1];
					
				if ( $data_ligne[0] == 'HCHP' )
					$teleinformation['HCHP'] = $data_ligne[1];
				
				if ( $data_ligne[0] == 'IINST' )
					$teleinformation['IINST'] = $data_ligne[1];
				$teleinformation['PAPP'] = $teleinformation['IINST']*230;
			}
		}
	}
}
else{
	echo 'Erreur lors de la récupération des données';
}

$serial->deviceClose();



// Affichage et traitement des donnees récupérés
if ( $teleinformation['ACDO'] != ''
	&& $teleinformation['PTEC'] != ''
	&& $teleinformation['ISOUSC'] != ''
	&& $teleinformation['OPTARIF'] != ''
        && $teleinformation['HCHC'] != ''
	&& $teleinformation['HCHP'] != ''
	&& $teleinformation['IINST'] != '' ){
	
	// Suppression des zéros en trop
	$teleinformation['HCHC'] = $teleinformation['HCHC'] + 0;
	$teleinformation['HCHP'] = $teleinformation['HCHP'] + 0;
	$teleinformation['IINST'] = $teleinformation['IINST'] + 0;
	
	echo 'Données récupérées :'."\n";
	echo '- Identifiant compteur => '.$teleinformation['ACDO']."\n";
	echo '- Intensité souscrite => '.$teleinformation['ISOUSC']." Ampères \n";
	echo '- Code période tarifaire en cours => '.$teleinformation['PTEC']."\n";
	echo '- Index heures creuses => '.$teleinformation['HCHC']."\n";
	echo '- Index heures pleines => '.$teleinformation['HCHP']."\n";
	echo '- Puissance apparente => '.$teleinformation['PAPP']." Watts \n";
	
	
	try{
		// Connexion MySQL locale
		$mysqlHote = 'localhost';
		$mysqlBDD = 'Teleinfo';
                $mysqlTable = 'Teleinfo';
		$mysqlUtilisateur = 'teleinfo2';
		$mysqlPass = 'teleinfo';
		$sql_local = new PDO('mysql:host='.$mysqlHote.';dbname='.$mysqlBDD, $mysqlUtilisateur, $mysqlPass);
		
//		// Récupération ID compteur
//		$id_compteur = 0;
//		while ( $id_compteur == 0 ){
//			
//			$result = $sql_local->query('SELECT id_compteur FROM compteur WHERE identifiant="'.$teleinformation['ACDO'].'"');
//
//			foreach ($result as $row){
//				$id_compteur = $row['id_compteur'];
//			}
//			
//			if ( $id_compteur == 0 ){
//				$sql = 'INSERT INTO $mysqlBDD (ACDO, ISOUSC) VALUES ("'.$teleinformation['ACDO'].'", "'.$teleinformation['ISOUSC'].'")';
//				$sql_local->query($sql);
//			}
//		}
		
//		// Mise à jour infos compteur
//		$sql = 'UPDATE compteur SET intensite_souscrite="'.$teleinformation['ISOUSC'].'" WHERE id_compteur="'.$id_compteur.'"';
//		$sql_local->query($sql);
		
		// Récupération ID période tarifaire
//		$id_periode_tarifaire = 0;
//		while ( $id_periode_tarifaire == 0 ){
//			
//			$result = $sql_local->query('SELECT id_periode_tarifaire FROM periode_tarifaire WHERE code="'.$teleinformation['PTEC'].'"');
//			foreach ($result as $row){
//				$id_periode_tarifaire = $row['id_periode_tarifaire'];
//			}
//			
//			if ( $id_periode_tarifaire == 0 ){
//				$sql = 'INSERT INTO $mysqlBDD(PTEC) VALUES ("'.$teleinformation['PTEC'].'")';
//				$sql_local->query($sql);
//			}
//		}
		
		/*$valeur = 0;
		if ( $teleinformation['PTEC'] == "HC.." ) $valeur = $teleinformation['HCHC'];
		else $valeur = $teleinformation['HCHP'];*/
		
/*		// Récupération dernière valeur creuses
		$result = $sql_local->query('SELECT valeur_heures_creuses FROM releve WHERE id_compteur="'.$id_compteur.'" AND valeur_heures_creuses IS NOT NULL ORDER BY date_heure DESC LIMIT 1');
		$derniere_valeur_creuse = 0;
		foreach ($result as $row){
			$derniere_valeur_creuse = $row['valeur_heures_creuses'];
		}
			
		// Récupération dernière valeur pleine
		$result = $sql_local->query('SELECT valeur_heures_pleines FROM releve WHERE id_compteur="'.$id_compteur.'" AND valeur_heures_pleines IS NOT NULL ORDER BY date_heure DESC LIMIT 1');
		$derniere_valeur_pleine = 0;
		foreach ($result as $row){
			$derniere_valeur_pleine = $row['valeur_heures_pleines'];
		}
		
*/		
		// Enregistrement relevé
		$sql = 'INSERT INTO Teleinfo (TIMESTAMP, ACDO, ISOUSC, PTEC, HCHC, HCHP, OPTARIF, IINST, PAPP)
			VALUES ("'.$teleinformation['timestamp'].'","'.$teleinformation['ACDO'].'", ';
		$sql .= '"'.$teleinformation['ISOUSC'].'", ';
		$sql .= '"'.$teleinformation['PTEC'].'", ';
		$sql .= '"'.$teleinformation['HCHC'].'", ';
		$sql .= '"'.$teleinformation['HCHP'].'", ';
		$sql .= '"'.$teleinformation['OPTARIF'].'", ';
		$sql .= '"'.$teleinformation['IINST'].'", ';
		$sql .= '"'.$teleinformation['PAPP'].'")';
		echo $sql;
		$sql_local->query($sql);
		

	}
	catch (Exception $e) {
		echo 'Err: '.$e."\n";	
	}
	
}
else{
	echo 'Données manquantes pour enregistrement'."\n";
}

echo "\n";
?>
