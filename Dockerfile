FROM php:8.1

RUN apt -y update && apt -y install git p7zip-full

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer