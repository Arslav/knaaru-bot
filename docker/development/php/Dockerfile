FROM knaaru-bot/php

COPY ./app/ /web/app/
COPY ./docker/development/php/devinstall.sh ./devinstall.sh

#install xdebug
RUN apk add --no-cache autoconf g++ make && \
    echo "Installing xdebug..." && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    echo "xdebug has been installed" && \
    echo "Add configurations xdebug to php.ini file..." && \
    echo 'xdebug.mode=debug,coverage' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo 'xdebug.client_port=9015' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo 'session.save_path = "/tmp"' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug configurations has been added"

WORKDIR /web/app
RUN chmod u+x /web/app/bin/console
RUN chmod u+x /web/app/bin/doctrine