# Spor Kulübü Web Sitesi

Fenerbahçe'den ilham alınan modern ve yönetilebilir spor kulübü web sitesi.

## Teknolojiler
- **Backend:** PHP (MVC Mimarisi)
- **Veritabanı:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap
- **Yönetim Paneli:** Tam CRUD işlemleri

## Kurulum

### 🐳 Docker ile Hızlı Kurulum (Önerilen)

```bash
# 1. Projeyi klonlayın
git clone <repository-url>
cd spor_web

# 2. Docker container'ları başlatın
docker-compose up -d

# 3. Web sitesine erişin
# Ana sayfa: http://localhost:8080
# Admin panel: http://localhost:8080/admin/login
```

Detaylı Docker kurulumu için: [DOCKER_SETUP.md](DOCKER_SETUP.md)

### 📋 Manuel Kurulum

1. **Veritabanı Kurulumu:**
   ```sql
   -- database/schema.sql dosyasını MySQL'de çalıştırın
   ```

2. **Konfigürasyon:**
   ```php
   // config/database.php dosyasında veritabanı bilgilerini güncelleyin
   ```

3. **Sunucu:**
   ```bash
   # Local sunucu başlatın (XAMPP, WAMP veya benzeri)
   ```

## Özellikler

### Ön Yüz
- **Ana Sayfa:** Slider, son haberler, maç sonuçları
- **Hakkımızda:** Kulüp tarihi ve vizyonu
- **Gruplar:** Yaş kategorileri (U10, U12, U14 vb.)
- **A Takım:** Oyuncu listesi ve detayları
- **Teknik Kadro:** Antrenör ve destek personeli
- **Duyurular:** Haberler ve duyurular

### Yönetim Paneli
- Güvenli giriş sistemi
- İçerik yönetimi (CRUD)
- Resim yükleme
- Kullanıcı dostu arayüz

## Dizin Yapısı
```
spor_web/
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── core/
├── config/
├── database/
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
└── index.php
```

## Güvenlik
- Prepared statements
- CSRF koruması
- Input validation
- Session yönetimi