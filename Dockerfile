FROM php:7.4-apache

# `php:7.4-apache` is built on Debian bullseye, which is archived, so the
# live apt mirrors no longer serve consistent package versions. Pin apt to
# the frozen snapshot the base image itself references (see its sources.list).
RUN set -eux; \
    printf '%s\n' \
        'deb http://snapshot.debian.org/archive/debian/20221114T000000Z bullseye main' \
        'deb http://snapshot.debian.org/archive/debian-security/20221114T000000Z bullseye-security main' \
        'deb http://snapshot.debian.org/archive/debian/20221114T000000Z bullseye-updates main' \
        > /etc/apt/sources.list; \
    apt-get -o Acquire::Check-Valid-Until=false update; \
    apt-get install -y --no-install-recommends \
        libicu-dev \
        libonig-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libzip-dev \
        unzip; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" \
        mysqli pdo_mysql mbstring gd zip intl; \
    a2enmod rewrite headers; \
    rm -rf /var/lib/apt/lists/*

# Apache + PHP configuration for the app.
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/entrypoint.sh /usr/local/bin/app-entrypoint.sh
RUN chmod +x /usr/local/bin/app-entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/app-entrypoint.sh"]
CMD ["apache2-foreground"]
