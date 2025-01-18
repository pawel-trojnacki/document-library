FROM php:8.3-fpm-alpine

# Add install-php-extensions package
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Copy php.ini
COPY ./docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

# Install libraries
RUN apk add --no-cache \
    acl \
    bash \
    fcgi \
    file \
    gettext \
    git \
    openssl-dev \
    ;

# Add PHP extenstions
RUN set -eux; \
    install-php-extensions \
    intl \
    zip \
    apcu \
    opcache \
    pdo \
    pdo_mysql \
    soap \
    exif \
    ;

WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setup Xdebug
ENV XDEBUG_MODE=off
COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN set -eux; \
    install-php-extensions xdebug