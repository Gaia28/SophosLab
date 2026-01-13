FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    default-mysql-client

# Limpa cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP (pdo_mysql é a vital aqui)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório
WORKDIR /var/www

# Copia tudo
COPY . .

# Instala dependências do PHP (baseado no seu composer.lock)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Compila o Frontend (Tailwind/Vite)
RUN npm install && npm run build

# Ajusta permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]