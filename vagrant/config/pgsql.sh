#!/bin/bash


EXISTE=$(psql -lqt | cut -d \| -f 1 | grep -w $1 | wc -l)
export PGPASSWORD=$3

if [ ! -d "/vagrant/$5" ]; then
    mkdir /vagrant/$5
fi

# Si no existe la base de datos
if [ "$EXISTE" = "0" ]; then
    echo "[PGSQL] Creando usuarios"
    sudo su -c "createuser -s root" postgres
    sudo su -c "createuser -s vagrant" postgres
    # Creamos el usuario
    createuser $2

    echo "[PGSQL] Instalando la extension hstore"
    psql -d template1 -c 'create extension hstore;'

    echo "[PGSQL] Asignando contrasena al usuario"
    # Establecemos la contrasena del usuario
    echo "alter user \"$2\" with password '$3'\;" | psql postgres

    echo "[PGSQL] Creando base de datos"
    # Creamos la base de datos
    createdb -O $2 $1

    echo "[PGSQL] Se cargara el archivo SQL base a la base de datos"
    # Cargamos el archivo SQL Base
    if [ ! -f /vagrant/$5/$4 ]; then
        touch /vagrant/$5/$4
    else
        psql -U $2 -h 127.0.0.1 $1 < /vagrant/$5/$4
    fi
fi
psql -U "$2" -h 127.0.0.1 "$1" < "/vagrant/$5/$4"

# Aplicaremos los parches para dicha DB
if [ ! -d "/vagrant/$5/parches" ]; then
    mkdir /vagrant/$5/parches
else
    cd /vagrant/$5/parches/
    echo "[PGSQL] Se aplicaran los parches SQL"
    find . -type f -name "*.sql" | sort |  awk -v user="$2" -v db="$1" '{system("psql -U " user " -h 127.0.0.1 -f " $0 " " db " && mv " $0 " " $0 ".lock")}'
fi
