FROM ghcr.io/devgine/composer-php:v2-php8.3-alpine

LABEL maintainer="Denis Yepbro"

ARG WWWGROUP=1000
ARG WWWUSER=1000

WORKDIR /var/www/html

USER root

RUN apk add --no-cache bash shadow icu-data-full icu-dev && \
    docker-php-ext-install intl && \
    getent group sail >/dev/null || addgroup -g $WWWGROUP sail && \
    getent passwd sail >/dev/null || adduser -u $WWWUSER -S -G sail sail && \
    chown -R $WWWUSER:$WWWGROUP /var/www/html

USER $WWWUSER

SHELL ["/bin/bash", "-c"]
