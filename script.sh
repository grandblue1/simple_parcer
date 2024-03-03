#!/bin/bash

cd .docker

docker compose up -d 

CRON_JOB="0 0 * * * docker exec php /usr/bin/php /var/www/src/PriceTrackerCronJob"
CRON_TEMP_FILE=$(mktemp)
echo "$CRON_JOB" > $CRON_TEMP_FILE

crontab $CRON_TEMP_FILE
rm $CRON_TEMP_FILE

echo "Server started"