SHELL:=/usr/bin/env bash

start:
	docker compose pull && docker compose up -d --remove-orphans --force-recreate

stop:
	docker compose down --remove-orphans

console:
	docker compose exec php bash

sniff:
	docker compose exec php bash -c "vendor/bin/phpstan --memory-limit=512M analyse"

crontab-debug:
	docker compose exec php bash -c "crontab -u root -l"
	docker compose exec php bash -c "tail /var/log/mon_cron.log"
