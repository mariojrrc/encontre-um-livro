FROM wyveo/nginx-php-fpm:php74

COPY .docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

MAINTAINER Mario Costa <mariojr.rcosta@gmail.com>

COPY . /usr/share/nginx/html

WORKDIR /usr/share/nginx/html

RUN composer install --prefer-dist --no-dev -o
#RUN composer install --prefer-dist -o
