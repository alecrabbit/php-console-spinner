FROM php:8.2-cli-alpine

ARG EXT_APCU_VERSION=5.1.22
ARG EXT_EVENT_VERSION=3.0.8
ARG EXT_GRPC_VERSION=1.46.3
ARG EXT_MONGODB_VERSION=1.15.1
ARG EXT_PROTOBUF_VERSION=3.21.0
ARG EXT_REDIS_VERSION=5.3.7
ARG EXT_UUID_VERSION=1.2.0

ARG RUN_DEPS="\
    curl \
    freetype \
    gmp \
    icu-libs \
    libbz2 \
    libffi \
    libintl \
    libjpeg-turbo \
    libpng \
    libpq \
    libuuid \
    libuv \
    libwebp \
    libxml2 \
    libxpm \
    libxslt \
    libzip \
    libzip \
    openssl \
    ttf-freefont \
    unzip \
    zlib \
    "

ARG BUILD_DEPS="\
    autoconf \
    bzip2-dev \
    cmake \
    curl-dev \
    file \
    freetype-dev \
    freetype-dev \
    g++ \
    gcc \
    gettext-dev \
    git \
    gmp-dev \
    icu-dev \
    libc-dev \
    libffi-dev  \
    libjpeg-turbo-dev \
    libpng-dev  \
    libpq-dev \
    libuv-dev \
    libwebp-dev \
    libxml2-dev \
    libxpm-dev \
    libxslt-dev \
    libzip-dev \
    libzip-dev \
    linux-headers \
    make \
    openssl-dev \
    pcre-dev \
    pkgconf \
    re2c \
    util-linux-dev \
    zlib-dev \
    "

ARG PHP_EXTENSIONS="\
    bcmath \
    ffi \
    gd \
    gmp \
    intl \
    mysqli \
    opcache \
    pcntl \
    pdo_mysql \
    pdo_pgsql \
    sockets \
    xsl \
    zip \
    "

RUN set -eux \
    && apk update \
    && apk add --no-cache \
        ${RUN_DEPS} \
    && apk add --no-cache --virtual .php-build-deps \
        ${BUILD_DEPS} \
    && docker-php-ext-configure gd \
        --disable-gd-jis-conv \
        --with-freetype=/usr \
        --with-jpeg=/usr \
        --with-webp=/usr \
        --with-xpm=/usr \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTENSIONS} \
    ## install ext-uv
    && git clone https://github.com/bwoebi/php-uv.git \
    && cd php-uv \
    && phpize \
    && ./configure \
    && make \
    && make install \
    ## /install ext-uv
    && pecl install -o -f \
        apcu-${EXT_APCU_VERSION} \
#        grpc-${EXT_GRPC_VERSION} \
        mongodb-${EXT_MONGODB_VERSION} \
#        protobuf-${EXT_PROTOBUF_VERSION} \
        redis-${EXT_REDIS_VERSION} \
        uuid-${EXT_UUID_VERSION} \
    && docker-php-ext-enable \
        apcu \
#        grpc \
        mongodb \
        redis \
#        protobuf \
        uv \
        uuid \
    && pecl clear-cache \
    && apk del --no-cache .php-build-deps \
    && rm -rfv /tmp/* \
    ## // stats
    && php -m \
    && php -v

COPY ./config/php/ /usr/local/etc/php/conf.d/
