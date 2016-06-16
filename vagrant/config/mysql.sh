#!/usr/bin/env bash

MYSQL=`which mysql`
RESULT=$(mysqlshow --user=root -h localhost --password=mitopasswd $1| grep -v Wildcard | grep -o $1)

if [ ! -d "/vagrant/$5" ]; then
    mkdir /vagrant/$5
fi

if [ "$RESULT" != "$1" ]; then
    # Configurando acceso externo para MySQL
    echo "[MYSQL] Configurando acceso externo para conexion con clientes desde fuera de vagrant"
    sed -i "s/bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

    Q1="CREATE DATABASE IF NOT EXISTS $1;"
    Q2="GRANT USAGE ON *.* TO '$2'@'localhost' IDENTIFIED BY '$3';"
    Q3="GRANT ALL PRIVILEGES ON $1.* TO '$2'@'localhost';"
    Q4="FLUSH PRIVILEGES;"
    SQL="${Q1}${Q2}${Q3}${Q4}"

    # Creando base de datos
    echo "[MYSQL] Creando base de datos y asignando usuario"
    $MYSQL -uroot -pmitopasswd -e "$SQL"

    if [ ! -f /vagrant/$5/$4 ]; then
        touch /vagrant/$5/$4
    else
        mysql -u$2 -p$3 -h localhost $1 < /vagrant/$5/$4
    fi
fi

# Aplicaremos los parches para dicha DB
echo "[MYSQL] Se procederan a aplicar los parches existentes"
if [ ! -d "/vagrant/$5/parches" ]; then
    mkdir /vagrant/$5/parches
else
    cd /vagrant/$5/parches/
    find . -type f -name "*.sql" | sort | awk -v user="$2" -v db="$1" -v pass="$3" '{system("mysql -u" user " -h localhost -p" pass " " db "  < " $0 " && mv " $0 " " $0 ".lock")}'
fi
