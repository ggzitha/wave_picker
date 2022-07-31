# wave_picker


install first dependency 

- Python 3
```console
apt-get install python3 python3-pip
```
- Python Module
```console
python3 -m pip install obspy matplotlib scipy numpy pandas
```


and install a web server, php

if used docker then, on docker-compose.yml
```console
# Version
version: '3.1'

# Setup
services:
  # PHP
  php:
    image: kenconex/picker_mseed_web:v666
    restart: always
    build: 
      context: ./
      dockerfile: Dockerfile
    ports:
      - 5000:80
```
Dockerfile:

```console
FROM ubuntu:20.04
ENV DEBIAN_FRONTEND=noninteractive

LABEL LABEL maintainer="Lucx <kenconex@gmail.com>"

RUN apt-get update

# Install ppa:ondrej/php PPA Move to top, Try it
RUN apt-get install -y --no-install-recommends software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

# Install Utilities
# RUN apt-get install -y curl unzip build-essential nano wget mcrypt
# RUN apt-get -qq update && apt-get -qq -y install bzip2
# RUN apt-get install -y chrpath libssl-dev libxft-dev
# RUN apt-get install -y libfreetype6 libfreetype6-dev libfontconfig1 libfontconfig1-dev

# Install Python pip obspy dll tanpa django dan flask errorr here need from pip
# RUN apt-get install -y --no-install-recommends python3 python3-pip python3-obspy python3-matplotlib python3-scipy python3-numpy python3-pandas
RUN apt-get install -y --no-install-recommends python3 python3-pip git
RUN python3 -m pip install obspy matplotlib scipy numpy pandas

# Install PHP 8
RUN apt-get install -y apache2
RUN apt-get install -y --no-install-recommends php-pear libapache2-mod-php8.1
RUN apt-get install -y --no-install-recommends php8.1-common php8.1-cli
RUN apt-get install -y --no-install-recommends php8.1-bz2 php8.1-zip php8.1-curl php8.1-gd php8.1-mysql php8.1-xml php8.1-dev php8.1-sqlite php8.1-mbstring php8.1-bcmath
RUN php -v
RUN php -m

# PHP Config
# Show PHP errors on development server.
RUN sed -i -e 's/^error_reporting\s*=.*/error_reporting = E_ALL/' /etc/php/8.1/apache2/php.ini
RUN sed -i -e 's/^display_errors\s*=.*/display_errors = Off/' /etc/php/8.1/apache2/php.ini
RUN sed -i -e 's/^zlib.output_compression\s*=.*/zlib.output_compression = On/' /etc/php/8.1/apache2/php.ini
RUN sed -i -e 's/^zpost_max_size\s*=.*/post_max_size = 50M/' /etc/php/8.1/apache2/php.ini
RUN sed -i -e 's/^upload_max_filesize\s*=.*/upload_max_filesize = 50M/' /etc/php/8.1/apache2/php.ini
RUN sed -i -e 's/^memory_limit\s*=.*/memory_limit = 4096M/' /etc/php/8.1/apache2/php.ini

# Apache Config
# Allow .htaccess with RewriteEngine.
RUN a2enmod rewrite

# Without the following line we get "AH00558: apache2: Could not reliably determine the server's fully qualified domain name".
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Authorise .htaccess files.
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN sed -i '/<Directory \/var\/www\/\/html\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN rm -rf /var/www/html
RUN mkdir /var/www/html

#then remove test file
RUN echo "test" > /var/www/html/index.html
RUN rm /var/www/html/index.html 

RUN cd /var/www/html
RUN git clone https://github.com/ggzitha/wave_picker.git
RUN mv /var/www/html/wave_picker/* /var/www/html/
RUN rm -rf /var/www/html/wave_picker

RUN echo "<?php phpinfo ();?>" > /var/www/html/php_info.php
RUN chmod -R 777 /var/www/html/

# Ports
EXPOSE 80
EXPOSE 443

# Start Apache2 on image start.
CMD ["/usr/sbin/apache2ctl", "-DFOREGROUND"]

# Purge old PHP
RUN apt-get -y purge '^php7.4.*'
RUN apt-get -y purge '^php8.0.*'
RUN php -v

RUN apt clean 
```


