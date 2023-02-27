FROM php:8.2-alpine

WORKDIR /app

## How to install php ext-event

ARG PHP_EXTENSIONS="\
    sockets \
    "

RUN apk add --no-cache --virtual .build-deps \
        autoconf \
        linux-headers \
        git \
        automake \
        gcc \
        libc-dev \
        make \
        libevent-dev \
        libressl-dev \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTENSIONS} \
    && php -m \
    && pecl install -o -f event-3.0.8 \
    && docker-php-ext-enable --ini-name zz-event.ini event \
    && php -v \
    && php -m \
    && apk del .build-deps

## How to install php ext-uv

#RUN apk add --no-cache --virtual .build-deps \
#        autoconf \
#        git \
#        automake \
#        gcc \
#        libc-dev \
#        make \
#        libuv-dev \
#        libressl-dev \
#    && git clone https://github.com/bwoebi/php-uv.git \
#    && cd php-uv \
#    && phpize \
#    && ./configure \
#    && make \
#    && make install \
#    && docker-php-ext-enable uv \
#    && php -v \
#    && php -m \
#    && apk del .build-deps

COPY . /app