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

# Xdebug
RUN pecl install xdebug-2.8.1 && docker-php-ext-enable xdebug

# Xdebug copy to config
ADD xdebug.ini /usr/local/etc/php/conf.d/

# Install Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer

ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Php.ini copy to config
ADD php.ini /etc/php/7.4/fpm/conf.d/php.ini



# Create a user group 'gesco'
# RUN addgroup gesco
# RUN useradd -c 'creating gesco user...' -g gesco -d /var/www/gesco -s /bin/false gesco

# Create a user 'gesco' under 'gesco'
# RUN adduser -S -D -h /var/www/gesco gesco gesco

# Chown all the files to the app user.
# RUN chown -R gesco:gesco /var/www/gesco
RUN groupadd -g 1000 gesco && useradd -u 1000 -g gesco -s /bin/bash gesco

# RUN adduser -D -s /bin/sh gesco

# Switch to 'gesco'
USER gesco

# Using unencrypted password/ specifying password
# RUN useradd -m ${USER} --uid=${UID} && echo "${USER}:${PW}" | \ chpasswd


# RUN addgroup -S www-data \
#    && adduser -S -G www-data www-data

# RUN useradd -ms /bin/bash gesco
# USER gesco

# RUN groupadd gesco
# RUN adduser gesco gesco
# USER gesco
# RUN gpasswd -a $USER gesco
# RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID gesco

# RUN useradd -d /home/gesco -m gesco

EXPOSE 9000