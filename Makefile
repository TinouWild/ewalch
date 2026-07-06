SHELL:=/usr/bin/env bash

COMPOSE=docker compose -f docker/docker-compose.yml

start:
	$(COMPOSE) pull --ignore-buildable && $(COMPOSE) up -d --remove-orphans --force-recreate

stop:
	$(COMPOSE) down --remove-orphans

build:
	$(COMPOSE) build --no-cache php

console:
	$(COMPOSE) exec php bash

sniff:
	$(COMPOSE) exec php bash -c "vendor/bin/phpstan --memory-limit=512M analyse"

crontab-debug:
	$(COMPOSE) exec php bash -c "crontab -u root -l"
	$(COMPOSE) exec php bash -c "tail /var/log/mon_cron.log"
