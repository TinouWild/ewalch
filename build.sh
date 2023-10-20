docker build -t ewalch-prod_php:latest .
docker save ewalch-prod_php:latest | gzip > ewalch_latest.tar.gz
scp ewalch_latest.tar.gz ubuntu@217.182.71.207:/ewalch/ewalch_latest.tar.gz
