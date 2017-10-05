<html>
        <head>
                        <meta charset="UTF-8" />
                        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
                        <title>Thermostat</title>
                        <link href="css/style.css" rel="stylesheet" type="text/css" />
                        <meta name="Thermostat" content="Thermostat" />
        </head>

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
        <div>
            <img src="munin/localdomain/localhost.localdomain/niveau_niveau-day.png" alt="myPic" />
        </div>


</body>
</div>
</html>


