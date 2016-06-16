#!/usr/bin/env bash

source "/vagrant/vagrant/ajustes.cfg"

# Agregaremos todos los repositorios
echo "[GENERAL] Agregando todos los repositorios"



if [ "$SERVER" = "apache" ]; then
    ###########################
    #         APACHE2         #
    ###########################
    echo "[APACHE] Anadiendo repositorio de apache"
    sudo add-apt-repository -y ppa:ondrej/apache2
else
    ##########################
    #         NGINX          #
    ##########################
    echo "[NGINX] Anadiendo repositorio de Nginx"
    sudo add-apt-repository -y ppa:nginx/stable
fi

if [ "$DBNEED" = "si" ]; then
    if [ "$DBTYPE" = "pgsql" ]; then
        ###########################
        #       POSTGRESQL        #
        ###########################

        # Descargamos la llave GPG
        echo "[PGSQL] Anadiendo llaves del repositorio"
        wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -

        # Anadimos los repositorios de postgresql
        echo "[PGSQL] Anadiendo repositorio de PostgreSQL"
        sudo touch /etc/apt/sources.list.d/pgdg.list
        sudo echo "deb http://apt.postgresql.org/pub/repos/apt/ trusty-pgdg main" | sudo tee /etc/apt/sources.list.d/pgdg.list
    
    elif [ "$DBTYPE" = "mysql" ]; then
        ###########################
        #          MySQL          #
        ###########################
        echo "[MYSQL] Anadiendo repositorio de MySQL"
        sudo add-apt-repository -y ppa:ondrej/mysql-5.5
    fi
fi

###########################
#         PHP 5.5         #
###########################

# Anadimos el repositorio
echo "[PHP] Anadiendo llaves del repositorio"
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C

echo "[PHP] Anadiendo repositorio de PHP 5.5"
sudo add-apt-repository -y  ppa:ondrej/php5


echo "[APT-SOUCE]Agregando Repositorios de Chile"
# Incluyendo Repositorios de Chile
if ! echo "

###### Ubuntu Main Repos
deb http://cl.archive.ubuntu.com/ubuntu/ trusty main restricted universe multiverse

###### Ubuntu Update Repos
deb http://cl.archive.ubuntu.com/ubuntu/ trusty-security main restricted universe multiverse
deb http://cl.archive.ubuntu.com/ubuntu/ trusty-updates main restricted universe multiverse
" > /etc/apt/sources.list.d/chile.list
then
    echo  "[APT Repo] Hubo un error al crear el archivo de configuracion"
    exit;
else
    echo "[APT Repo] Se creo el archivo de configuracion de sources.list"
fi


echo "[GENERAL] Actualizando repositorios y claves"
sudo apt-key update

mv /etc/apt/sources.list.d/chile.list /etc/apt/sources.list

sudo apt-get update

# Instalando VIM
echo "[GENERAL] Instalando VIM"
sudo apt-get install -qq --force-yes vim

# Instalando SVN
echo "[GENERAL] Instalando Subversion."
sudo apt-get install -qq --force-yes subversion
