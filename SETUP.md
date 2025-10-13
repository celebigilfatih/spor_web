# Spor Kulübü Web Sitesi - Kurulum Talimatları

## Gereksinimler
- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- Apache/Nginx web sunucusu
- mod_rewrite etkin

## Kurulum Adımları

### 1. Dosyaları Web Sunucusuna Yükleyin
Tüm dosyaları web sunucunuzun root dizinine kopyalayın.

### 2. Veritabanı Kurulumu

```sql
-- MySQL'de yeni veritabanı oluşturun
CREATE DATABASE spor_kulubu CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;

-- Schema dosyasını çalıştırın
-- Dosya: database/schema.sql

-- Örnek verileri yükleyin (opsiyonel)
-- Dosya: database/sample_data.sql
```

### 3. Konfigürasyon
`config/database.php` dosyasında veritabanı bilgilerinizi güncelleyin:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'spor_kulubu');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 4. Dosya İzinleri
Upload klasörü için yazma izni verin:

```bash
chmod 755 public/uploads
chmod 755 public/images
```

### 5. URL Rewriting
Apache için `.htaccess` dosyaları zaten mevcut.
Nginx için örnek konfigürasyon:

```nginx
location / {
    try_files $uri $uri/ /index.php?url=$uri&$args;
}

location /public/ {
    try_files $uri $uri/ =404;
}
```

## Admin Panel Erişimi

### Giriş Bilgileri (Varsayılan)
- **URL:** `yoursite.com/admin/login`
- **E-posta:** admin@sporkulubu.com
- **Şifre:** password

⚠️ **Güvenlik:** İlk girişten sonra şifrenizi mutlaka değiştirin!

## Özellikler

### Frontend
✅ Responsive tasarım (Fenerbahçe.org'den ilham alınmış)
✅ Ana sayfa slider
✅ Haberler sistemi
✅ Takım ve oyuncu yönetimi
✅ Teknik kadro sayfası
✅ İletişim formu
✅ Sosyal medya entegrasyonu

### Admin Panel
✅ Güvenli giriş sistemi
✅ Dashboard istatistikleri
✅ Haber yönetimi (CRUD)
✅ Oyuncu yönetimi (CRUD)
✅ Takım yönetimi (CRUD)
✅ Teknik kadro yönetimi (CRUD)
✅ Resim yükleme sistemi
✅ Site ayarları

### Güvenlik
✅ CSRF koruması
✅ SQL Injection koruması (Prepared Statements)
✅ XSS koruması (Input sanitization)
✅ Session yönetimi
✅ File upload güvenliği

## Kullanım

### Yeni Haber Ekleme
1. Admin paneline giriş yapın
2. "Haberler" menüsüne tıklayın
3. "Yeni Haber Ekle" butonuna tıklayın
4. Formu doldurun ve kaydedin

### Oyuncu Ekleme
1. "Oyuncular" menüsüne gidin
2. "Yeni Oyuncu Ekle" butonuna tıklayın
3. Oyuncu bilgilerini girin
4. Fotoğraf yükleyin (opsiyonel)
5. Kaydedin

### Site Ayarları
1. "Ayarlar" menüsüne gidin
2. İletişim bilgilerini güncelleyin
3. Sosyal medya linklerini ekleyin
4. Site başlığı ve açıklamasını düzenleyin

## Klasör Yapısı

```
spor_web/
├── app/
│   ├── controllers/          # Kontrolcüler
│   ├── models/              # Modeller
│   └── views/               # Görünümler
│       ├── admin/           # Admin panel görünümleri
│       └── frontend/        # Frontend görünümleri
├── core/                    # MVC framework dosyaları
├── config/                  # Konfigürasyon dosyaları
├── database/                # SQL dosyaları
├── public/                  # Statik dosyalar
│   ├── css/                 # CSS dosyaları
│   ├── js/                  # JavaScript dosyaları
│   ├── images/              # Görsel dosyaları
│   └── uploads/             # Yüklenen dosyalar
├── .htaccess               # URL yeniden yazma kuralları
└── index.php               # Ana giriş noktası
```

## Özelleştirme

### Renk Teması
CSS dosyasındaki CSS variables'ları düzenleyin:
```css
:root {
    --primary-navy: #1e3c72;
    --accent-gold: #ffd700;
    /* diğer renkler */
}
```

### Logo ve Favicon
- Logo: `public/images/logo.png`
- Favicon: `public/images/favicon.ico`

### Sosyal Medya
Admin paneli → Ayarlar bölümünden sosyal medya linklerini güncelleyin.

## Sorun Giderme

### Yaygın Problemler

**1. 500 Internal Server Error**
- Apache mod_rewrite'ın etkin olduğundan emin olun
- Dosya izinlerini kontrol edin

**2. Veritabanı Bağlantı Hatası**
- `config/database.php` dosyasındaki bilgileri kontrol edin
- MySQL sunucusunun çalıştığından emin olun

**3. Resim Yükleme Sorunu**
- `public/uploads` klasörünün yazma iznine sahip olduğundan emin olun
- PHP `upload_max_filesize` ve `post_max_size` ayarlarını kontrol edin

**4. CSS/JS Dosyaları Yüklenmiyor**
- `.htaccess` dosyalarının doğru yerde olduğundan emin olun
- Sunucu URL ayarlarını kontrol edin

## Destek

Herhangi bir sorun yaşarsanız:
1. Hata loglarını kontrol edin
2. Tarayıcı developer tools'unu kullanın
3. PHP error_log'unu inceleyin

## Güncellemeler

### Sürüm 1.0
- ✅ Temel MVC yapısı
- ✅ Admin paneli
- ✅ Frontend tasarımı
- ✅ CRUD işlemleri
- ✅ Güvenlik önlemleri

### Gelecek Sürümler
- 📝 Çoklu dil desteği
- 📝 Gelişmiş arama sistemi
- 📝 Email bildirimleri
- 📝 Maç takvimi widget'ı
- 📝 Oyuncu istatistikleri grafiği

---

**Not:** Bu proje Fenerbahçe.org'dan görsel ilham alınarak geliştirilmiştir. Ticari kullanım öncesi gerekli izinlerin alınması önerilir.