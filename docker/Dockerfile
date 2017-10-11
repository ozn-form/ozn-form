FROM webdevops/php-apache-dev:debian-7
RUN apt-get update && apt-get install -y vim
COPY php.ini /opt/docker/etc/php/

FROM webdevops/php-apache-dev:5.6
RUN apt-get update && apt-get install -y vim
COPY php.ini /opt/docker/etc/php/

FROM webdevops/php-apache-dev:7.1
RUN apt-get update && apt-get install -y vim
COPY php.ini /opt/docker/etc/php/