FROM php:8.2-fpm

COPY ../../composer.lock composer.json /var/www/

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    openssl \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/* &&  \
    docker-php-ext-install pdo pdo_mysql exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=node:latest /usr/local/bin /usr/local/bin
COPY --from=node:latest /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN chown -R www:www /var/www &&  \
    chmod 755 /var/www

USER www

EXPOSE 9100
CMD ["php-fpm"]

