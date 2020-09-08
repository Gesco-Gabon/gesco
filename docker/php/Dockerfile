FROM php:7.4-fpm

WORKDIR /var/www/gesco

# Set timezone
ARG TIMEZONE

ARG USER=gesco
ARG UID=1000
ARG GID=1000
# default password for user
ARG PW=gesco

RUN apt-get update && apt-get install -y \
      wget \
      git \
      curl \
      unzip \
      fish

RUN apt-get update && apt-get install -y libzip-dev libicu-dev && docker-php-ext-install pdo zip intl opcache

# Support de MySQL
RUN docker-php-ext-install mysqli pdo_mysql

# Support de Postgre
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

# Xdebug
RUN pecl install xdebug-2.8.1 && docker-php-ext-enable xdebug

# Xdebug copy to config
ADD xdebug.ini /usr/local/etc/php/conf.d/

# Install Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer


# Symfony tool
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
  mv /root/.symfony/bin/symfony /usr/local/bin/symfony

ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Php.ini copy to config
ADD php.ini /etc/php/7.4/fpm/conf.d/php.ini

RUN groupadd -g 1000 gesco && useradd -u 1000 -g gesco -s /bin/bash gesco

# Switch to 'gesco'
USER gesco

EXPOSE 9000