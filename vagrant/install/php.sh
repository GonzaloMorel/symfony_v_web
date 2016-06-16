#!/usr/bin/env bash

# Se instalara PHP y sus extensiones
echo "[PHP] Instalando PHP y sus extensiones"
sudo apt-get install -qq --force-yes libapache2-mod-php5 php5-cli php5-fpm php5-mysql php5-pgsql php5-sqlite php5-curl php5-gd php5-geoip php5-json php5-gmp php5-mcrypt php5-memcached php5-imagick php5-intl php5-xdebug
