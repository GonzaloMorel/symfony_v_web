#!/usr/bin/env bash

# Deshabilitando sendfile para compatibilidad con Windows
echo "[NGINX] Deshabilitando Nginx para compatibilidad con Windows"
sed -i 's/sendfile on;/sendfile off;/' /etc/nginx/nginx.conf

# Configuracion para que se ejecute con el usuario Vagrant para evadir errores
echo "[NGINX] Configurando usuario para Nginx."
sed -i "s/user www-data;/user vagrant;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 64;/" /etc/nginx/nginx.conf

# Creando VirualHost
if ! echo "server {
    listen   80;
    root /vagrant/html;
    index index.php index.html index.htm;
    server_name dev-server;

    access_log /vagrant/logs/access.log;
    error_log  /vagrant/logs/error.log error;

    charset utf-8;

    # serve static files directly
    location ~* \.(jpg|jpeg|gif|css|png|js|ico|html)$ {
        access_log off;
        expires max;
    }

    location = /favicon.ico { log_not_found off; access_log off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    # catch all
    error_page 404 /index.php;

    location ~ \.php$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)\$;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }

    location ~ /\.ht {
        deny all;
    }
}" > /etc/nginx/sites-available/desarrollo.conf
then
    echo "[NGINX] Error al crear el VirtualHost de desarrollo."
    exit;
else
    echo "[NGINX] Se creo el VirtualHost de desarrollo."
fi

# Activar VirtualHost de desarrollo
echo "[NGINX] Activando VirtualHost de desarrollo."
ln -s /etc/nginx/sites-available/desarrollo.conf /etc/nginx/sites-enabled/desarrollo.conf

# Desactivar VirtualHost default
echo "[NGINX] Deshabilitando VirtualHost por defecto."
rm -f /etc/nginx/sites-enabled/default

# Configuracion de PHP-FPM para Nginx
echo "[NGINX] Configurando PHP-FPM para Nginx."
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php5/fpm/php.ini

# Reiniciando PHP-FPM
echo "[PHP-FPM] Reiniciando PHP-FPM para habilitar configuracion de Nginx"
sudo service php5-fpm restart

# Reiniciando Nginx
echo "[NGINX] Reiniciando Nginx."
service nginx restart
