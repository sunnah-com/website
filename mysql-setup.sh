#!/bin/bash

# Create DB and load sample data
mysql --user=root --password= -e "CREATE DATABASE hadithdb;"
mysql --user=root --password= hadithdb < /samplegitdb.sql
rm -f /samplegitdb.sql

# Generate a password on the fly and use it for webreadp
MYSQL_USER=webreadp
MYSQL_PASS=\'$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 16 | head -n 1)\'
mysql --user=root --password= -e "CREATE USER $MYSQL_USER@'localhost' IDENTIFIED BY $MYSQL_PASS;"
mysql --user=root --password= -e "GRANT ALL ON hadithdb.* TO $MYSQL_USER@'localhost';"

# Make the password accessible to php
CONFIG_FILE=/app/application/config/config.ini
echo [database] >> $CONFIG_FILE
echo "db_password = $(echo $MYSQL_PASS | tr -d "'")" >> $CONFIG_FILE
echo "db_username = $MYSQL_USER" >> $CONFIG_FILE

# Search needs a read-only account with no password access
mysql --user=root --password= -e "CREATE USER 'webread'@'localhost' IDENTIFIED BY '';"
mysql --user=root --password= -e "GRANT SELECT ON hadithdb.* TO 'webread'@'localhost';"

# Start memcached after db is configured
service memcached restart
