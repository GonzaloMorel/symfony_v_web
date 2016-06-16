#!/usr/bin/env bash

# Instalandc Apache2
echo "[APACHE] Instalando Apache2"
sudo apt-get install -qq --force-yes apache2
sudo apt-get install -qq --force-yes apache2-mpm-event

# Anadimos el usuario vagrant al grupo www-data
echo "[APACHE] Anadiendo usuario vagrant al grupo www-data"
sudo usermod -a -G www-data vagrant
