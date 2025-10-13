# Spor Kulübü Web Sitesi - Docker Kurulum Rehberi

## 🐳 Docker ile Hızlı Kurulum

Bu rehber, Spor Kulübü web sitesini Docker kullanarak nasıl çalıştıracağınızı açıklar.

### 📋 Gereksinimler

- **Docker:** 20.10+
- **Docker Compose:** 1.29+
- **Minimum RAM:** 2GB
- **Disk Alanı:** 1GB

### 🚀 Hızlı Başlangıç

#### 1. Projeyi İndirin
```bash
git clone <repository-url>
cd spor_web
```

#### 2. Docker Container'ları Başlatın
```bash
# Tüm servisleri arka planda başlat
docker-compose up -d

# İlk kez çalıştırıyorsanız build ile başlatın
docker-compose up --build -d
```

#### 3. Kurulumu Kontrol Edin
```bash
# Container'ların durumunu kontrol edin
docker-compose ps

# Web sitesine erişin
http://localhost:8080

# Admin paneline erişin
http://localhost:8080/admin/login

# phpMyAdmin'e erişin (isteğe bağlı)
http://localhost:8081
```

### 🔧 Servis Detayları

#### Web Sunucusu (PHP + Apache)
- **Port:** 8080
- **Container Adı:** spor_kulubu_web
- **Özellikler:**
  - PHP 8.2
  - Apache 2.4
  - URL Rewriting aktif
  - SSL/HTTPS hazır altyapı

#### MySQL Veritabanı
- **Port:** 3306
- **Container Adı:** spor_kulubu_db
- **Varsayılan Bilgiler:**
  - Veritabanı: `spor_kulubu`
  - Kullanıcı: `spor_user`
  - Şifre: `spor_password`
  - Root Şifre: `root_password`

#### phpMyAdmin (İsteğe Bağlı)
- **Port:** 8081
- **Container Adı:** spor_kulubu_phpmyadmin
- **Kullanım:** Veritabanı yönetimi için

#### Redis (İsteğe Bağlı)
- **Port:** 6379
- **Container Adı:** spor_kulubu_redis
- **Kullanım:** Önbellek sistemi için

### 🔑 Giriş Bilgileri

#### Admin Panel
- **URL:** http://localhost:8080/admin/login
- **E-posta:** admin@sporkulubu.com
- **Şifre:** password

#### phpMyAdmin
- **URL:** http://localhost:8081
- **Kullanıcı:** spor_user
- **Şifre:** spor_password

### 📁 Docker Dosya Yapısı

```
spor_web/
├── Dockerfile                    # Ana web sunucusu image'ı
├── docker-compose.yml            # Çoklu servis konfigürasyonu
├── .dockerignore                 # Docker build'den hariç tutulan dosyalar
├── docker/
│   ├── apache/
│   │   └── vhost.conf            # Apache VirtualHost konfigürasyonu
│   ├── php/
│   │   └── php.ini               # PHP ayarları
│   └── mysql/
│       └── my.cnf                # MySQL konfigürasyonu
├── config/
│   └── docker.php                # Docker environment konfigürasyonu
└── database/
    ├── schema.sql                # Veritabanı şeması (otomatik yüklenir)
    └── sample_data.sql           # Örnek veriler (otomatik yüklenir)
```

### 🛠️ Docker Komutları

#### Temel İşlemler
```bash
# Servisleri başlat
docker-compose up -d

# Servisleri durdur
docker-compose down

# Logları görüntüle
docker-compose logs -f

# Belirli bir servisin logları
docker-compose logs -f web
docker-compose logs -f database

# Container'lara bağlan
docker-compose exec web bash
docker-compose exec database mysql -u spor_user -p
```

#### Geliştirme İşlemleri
```bash
# Image'ları yeniden build et
docker-compose build --no-cache

# Sadece web servisini yeniden başlat
docker-compose restart web

# Veritabanını sıfırla
docker-compose down -v
docker-compose up -d

# Upload klasörü izinlerini düzelt
docker-compose exec web chown -R www-data:www-data /var/www/html/public/uploads
```

#### Backup ve Restore
```bash
# Veritabanı backup'ı al
docker-compose exec database mysqldump -u spor_user -p spor_kulubu > backup.sql

# Backup'tan restore et
docker-compose exec -T database mysql -u spor_user -p spor_kulubu < backup.sql

# Upload dosyalarını backup'la
docker cp spor_kulubu_web:/var/www/html/public/uploads ./uploads_backup
```

### 🔒 Güvenlik Ayarları

#### Production için Önemli Değişiklikler

1. **Environment Variables Güncelle:**
```bash
# docker-compose.yml dosyasında güçlü şifreler kullanın
MYSQL_PASSWORD: strong_password_here
MYSQL_ROOT_PASSWORD: very_strong_root_password
```

2. **SSL Sertifikası Ekle:**
```bash
# docker/apache/vhost.conf dosyasına SSL konfigürasyonu ekleyin
```

3. **Firewall Kuralları:**
```bash
# Sadece gerekli portları açın
# 8080 (web), 443 (HTTPS), 22 (SSH)
```

4. **Log Monitoring:**
```bash
# Log dosyalarını düzenli kontrol edin
docker-compose exec web tail -f /var/log/apache2/spor_kulubu_error.log
```

### 🐛 Sorun Giderme

#### Yaygın Problemler

**1. Container başlamıyor:**
```bash
# Log kontrolü
docker-compose logs web

# Port kontrolü
netstat -tulpn | grep :8080
```

**2. Veritabanı bağlantı hatası:**
```bash
# MySQL container'ının çalıştığından emin olun
docker-compose ps database

# Veritabanı loglarını kontrol edin
docker-compose logs database
```

**3. Upload klasörü izin hatası:**
```bash
# İzinleri düzeltin
docker-compose exec web chmod -R 777 /var/www/html/public/uploads
```

**4. Memory hatası:**
```bash
# PHP memory limit'i artırın (docker/php/php.ini)
memory_limit = 512M

# Container'ı yeniden başlatın
docker-compose restart web
```

### 📊 Performans Optimizasyonu

#### Production Ayarları
```bash
# docker-compose.yml'de environment değişkenleri
ENVIRONMENT=production
DEBUG_MODE=false

# PHP OPcache aktif
opcache.enable=1

# MySQL buffer pool size artır
innodb_buffer_pool_size=512M
```

#### Monitoring
```bash
# Container resource kullanımı
docker stats

# Disk kullanımı
docker system df

# Log boyutları
docker-compose exec web du -sh /var/log/apache2/
```

### 🔄 Güncelleme İşlemi

```bash
# 1. Backup alın
docker-compose exec database mysqldump -u spor_user -p spor_kulubu > backup_$(date +%Y%m%d).sql

# 2. Yeni kodu çekin
git pull origin main

# 3. Container'ları güncelle
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# 4. Veritabanı migrasyonları varsa çalıştırın
# (Gerekirse schema güncellemeleri)
```

### 📞 Destek

Herhangi bir sorun yaşarsanız:

1. **Logları kontrol edin:** `docker-compose logs -f`
2. **Container durumunu kontrol edin:** `docker-compose ps`
3. **Disk alanını kontrol edin:** `df -h`
4. **Memory kullanımını kontrol edin:** `free -m`

### 🎯 Sonuç

Docker ile kurulum sayesinde:
- ✅ Hızlı ve tutarlı kurulum
- ✅ İzole çalışma ortamı
- ✅ Kolay yedekleme ve restore
- ✅ Ölçeklenebilir altyapı
- ✅ Development/Production uyumluluğu

**🚀 Projeniz artık http://localhost:8080 adresinde çalışır durumda!**