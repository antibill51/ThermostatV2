
<?php
//On crée l'objet qui gère la base de données
$usr = "root";
$pass = "2a94r7ow";
$bdd = new PDO('mysql:dbname=Thermostat;host=localhost', $usr, $pass);
 


/*
 * Partie sondes
*/
$requete = $bdd->query("SELECT Id, Designation  FROM Sondes ORDER BY Id ASC");
$requete->execute(array());
$SensorList = array();
$cpt = 0;
while($donnees = $requete->fetch())
{
    $id = $donnees["Id"];
    $des = $donnees["Designation"];
    $SensorList[$cpt]['device_id'] = $id;
    $SensorList[$cpt]['designation'] = $des;
//echo implode(',', $SensorList[$cpt]);
    $cpt++;
}


for ($i = 0; $i < sizeof($SensorList); $i++) { // pour le nombre de sondes on fait
$sensor = $SensorList[$i]['device_id'];
$des = $SensorList[$i]['designation'];
//echo $i;
/*
 * Partie Température
 */
//On prépare la requête de récupération
$requete = $bdd->prepare("SELECT Temperature, Date FROM Temperature WHERE Id = :nom ORDER BY Date ASC");
 
//On l'exécute en lui passant les bons paramètres
$requete->execute(array("nom" => $sensor));
 
//On boucle sur les données récupérés et on les stocke dans un tableau que l'on pourra passer au javascript
$dataTemp = array();
$dataConsigne = array();
$designation = array();
$designation[$i] = "Température ".$des;
//echo $designation[$i];

while($donnees = $requete->fetch())
{
    $temp = $donnees["Temperature"];
    $date = $donnees["Date"]*1000;
//    $dataTemp[$sensor] = "[$date, $temp]";
    $dataTemp[$i][] = "[$date, $temp]"; 
//echo $dataTemp;
}
//$dataConsigne[] = $dataTemp[$sensor];
//echo implode(',', $dataTemp[$i]);
//echo $dataTemp[$i];
//echo '<pre>'; print_r($dataTemp); echo '</pre>';
} 

?>
<!DOCTYPE HTML>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Interface utilisateur domotique</title>
         
        <!-- On a besoin de JQuery, alors on l'importe à partir d'un dépôt externe -->
        <script src="jquery.min.js"></script>         
        <!-- On importe la bibliothèque de tracé de graphe -->
        <script src="highstock.js"></script>
         
        <!-- Le script JS qui va générer le graphe -->
        <script type="text/javascript">
            //Fonction de JQUERY permettant d'exécuter ce bloc de code quand la page est fini de charger
            $(function () 
            { 
Highcharts.setOptions({
	lang: {
		months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
		weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		shortMonths: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil','Août', 'Sept', 'Oct', 'Nov', 'Déc'],
		decimalPoint: ','
	}
});
                //On créé le graphique
                $('#container').highcharts('StockChart',
                {
legend: {
	    	enabled: true,
	    	align: 'top',
	    	layout: 'horizontal',
	    	verticalAlign: 'top',
	    	y: 10,
            x: 20,
	    	shadow: true
	    },
rangeSelector: {
                buttons: [{
                        type: 'day',
                        count: 1,
                        text: '24h'
                    }, {
                        type: 'day',
                        count: 7,
                        text: '7j'
                    }, {
                        type: 'month',
                        count: 1,
                        text: '1 m'
                    }, {
                        type: 'month',
                        count: 3,
                        text: '3 m'
                    }, {
                        type: 'month',
                        count: 6,
                        text: '6 m'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1 an'
                    }, {
                        type: 'all',
                        text: 'Tout'
                    }],
                selected: 0
            },
		    chart: 
                    {
                        //Type: courbe
                        type: 'spline'
                    },
                    title: 
                    {
                        //Le titre
                        text: 'Courbes de températures'
                    },
                    navigator:
                    {
                        //On affiche la barre de navigation en dessous
                        enabled: true
                    },
                    xAxis: 
                    {
                        //Le format des données en abscisse
                        type: 'datetime'
                    },
                    yAxis:[ 
                    {
                        //Le titre du premiere axe des ordonnées
                        title: 
                        {
                            text: 'Températures'
                        }
                    },{
                        //Le titre du second axe des ordonnées
                        title:
                        {
                            text: 'Consignes'
                        },
                        //Le second axe est-il de l'autre côté
                        opposite: false
                    }],
                    //Les données qu'on affiche
                    series: [{
                        //L'axe auquel les données correspondent (ici température)
                        yAxis: 0,
                         
                        //Le titre de la série de données
                        name: 'Température',
                         
                        //Les données
                        data: [<?php echo implode(',', $dataTemp[0]); ?>],
                         
                        //La couleur de la courbe de la série
                        color: '#b65132',
                         
                        tooltip:
                        {
                            //Nombre de décimales affichées lorsqu'on survol la courbe avec la souris
				valueDecimals: 2
                        }
                    },{
                        //L'axe auquel les données correspondent (ici humidité)
                        yAxis: 1,
                        //Le titre de la série de données
                        name: 'Consignes',
                         
                        //Les données
                        data: [<?php echo implode(',', $dataTemp[1]); ?>],
                         
                        tooltip:
                        {
                            //Le nombre de décimales affichées au survol de la courbe avec la souris
				valueDecimals: 2
                        }
                    }]
                });
            });
        </script>
    </head>
    <body>
        <div id="boutons">
            <?php
            //On dessine autant de boutons qu'il n'y a de capteurs
            foreach($sensors as $k => $s)
            {
                /* On crée un lien permettant de passer des paramètres à la page via l'url 
                 * (ici on choisit l'identifiant du capteur en cours de visualisation)
                 */
                echo '<a href="?sensor='.$s.'"><input type="button" value="'.$k.'"</a>';
 
            }
            php?>
        </div>
        <div id="container" style="width:100%; height:400px;"></div>
    </body>
</html>
