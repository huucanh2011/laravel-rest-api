FROM alpine:3.18

LABEL maintainer="Toploop"

WORKDIR /var/www/html

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache zip unzip curl nginx supervisor git

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing php
RUN apk add --no-cache php82 \
    php82-common \
    php82-fpm \
    php82-opcache \
    php82-zip \
    php82-phar \
    php82-iconv \
    php82-cli \
    php82-curl \
    php82-openssl \
    php82-mbstring \
    php82-tokenizer \
    php82-fileinfo \
    php82-json \
    php82-xml \
    php82-xmlwriter \
    php82-simplexml \
    php82-dom \
    php82-pdo_pgsql \
    php82-session

RUN ln -s /usr/bin/php82 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
COPY .docker/supervisord.ini /etc/supervisor.d/supervisord.ini

# Configure PHP
RUN mkdir -p /run/php/
RUN touch /run/php/php8.2-fpm.pid

COPY .docker/php-fpm.conf /etc/php82/php-fpm.conf
COPY .docker/php.ini-production /etc/php82/php.ini

# Configure nginx
COPY .docker/nginx.conf /etc/nginx
COPY .docker/nginx-laravel.conf /etc/nginx/modules/

RUN mkdir -p /run/nginx
RUN touch /run/nginx/nginx.pid

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# Building process
COPY . .
RUN composer install --ignore-platform-req=ext-session --ignore-platform-req=ext-sodium
RUN chown -R nobody:nobody /var/www/html/storage
RUN chmod +x /var/lib/nginx -R

EXPOSE 80
CMD [ "supervisord", "-c", "/etc/supervisor.d/supervisord.ini" ]
