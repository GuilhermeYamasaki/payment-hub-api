#!/usr/bin/env bash

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "postgres" <<-EOSQL
    CREATE DATABASE logs;
    GRANT ALL PRIVILEGES ON DATABASE logs TO $POSTGRES_USER;
EOSQL
