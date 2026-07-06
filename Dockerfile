FROM php:8.5-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        zlib1g-dev \
        g++ \
        git \
        libicu-dev \
        libzip-dev \
        zip \
        unzip \
        libpq-dev \
        supervisor \
        vim \
        iputils-ping \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl zip \
    && rm -rf /var/lib/apt/lists/*

RUN cd /tmp \
    && git clone https://github.com/krakjoe/apcu.git \
    && cd apcu \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && docker-php-ext-enable apcu \
    && rm -rf /tmp/apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get install -y symfony-cli \
    && rm -rf /var/lib/apt/lists/*

COPY docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY app /var/www/html
WORKDIR /var/www/html

CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
