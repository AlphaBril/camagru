FROM php:7.2.2-apache

RUN apt-get update && apt-get install -y				\
		libfreetype6-dev		\
		libjpeg62-turbo-dev		\
		libgd-dev				\
		libpng-dev				\
		ssmtp

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install pdo pdo_mysql gd


COPY conf/camagru.conf /etc/apache2/sites-available/camagru.conf
COPY conf/ssmtp.conf /etc/ssmtp/ssmtp.conf
COPY html/ /var/www/html/
RUN echo "sendmail_path = /usr/sbin/ssmtp -t" >> /usr/local/etc/php/php.ini

RUN a2enmod rewrite
RUN a2ensite camagru.conf
RUN usermod -u 1000 www-data

RUN service apache2 restart
