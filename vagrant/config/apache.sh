#!/usr/bin/env bash

# Deshabilitando modulos
echo "[APACHE] Deshabilitando modulos prefork y PHP"
sudo a2dismod mpm_prefork
sudo a2dismod php5 

echo "[APACHE] Habilitando modulos worker, rewrite y actions"
sudo a2enmod mpm_worker rewrite actions proxy_fcgi

# Comprobamos que exista el directorio html
if [ ! -d "/vagrant/web" ]; then
    mkdir /vagrant/web
fi

# Comprobamos que exista el directorio logs
if [ ! -d "/vagrant/logs" ]; then
    mkdir /vagrant/logs
fi

# Creando directorios temporales
echo "Creando directorios temporales"

cp /vagrant/app/config/parameters.yml.template /vagrant/app/config/parameters.yml

# Creando VirtualHost
if ! echo "
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName dev-server 

    DocumentRoot /vagrant/web
    DirectoryIndex app.php

    <Directory /vagrant/web>

        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Require all granted
        Order Allow,Deny
        Allow from all
        
        <FilesMatch \.php$>
            SetHandler 'proxy:fcgi://127.0.0.1:9000'
        </FilesMatch>

    </Directory>

    ErrorLog /vagrant/logs/error.log
    LogLevel error
    CustomLog /vagrant/logs/access.log combined
</VirtualHost>" > /etc/apache2/sites-available/desarrollo.conf
then
    echo  "[APACHE] Hubo un error al crear el archivo de configuracion"
    exit;
else
    echo "[APACHE] Se creo el archivo de configuracion de VirtualHost"
fi

# Deshabilitando sitio por defecto
echo "[APACHE] Deshabilitando sitio por defecto"
a2dissite 000-default.conf

# Habilitando sitio de desarrollo
echo "[APACHE] Habilitando el sitio de desarrollo"
a2ensite desarrollo.conf

# Habilitando modulo Headers
a2enmod headers

# Reiniciar servidor de apache
/etc/init.d/apache2 reload
