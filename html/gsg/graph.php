<?php
/*****************************************************************************/
/*** File   : graph.php                                                    ***/
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
<div id="txtmenubar">| <a href="index.php">Statistiques</a> |  <a href="admin.php">Administration</a> | <a href="/index.php">Retour</a> |</div>
</div> 
<div class="spacer"></div> 

<div id="main">

<!-- Chargement des variables, et paramètres de Highcharts -->
<script type="text/javascript">
	$(function () {
    $('#container').highcharts({
        chart: {
            zoomType: 'xy',
            backgroundColor: 'transparent',
        },
        title: {
            text: 'Historique',
            style: {
                    color: '#FFffFF'
                }
        },
        subtitle: {
            text: 'Prix et consommation',
            style: {
                    color: '#FFffFF'
                }
        },
        xAxis: [{
            categories: [<?php echo "$Tannee"; ?>],
            crosshair: true,
            labels: {
                style: {
                    color: '#FFffFF'
                }
            }
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value} \u20AC',
                style: {
                    color: '#FFffFF'
                }
            },
            title: {
                text: 'Cout consomm\351s',
                style: {
                    color: '#FFffFF'
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Nombre de sacs consomm\351s',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} Sacs',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 140,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#D8D8D8'
        },
        series: [{
            name: 'Nombre de sacs consomm\351s',
            type: 'column',
            yAxis: 1,
            data: [<?php echo "$Ttotalconso"; ?>],
            tooltip: {
                valueSuffix: ' Sacs'
            }

        }, {
            name: 'Cout consomm\351s',
            type: 'spline',
            data: [<?php echo "$Ttotalcout"; ?>],
            color: '#0511FC',
            tooltip: {
                valueSuffix: ' \u20AC'
            }
        }]
    });
});
</script> 

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
