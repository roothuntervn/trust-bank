FROM php:7.3-apache

RUN apt-get update

COPY ./src /var/www/html

RUN echo 'root:32f62a86805f9d1ae2c0fa6d4ae75f34' | chpasswd

RUN chmod -R 777 /var/www/html

WORKDIR /var/www/html

expose 80