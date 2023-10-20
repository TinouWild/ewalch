FROM php:8.2-fpm

RUN echo 'toto'
# Installez le démon cron
RUN apt-get update \
    && apt-get install -y cron \
    && rm -rf /var/lib/apt/lists/*

# Configurez le démon cron
COPY docker/config/root.txt /etc/cron.d/root.txt
RUN chmod 0644 /etc/cron.d/root.txt

RUN service cron start
RUN crontab /etc/cron.d/root.txt

# Installez les autres dépendances
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip supervisor libzip-dev zip libpq-dev symfony-cli vim iputils-ping \
    && docker-php-ext-install intl opcache pdo pdo_mysql pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Installez Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn

COPY docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY app /var/www/html
WORKDIR /var/www/html

RUN yarn dev
COPY app/public/images /var/www/html/public/
CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
