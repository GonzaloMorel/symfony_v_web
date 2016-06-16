#!/usr/bin/env bash

# Para instalar MySQL sin pedir la contrasena
echo "[MYSQL] Estableciendo contrasena por defecto de root: mitopasswd"
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password mitopasswd'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password mitopasswd'

# Instalando Mysql
echo "[MYSQL] Instalando MySQL"
sudo apt-get install -qq --force-yes mysql-server
