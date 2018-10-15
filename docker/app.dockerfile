FROM php:7.1-fpm-jessie

RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client \
    && docker-php-ext-install mcrypt pdo_mysql zip

RUN apt-get update && apt-get install -y --no-install-recommends gcc make libpng-dev

RUN apt-get update && apt-get install -y vim

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash
RUN apt-get install -y nodejs

RUN php -r "copy('https://getcomposer.org/installer', 'installer.php');"
RUN php -r "if (hash_file('SHA384', 'installer.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php installer.php
RUN php -r "unlink('installer.php');"
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www