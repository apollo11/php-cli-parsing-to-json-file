#! /bin/sh

while [ true ]
do 

	/usr/bin/php ../GetParlayChallengerCli.php;
	/usr/bin/php ../GetTeaserChallengerCli.php;

	#/usr/bin/php /tb-dev-0.apsgrp.com/default/docroot/src/cli/GetParlayChallengerCli.php;
	#/usr/bin/php /tb-dev-0.apsgrp.com/default/docroot/src/cli/GetTeaserChallengerCli.php;
	sleep 6;
done
