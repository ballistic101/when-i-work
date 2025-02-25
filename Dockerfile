FROM php:8.4-alpine
WORKDIR /app
COPY . /app

RUN apk update
RUN apk add bash

RUN curl -s https://getcomposer.org/installer | php
RUN alias composer="php composer.phar"

RUN php /app/composer.phar install
CMD ["sleep", "86400"]
