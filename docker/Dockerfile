FROM php:8.2-fpm

# Supprimer l'extension OPcache
RUN docker-php-ext-configure opcache --disable-opcache

# Installez les autres dépendances
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip supervisor libzip-dev libpq-dev symfony-cli vim iputils-ping \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Installez Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn

COPY ./config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html
CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
