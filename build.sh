docker build -t ewalch-prod_php:latest .
docker save ewalch-prod_php:latest | gzip > ewalch_latest.tar.gz
