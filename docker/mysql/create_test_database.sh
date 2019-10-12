#!/bin/bash
set -e

MYSQL="mysql -uroot -p${MYSQL_ROOT_PASSWORD}"

echo "Creating database: classrooms_test"

$MYSQL <<EOSQL
CREATE DATABASE classrooms_test;
GRANT ALL PRIVILEGES ON classrooms_test.* TO ${MYSQL_USER};
FLUSH PRIVILEGES;
EOSQL