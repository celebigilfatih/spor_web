# Spor Kulübü Web Sitesi - Docker Konfigürasyonu
FROM php:8.2-apache

# Sistem paketlerini güncelle ve gerekli paketleri yükle
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli zip mbstring exif pcntl bcmath \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

# Çalışma dizinini ayarla
WORKDIR /var/www/html

# Proje dosyalarını kopyala
COPY . /var/www/html/

# Apache konfigürasyonu
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Dosya izinlerini ayarla
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/public/uploads

# PHP konfigürasyonu
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Port 80'i aç
EXPOSE 80

# Apache'yi başlat
CMD ["apache2-foreground"]