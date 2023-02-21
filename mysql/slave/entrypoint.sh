#!/bin/bash

mysql_command='CHANGE MASTER TO MASTER_HOST="mysql-master",MASTER_USER="root",MASTER_PASSWORD="root"; START SLAVE;'
docker compose exec mysql-slave bash -c "mysql -uroot -proot -e '$mysql_command'"
