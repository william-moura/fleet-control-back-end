FROM php:8.4-fpm-alpine

# 1. Instala as dependências do sistema usando o gerenciador de pacotes do Alpine (apk)
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    zip \
    unzip \
    $PHPIZE_DEPS

# 2. Configura e instala as extensões nativas do PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# 3. Compila e ativa a extensão do Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# 4. Copia o binário oficial do Composer (mais rápido e seguro do que usar curl)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5. Copia o código da aplicação
COPY . .

# 6. Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# 7. Ajusta permissões de escrita do Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]