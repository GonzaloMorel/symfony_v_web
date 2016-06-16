#!/usr/bin/env bash

# Se configurara la base de datos con sus valores
echo "[ecAPI] Configurando archivos de la carpeta common"
sed -i "s/\$conf\['ecAPI'\]\['conf'\]\['DB'\]\['database'\] = [',\"].*[',\"];/\$conf\['ecAPI'\]\['conf'\]\['DB'\]\['database'\] = \"$1\";/g" /vagrant/common/*.php
sed -i "s/\$conf\['ecAPI'\]\['conf'\]\['DB'\]\['username'\] = [',\"].*[',\"];/\$conf\['ecAPI'\]\['conf'\]\['DB'\]\['username'\] = \"$2\";/g" /vagrant/common/*.php
sed -i "s/\$conf\['ecAPI'\]\['conf'\]\['DB'\]\['password'\] = [',\"].*[',\"];/\$conf\['ecAPI'\]\['conf'\]\['DB'\]\['password'\] = \"$3\";/g" /vagrant/common/*.php
