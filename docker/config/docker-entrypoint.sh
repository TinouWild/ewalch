#!/usr/bin/env bash
# Exécuté au démarrage du conteneur PHP, avant supervisord (php-fpm + cron).
set -euo pipefail

cd /var/www/html

if [ "${APP_ENV:-}" = "dev" ]; then
    # En dev, AssetMapper sert les fichiers sources à la volée : des assets compilés
    # dans public/assets masqueraient les modifications CSS/JS en cours.
    echo "[entrypoint] Dev : suppression des assets compilés (servis à la volée)"
    rm -rf public/assets
else
    echo "[entrypoint] Compilation des assets"
    php bin/console asset-map:compile
    # Les commandes ci-dessus tournent en root : rend le cache à php-fpm (www-data)
    chown -R www-data:www-data var
fi

exec "$@"
