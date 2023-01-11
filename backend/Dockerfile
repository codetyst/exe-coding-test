FROM php:8.2-cli

RUN apt-get update && apt-get install -y libmcrypt-dev \
     mysql-client libmagickwand-dev --no-install-recommends \
     && pecl install imagick \
     && docker-php-ext-enable imagick \
     && docker-php-ext-install mcrypt pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN compose install
# CMD php artisan migrate; php artisan db:seed --class=ExeUserSeeder