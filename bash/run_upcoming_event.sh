#! /bin/sh

while [ true ]
do
	#/usr/bin/php /var/www/webapp/TopBetWebApp/src/cli/GetUpcomingEventsCli.php;
	/usr/bin/php ../GetUpcomingEventsCli.php;
	sleep 60;
done
