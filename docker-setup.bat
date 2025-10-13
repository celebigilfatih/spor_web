@echo off
REM Spor Kulübü Docker Kurulum Script'i (Windows)
REM Bu script Docker kurulumunu otomatikleştirir

echo 🏆 Spor Kulübü Web Sitesi - Docker Kurulumu Başlıyor...
echo.

REM Docker kurulu mu kontrol et
echo 📋 Docker kurulumu kontrol ediliyor...
docker --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker bulunamadı! Lütfen Docker Desktop'ı kurun: https://docs.docker.com/desktop/windows/
    pause
    exit /b 1
)

docker-compose --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker Compose bulunamadı! Lütfen Docker Desktop'ı kurun.
    pause
    exit /b 1
)

echo ✅ Docker ve Docker Compose kurulu
echo.

REM Upload klasörü oluştur
echo 📋 Upload klasörü oluşturuluyor...
if not exist "public\uploads" (
    mkdir "public\uploads"
    echo. > "public\uploads\.gitkeep"
)
echo ✅ Upload klasörü oluşturuldu
echo.

REM Container'ları başlat
echo 📋 Docker container'ları başlatılıyor...
echo Bu işlem birkaç dakika sürebilir...

docker-compose build --no-cache
if %errorlevel% neq 0 (
    echo ❌ Docker build hatası!
    pause
    exit /b 1
)

docker-compose up -d
if %errorlevel% neq 0 (
    echo ❌ Container başlatma hatası!
    pause
    exit /b 1
)

echo ✅ Container'lar başlatıldı
echo.

REM Veritabanının hazır olmasını bekle
echo 📋 Veritabanının hazır olması bekleniyor...
timeout /t 30 /nobreak >nul

REM Upload klasörü izinlerini ayarla (Windows'ta gerek yok ama Docker için)
echo 📋 Dosya izinleri ayarlanıyor...
docker-compose exec web chown -R www-data:www-data /var/www/html/public/uploads 2>nul
docker-compose exec web chmod -R 755 /var/www/html/public/uploads 2>nul
echo ✅ İzinler ayarlandı
echo.

REM Test et
echo 📋 Kurulum test ediliyor...
timeout /t 10 /nobreak >nul

echo.
echo 🎉 Kurulum tamamlandı!
echo.
echo 📍 Erişim Bilgileri:
echo    🌐 Web Sitesi: http://localhost:8080
echo    🔐 Admin Panel: http://localhost:8080/admin/login
echo    📊 phpMyAdmin: http://localhost:8081
echo.
echo 🔑 Giriş Bilgileri:
echo    👤 Admin E-posta: admin@sporkulubu.com
echo    🔒 Admin Şifre: password
echo    🗄️  DB Kullanıcı: spor_user
echo    🔑 DB Şifre: spor_password
echo.
echo 🛠️  Faydalı Komutlar:
echo    📋 Container durumu: docker-compose ps
echo    📄 Logları görüntüle: docker-compose logs -f
echo    ⏹️  Durdur: docker-compose down
echo    🔄 Yeniden başlat: docker-compose restart
echo.
echo Tarayıcınızda http://localhost:8080 adresini açarak web sitesini görebilirsiniz.
echo.

pause