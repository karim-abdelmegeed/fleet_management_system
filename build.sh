#!/bin/bash


# Pulling images
docker pull phpmyadmin:latest
docker pull mysql:5.7
docker pull php:7.3.2-apache

# Build images
docker build -t fleet_app .


# Build container
docker-compose up -d

( while ! docker exec fleet_db_mysql mysqladmin --user=root --password=secret --host "0.0.0.0" ping --silent &> /dev/null ; do
    echo " ... Waiting for database to be deployed ..." ; sleep 10; done; echo " ... Database has been deployed successfully ..." )


# Running app cmd
composer install
docker exec -t fleet_app chmod -R 777 /usr/src/app
docker exec -t fleet_app cp .env.example .env
docker exec -t fleet_app php artisan key:generate
docker exec -t fleet_app php artisan migrate --seed
docker exec -t fleet_app php artisan passport:install


