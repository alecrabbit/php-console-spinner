# Note: This Dockerfile creates a general purpose development image.
FROM php:8.2-cli-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

ARG EXT_APCU_VERSION=5.1.22
ARG EXT_EVENT_VERSION=3.0.8
ARG EXT_MONGODB_VERSION=1.15.1
ARG EXT_REDIS_VERSION=5.3.7
ARG EXT_UUID_VERSION=1.2.0
ARG EXT_XDEBUG_VERSION=3.2.0

ARG WORKING_DIR=/app

ARG COMPOSER_HOME=/tmp/composer

ARG PHIVE_VERSION_KEY=0x6AF725270AB81E04D79442549D8A98B29B2D5D79

ARG COMPOSER_UNUSED_KEY=0xD969E61026434DFE4D641764F4D32E2C9343B2AE
ARG DEPTRAC_VERSION_KEY=0x41DDE07547459FAECFA17813B8F640134AB1782E
ARG ERGEBNIS_COMPOSER_NORMALIZE_KEY=0x0FDE18AE1D09E19F60F6B1CBC00543248C87FB13
ARG PHP_CODESNIFFER_KEY=0xA972B9ABB95D0B760B51442231C7E470E2138192
ARG PHP_CS_FIXER_VERSION_KEY=0xBBAB5DF0A0D6672989CF1869E82B2FB314E9906E
ARG PHPLOC_VERSION_KEY=0x4AA394086372C20A
ARG PSALM_VERSION_KEY=0x2DE50EB60C013FFFA831040D12CE0F1D262429A5

ARG COMPOSER_PACKAGES="\
    "

ARG TOOLS="\
    bash \
    coreutils\
    curl \
    git \
    gnupg \
    nano \
    graphviz \
    "

ARG RUN_DEPS="\
    ${TOOLS} \
    curl \
    freetype \
    gcompat \
    gmp \
    icu-libs \
    libbz2 \
    libevent \
    libffi \
    libintl \
    libjpeg-turbo \
    libpng \
    libpq \
    libuuid \
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
    g++ \
    gcc \
    gettext-dev \
    git \
    gmp-dev \
    icu-dev \
    libc-dev \
    libevent-dev \
    libffi-dev  \
    libjpeg-turbo-dev \
    libpng-dev  \
    libpq-dev \
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

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME ${COMPOSER_HOME}

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
    && pecl install xdebug-${EXT_XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && pecl install -o -f \
        apcu-${EXT_APCU_VERSION} \
        mongodb-${EXT_MONGODB_VERSION} \
        redis-${EXT_REDIS_VERSION} \
        uuid-${EXT_UUID_VERSION} \
    && docker-php-ext-enable \
        apcu \
        mongodb \
        redis \
        uuid \
    && pecl install -o -f event-${EXT_EVENT_VERSION} \
    && docker-php-ext-enable --ini-name zz-event.ini event \
    && pecl clear-cache \
    && rm -rfv \
        /tmp/* \
        /home/user \
    && mkdir -p \
        /home/user \
        ${COMPOSER_HOME} \
    && chmod 777 /home/user ${COMPOSER_HOME} \
    && composer --no-interaction global --prefer-stable \
        --optimize-autoloader require \
        ${COMPOSER_PACKAGES} \
    && composer clear-cache \
    && chmod -R 777 /home/user ${COMPOSER_HOME} \
    ## // install PHIVE \
    && wget -O phive.phar "https://phar.io/releases/phive.phar" \
    && wget -O phive.phar.asc "https://phar.io/releases/phive.phar.asc" \
    && gpg --keyserver hkps://keys.openpgp.org --recv-keys ${PHIVE_VERSION_KEY} \
    && gpg --verify phive.phar.asc phive.phar \
    && rm phive.phar.asc \
    && chmod +x phive.phar \
    && mv phive.phar /usr/local/bin/phive \
    ## // install PHPLOC
    && phive install phploc --trust-gpg-keys ${PHPLOC_VERSION_KEY} --target /usr/local/bin \
    ## // install composer-unused \
    && phive install composer-unused --trust-gpg-keys ${COMPOSER_UNUSED_KEY} --target /usr/local/bin \
    ## // install deptrac \
    && phive install deptrac --trust-gpg-keys ${DEPTRAC_VERSION_KEY} --target /usr/local/bin \
    ## // install php-cs-fixer \
    && phive install php-cs-fixer --trust-gpg-keys ${PHP_CS_FIXER_VERSION_KEY} --target /usr/local/bin \
    ## // install psalm \
    && phive install psalm --trust-gpg-keys ${PSALM_VERSION_KEY} --target /usr/local/bin \
    ## // install phpcs \
    && phive install phpcs --trust-gpg-keys ${PHP_CODESNIFFER_KEY} --target /usr/local/bin \
    ## // install phpcbf \
    && phive install phpcbf --trust-gpg-keys ${PHP_CODESNIFFER_KEY} --target /usr/local/bin \
    ## // install ergebnis/composer-normalize \
    && phive install ergebnis/composer-normalize \
    --trust-gpg-keys ${ERGEBNIS_COMPOSER_NORMALIZE_KEY} --target /usr/local/bin \
    ## // cleanup
    && apk del --no-cache .php-build-deps \
    && rm -rf ${COMPOSER_HOME}/.htaccess ${COMPOSER_HOME}/cache \
    && rm -rfv /tmp/* \
    ## // stats
    && php -m \
    && php -v

COPY config/php/ /usr/local/etc/php/conf.d/

ENV PATH ${COMPOSER_HOME}/vendor/bin:${PATH}
