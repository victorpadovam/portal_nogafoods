#!/bin/bash
(crontab -l | grep -v "/usr/local/bin/php /home/nogafoodsbr/public_html/portal.nogafoods.com.br/artisan dm:disbursement") | crontab -

(crontab -l | grep -v "/usr/local/bin/php /home/nogafoodsbr/public_html/portal.nogafoods.com.br/artisan store:disbursement") | crontab -

