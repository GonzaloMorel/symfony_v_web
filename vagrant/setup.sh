#!/usr/bin/env bash

# Obtenemos la ubicacion de este script
DIR="/vagrant/vagrant"

# Leemos el archivo de configuracion
source $DIR"/ajustes.cfg"

# Si SVN no esta instalado, es la primera vez que corremos el script
svn --version > /dev/null 2>&1
if [ $? -ne 0 ]; then
    # Declaramos variables de idioma para que no de problemas
    echo "[GENERAL] Resolviendo problemas de idioma"
    sudo locale-gen en_US en_US.UTF-8 es_CL es_CL.UTF-8 > /dev/null
    sudo dpkg-reconfigure locales > /dev/null

    # Configuracion inicial
    echo "[GENERAL] Realizando la configuracion incial"
    bash $DIR"/install/bootstrap.sh"
fi

# Determinaremos si PHP esta instalado
php -v > /dev/null 2>&1
if [ $? -ne 0 ]; then
    # Comenzando con la instalacion y configuracion de PHP
    echo "[PHP] Comenzando con la instalacion y configuracion de PHP"
    sh $DIR"/install/php.sh"
    sh $DIR"/config/php.sh" $PHPDISPLAY
fi

# Determinaremos que tipo de servidor se utilizara
if [ "$SERVER" = "apache" ]; then
    # El servidor seleccionado es apache
    # Comprobaremos si apache esta instalado
   # apache2 -v > /dev/null 2>&1
   # if [ $? -ne 0 ]; then
        echo "[APACHE] Comenzando con la instalacion y configuracion de Apache"
        sh $DIR"/install/apache.sh"
        sh $DIR"/config/apache.sh"
    #fi
else
    # El servidor seleccionado es nginx
    # Comprobaremos si nginx esta instalado
    nginx -v > /dev/null 2>&1
    if [ $? -ne 0 ]; then
        echo "[NGINX] Comenzando con la instalacion y configuracion de Nginx"
        sh $DIR"/install/nginx.sh"
        sh $DIR"/config/nginx.sh"
    fi
fi


# Determinaremos el uso de base de datos
if [ "$DBNEED" = "si" ]; then
    # Determinamos que base de datos se utilizara
    if [ "$DBTYPE" = "pgsql" ]; then
        # La base de datos seleccionada es Postgres
        echo "[PGSQL] Se procedera a instalar y configurar PosgtreSQL"

        psql -V > /dev/null 2>&1
        if  [ $? -ne 0 ]; then
            sh $DIR"/install/pgsql.sh"
        fi
        sh $DIR"/config/pgsql.sh" $DBNAME $DBUSER $DBPASS $DBLOAD $DBDIR 
    elif [ "$DBTYPE" = "mysql" ]; then
        # La base de datos seleccionada es MySQL
        
        mysql -V > /dev/null 2>&1
        if [ $? -ne 0 ]; then
            bash $DIR"/install/mysql.sh"
        fi
        sh $DIR"/config/mysql.sh" $DBNAME $DBUSER $DBPASS $DBLOAD $DBDIR
    fi

    if [ -d "/vagrant/ecAPI" ]; then
        echo "[ecAPI] Se detecto un proyecto basado en ecAPI."
        sh $DIR"/config/ecapi.sh" $DBNAME $DBUSER $DBPASS
    fi
else
    echo "[GENERAL] No se necesita base de datos."
fi

echo "[EXTRAS] A continuacion se ejecutarán los scripts extras."
for each in $DIR"/extras/*.sh"
do
    bash $each $DBNAME $DBUSER $DBPASS
done

cat $DIR"/helpers/finish.txt"
