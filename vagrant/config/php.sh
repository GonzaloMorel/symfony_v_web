#!/usr/bin/env bash

# Configuraciones para FPM
echo "[PHP] Configurando FPM"
sudo sed -i "s/listen =.*/listen = 127.0.0.1:9000/" /etc/php5/fpm/pool.d/www.conf
sudo sed -i "s/;listen.allowed_clients/listen.allowed_clients/" /etc/php5/fpm/pool.d/www.conf

sudo sed -i "s/user = www-data/user = vagrant/" /etc/php5/fpm/pool.d/www.conf
sudo sed -i "s/group = www-data/group = vagrant/" /etc/php5/fpm/pool.d/www.conf

sudo sed -i "s/listen\.owner.*/listen.owner = vagrant/" /etc/php5/fpm/pool.d/www.conf
sudo sed -i "s/listen\.group.*/listen.group = vagrant/" /etc/php5/fpm/pool.d/www.conf
sudo sed -i "s/listen\.mode.*/listen.mode = 0666/" /etc/php5/fpm/pool.d/www.conf


# Configuracion para xDebug
echo "[PHP] Configurando xDebug"
cat > $(find /etc/php5 -name xdebug.ini) << EOF
zend_extension=$(find /usr/lib/php5 -name xdebug.so)
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 9000
xdebug.scream=0
xdebug.cli_color=1
xdebug.show_local_vars=1

; var_dump display
xdebug.var_display_max_depth = 5
xdebug.var_display_max_children = 256
xdebug.var_display_max_data = 1024
EOF

# Configurando el reporte de errores
echo "[PHP] Configurando el reporte de errores"

sudo sed -ri 's/^error_reporting\s*=.*$/error_reporting = E_ALL \& ~E_STRICT/g' /etc/php5/fpm/php.ini
sudo sed -ri 's/^short_open_tag\s*=\s*Off/short_open_tag = On/g' /etc/php5/fpm/php.ini
sudo sed -ri 's/^short_open_tag\s*=\s*Off/short_open_tag = On/g' /etc/php5/apache2/php.ini

if [ "$1" = "si" ]; then
    sudo sed -ri 's/^display_errors\s*=\s*Off/display_errors = On/g' /etc/php5/fpm/php.ini
else
    sudo sed -i 's/;php_flag\[display_errors\]/php_flag\[display_errors\]/g' /etc/php5/fpm/pool.d/www.conf
fi

echo 'date.timezone = America/Santiago' | sudo tee --append /etc/php5/apache2/php.ini
echo 'date.timezone = America/Santiago' | sudo tee --append /etc/php5/fpm/php.ini
echo 'date.timezone = America/Santiago' | sudo tee --append /etc/php5/cli/php.ini

sudo service apache2 restart
sudo service php5-fpm restart
