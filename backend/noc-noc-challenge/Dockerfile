# Usa la imagen oficial de PHP 8.2
FROM php:8.2

# Instala extensiones y herramientas necesarias
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    p7zip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Instala las extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo en /var/www
WORKDIR /var/www

# Copia los archivos del proyecto al contenedor
COPY . .

# Instala las dependencias del proyecto usando Composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install

# Copia el archivo .env.example y renómbralo a .env
RUN cp .env.example .env

# Genera la clave de la aplicación
RUN php artisan key:generate

# Expone el puerto 8000 para acceder a la aplicación Laravel
EXPOSE 8000

# Comando para ejecutar el servidor de desarrollo de Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
