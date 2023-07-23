FROM php:7.3-rc-apache-stretch
RUN a2enmod rewrite
COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/bin/

RUN apt update && apt install git unzip -yq && \
    apt-get clean autoclean; apt-get autoremove --yes; rm -rf /var/lib/{apt,dpkg,cache,log}/

RUN install-php-extensions gd pdo_mysql