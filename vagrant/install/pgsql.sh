#!/usr/bin/env bash
POSTGRE_VERSION=9.4

# Instalar PostgreSQL
sudo apt-get install -qq --force-yes postgresql postgresql-contrib

# Hacemos que escuche en todas las direcciones
sudo sed -i "s/#listen_addresses = 'localhost'/listen_addresses = '*'/g" /etc/postgresql/$POSTGRE_VERSION/main/postgresql.conf

# Permitimos que los usuarios se puedan conectar desde cualquier direccion
echo "host    all             all             0.0.0.0/0               md5" | sudo tee -a /etc/postgresql/$POSTGRE_VERSION/main/pg_hba.conf

# Iniciamos PostgreSQL
sudo service postgresql restart
