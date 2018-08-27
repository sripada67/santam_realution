FROM php:apache

RUN apt-get update && \
	apt-get install -y zlib1g-dev libxml2-dev cron zip nano \
 	&& docker-php-ext-install pdo pdo_mysql xmlrpc

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/santam/

COPY ./ ./

RUN chmod 755 /var/www/html/santam/

RUN composer update

# Add crontab file in the cron directory
ADD crontab /etc/cron.d/app
 
# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/app

# enable mod_rewrite
RUN a2enmod rewrite

RUN touch /var/log/cron.log

CMD cron && tail -f /var/log/cron.log

RUN chmod +x /var/www/html/santam/run.sh

ENTRYPOINT ["/var/www/html/santam/run.sh"]
