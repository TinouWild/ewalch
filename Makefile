SHELL:=/usr/bin/env bash

COMPOSE=docker compose -f docker/docker-compose.yml

start:
	$(COMPOSE) pull && $(COMPOSE) up -d --remove-orphans --force-recreate

stop:
	$(COMPOSE) down --remove-orphans

build:
	$(COMPOSE) build --no-cache php

console:
	$(COMPOSE) exec ewalch-dev_php bash

sniff:
	$(COMPOSE) exec php_ewalch bash -c "vendor/bin/phpstan --memory-limit=512M analyse"

crontab-debug:
	$(COMPOSE) exec php_ewalch bash -c "crontab -u root -l"
	$(COMPOSE) exec php_ewalch bash -c "tail /var/log/mon_cron.log"
