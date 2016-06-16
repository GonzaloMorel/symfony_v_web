#!/usr/bin/env bash

# Instalacion de Nginx
echo "[NGINX] Instalando Nginx."
sudo apt-get install -qq --force-yes nginx

# Anadiendo a vagrant al grupo www-data
echo "[NGINX] Anadiendo usuario vagrant al grupo www-data"
usermod -a -G www-data vagrant
