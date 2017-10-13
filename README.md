# ThermostatV2



Crontab : 

*/1 * * * * /var/bin/gettemp.py 28-000004538544 /var/bin/temp-rdc

*/1 * * * * /var/bin/gettemp.py 28-041680ddedff /var/bin/temp-1

*/1 * * * * /var/bin/gettemp.py 28-031680ddd7ff /var/bin/temp-2

*/5 * * * * php5 /var/bin/gettemp.php 

*/1 * * * * php /home/pi/teleinfo.php

0 14 * * * php /var/www/html/gsg/config/cron.php

* * * * * /home/pi/verif.sh > /dev/null 2>&1

*/1 * * * * /usr/local/bin/checkwifi.sh >> /dev/null 2>&1

*/30 * * * * /home/pi/niveau.sh

