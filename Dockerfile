FROM php:7.3-apache

WORKDIR /app

RUN apt-get update && apt remove curl libc-bin -y
RUN apt-get install -y git zip unzip wget
RUN wget https://curl.haxx.se/download/curl-7.79.0.zip && unzip curl-7.79.0.zip && rm -R /usr/local/include/curl
RUN cd curl-7.79.0 && ./configure --with-wolfssl && make install
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=. --filename=composer
RUN mv composer /usr/local/bin/

COPY composer.json composer.lock /app/

RUN composer install

RUN rm -rf /var/www/html && ln -s /app/public /var/www/html

# EXPOSE 80
