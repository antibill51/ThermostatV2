<?php
/*****************************************************************************/
/*** File   : index.php                                                    ***/
/*** Author : R.SYREK                                                      ***/
/*** WWW    : http://domotique-home.fr                                     ***/
/*** Note   : Statiqtiques file                                            ***/
/*****************************************************************************/
include_once('config/json.php');
?> 
<html>
<head>
<title>Consommation annuelle de Granul&#233;s</title>
<link href="css/style.css" media="all" rel="stylesheet" type="text/css" />

<!-- Chargement des librairies: Jquery & highcharts -->
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type="text/javascript" src="js/highcharts.js" ></script>
<script type="text/javascript" src="js/modules/exporting.js"></script>
<script type="text/javascript" src="js/send_data.js"></script>
</head>

<body>
<div id="Pcontainer">
<div id="topbar"><div id="topbarcentre"><h1>Consommation annuelle de Granul&eacute;s</h1></div></div> 
<div class="spacer"></div>   
 
<div id="menubar">
<div id="txtmenubar">| <a href="graph.php">Historique</a> | <a href="admin.php">Administration</a> | <a href="/index.php">Retour</a> |</div>
</div> 
<div class="spacer"></div> 

<div id="main">

<!-- Affichage de toutes les entrées de la table -->
<div id="column_left">
<div id="menucolumne"><div id="txtNoir">&curren; Consomation mensuelle</div> </div>
<div id="tabMois">
<?php foreach($array as $cle=>$valeur) { ;?>
  <div class="row">
    <span class="cell"><?php echo $cle; ?></span>
    <span class="cell">
    <?php 
    if ($valeur > 1){
    $valeur = $valeur. " sacs";
    } 
    else {
    $valeur = $valeur. " sac";
    }
    echo $valeur; 
    ?>
    </span>
  </div>
  <?php };?>
  <div class="row">
    <span class="cell"><i>Total</i></span>
    <span class="cell"><i><?php 
    if ($TotalSacConsomes > 1){
    $TotalSacConsomes = $TotalSacConsomes. " sacs";
    } 
    else {
    $TotalSacConsomes = $TotalSacConsomes. " sac";
    }
    echo $TotalSacConsomes; 
    ?>
    </i></span>
  </div>
</div>
</div>

<!-- Affichage du compte rendu -->
<div id="column_right"><div id="menucolumne"><div id="txtNoir">&curren; Statistiques</div> </div>
<div id="tabMois" >
<div class="row">
<span class="cell"><i>Ann&#233;e</i></span>
<span class="cell"><select id="selection">
<?php
   $fin = count($annees);
    foreach ($annees as $value) 
    {
    if ($value != $annees_list) 
    {
    echo '<option value="'.$value.' " >'.$value.'</option>' ;
    }
    
    if ($value = $annees_list) 
    {
    echo '<option value="'.$value.' " selected>'.$value.'</option>' ;
    }
    }
?>
</select></span>
</div>
<div class="row">
    <span class="cell"><i>Total Stock</i></span>
    <span class="cell"><?php echo ($stockini + $reliquat); ?> sacs</span>
</div>
<div class="row">
    <span class="cell"><i>Cout Stock</i></span>
    <span class="cell"><?php echo round(($reliquat*$prixsacAV)+($stockini*$prixsac), 2); ?> &euro;</span>
</div>
<div class="row">
    <span class="cell"><i>Consomm&#233;s</i></span>
    <span class="cell"><?php echo $TotalSacConsomes; ?></span>
</div>
<div class="row">
    <span class="cell"><i>Cout consomm&#233;</i></span>
    <span class="cell"><?php echo round($CoutConsome, 2); ?> &euro;</span>
</div>
<div class="row">
    <span class="cell"><i>Sacs restants</i></span>
    <span class="cell"><?php echo $stockini+$reliquat-$TotalSacConsomes; ?> sacs</span>
</div>
<div class="row">
    <span class="cell"><i>Moyenne sur 12 mois</i></span>
    <span class="cell"><?php echo round($TotalSacConsomes/12, 2); ?> sacs</span>
</div>
<div class="row">
    <span class="cell"><i>Cout sur 12 mois</i></span>
    <span class="cell"><?php echo round($CoutConsome/12, 2); ?> &euro;</span>
</div>
<div class="row">
    <span class="cell"><i>Moyenne sur p&#233;riode</i></span>
    <span class="cell"><?php if ($compteur != 0){echo round($TotalSacConsomes/$compteur, 2);} else {echo '-';} ?> sacs</span>
</div>
<div class="row">
    <span class="cell"><i>Cout sur p&#233;riode</i></span>
    <span class="cell"><?php if ($compteur != 0){echo round($CoutConsome/$compteur, 2);} else {echo '-';} ?> &euro;</span>
</div>
</div>
    </div>







<!-- Chargement des variables, et paramètres de Highcharts -->
<script type="text/javascript">
	$(function () {
    var chart;
    $(document).ready(function() {

		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] 
		        ]
		    };
		});

        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                backgroundColor: 'transparent',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
            text: <?php echo "'Pourcentage $annees_list '";?>,
            style: {
                color: '#FFffFF',
                fontWeight: 'bold'
                    }
            },
            tooltip: {
        	    pointFormat: '<b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#ffffff',
                        connectorColor: '#ffffff',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '',
                data: [
                    <?php  $jan = $array["Janvier $annees_list"]; if ($jan != 0) echo "['Janvier',    $jan],"; ?>
                    <?php  $fev = $array["Fevrier $annees_list"]; if ($fev != 0) echo "['Fevrier',    $fev],"; ?>
                    <?php  $mar = $array["Mars $annees_list"]; if ($mar != 0) echo "['Mars',    $mar],"; ?>
                    <?php  $ave = $array["Avril $annees_list"]; if ($ave != 0) echo "['Avril',    $ave],"; ?>
                    <?php  $mai = $array["Mai $annees_list"]; if ($mai != 0) echo "['Mai',    $mai],"; ?>
                    <?php  $jui = $array["Juin $annees_list"]; if ($jui != 0) echo "['Juin',    $jui],"; ?>
                    <?php  $jul = $array["Juillet $annees_list"]; if ($jul != 0) echo "['Juillet',    $jul],"; ?>
                    <?php  $aou = $array["Aout $annees_list"]; if ($aou != 0) echo "['Aout',    $aou],"; ?>
                    <?php  $sep = $array["Septembre $annees_list"]; if ($sep != 0) echo "['Septembre',    $sep],"; ?>
                    <?php  $oct = $array["Octobre $annees_list"]; if ($oct != 0) echo "['Octobre',    $oct],"; ?>
                    <?php  $nov = $array["Novembre $annees_list"]; if ($nov != 0) echo "['Novembre',    $nov],"; ?>
                    <?php  $dec = $array["Decembre $annees_list"]; if ($dec != 0) echo "['Decembre',    $dec],"; ?>
                ]
            }]
        });
    });

});</script> 

<!-- Affichage du graphique -->
<div class="spacer"></div>
<div id="navbar"><div id="menunavbar"><div id="txtNoir">&curren; Graphique</div> </div>
<div id="container" style="width:800px; "></div></div> 
<div class="spacer"></div>
 
<!-- Affichage footer -->
<div id="footer">
<?php include_once('footer.php');?>
</div>
<div class="spacer"></div>
</div></div>
</body>
</html>
<?php
mysql_free_result($Stats);
?>
