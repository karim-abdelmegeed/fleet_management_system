FROM php:7.3.2-apache

RUN  apt-get update

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apt install zip unzip php-zip


#install composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /usr/src/app

COPY . ./

EXPOSE 4000

