#!/usr/bin/env bash
# Exécuté au démarrage du conteneur PHP, avant supervisord (php-fpm + cron).
set -euo pipefail

cd /var/www/html

# La base peut démarrer après PHP : on l'attend avant de lancer les migrations (~60 s max)
echo "[entrypoint] Attente de la base de données..."
for i in $(seq 1 30); do
    if php bin/console dbal:run-sql "SELECT 1" >/dev/null 2>&1; then
        break
    fi
    if [ "$i" -eq 30 ]; then
        echo "[entrypoint] Base de données injoignable, abandon." >&2
        exit 1
    fi
    sleep 2
done

echo "[entrypoint] Migrations Doctrine"
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

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
