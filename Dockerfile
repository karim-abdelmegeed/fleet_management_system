FROM php:7.3.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils \
        libzip-dev \
        libpng-dev \
        zlib1g-dev \
        curl \
        build-essential \
        libssl-dev \
        libfreetype6-dev \
        nano \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmcrypt-dev \
        libicu-dev \
        libxml2-dev \
        libwebp-dev \
        zlib1g-dev \
        zip \
        unzip

RUN docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


#install composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /usr/src/app

COPY . ./

EXPOSE 4000

