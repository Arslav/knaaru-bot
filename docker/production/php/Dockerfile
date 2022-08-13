FROM php:8.1.9-fpm-alpine

#install packages
RUN apk update
RUN apk upgrade
RUN apk add --no-cache --quiet --no-progress \
    freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev libwebp-dev libzip-dev \
    postgresql-dev libxslt-dev icu-data-full php8-zip php8-mbstring php8-xml php8-curl php8-pdo php8-pdo_pgsql \
    php8-intl php8-pecl-imagick php8-gd php8-dom wget

#configure extenstions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp && \
    docker-php-ext-install zip \
                           pdo \
                           pdo_pgsql \
                           intl \
                           gd \
                           xsl && \
    docker-php-ext-enable zip \
                          gd

#composer installation
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet
ENV COMPOSER_ALLOW_SUPERUSER 1

#run
CMD php-fpm

