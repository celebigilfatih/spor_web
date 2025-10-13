#!/bin/bash

# Spor Kulübü Docker Kurulum Script'i
# Bu script Docker kurulumunu otomatikleştirir

set -e

echo "🏆 Spor Kulübü Web Sitesi - Docker Kurulumu Başlıyor..."

# Renk kodları
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonksiyonlar
print_step() {
    echo -e "${BLUE}📋 $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Docker kurulu mu kontrol et
check_docker() {
    print_step "Docker kurulumu kontrol ediliyor..."
    
    if ! command -v docker &> /dev/null; then
        print_error "Docker bulunamadı! Lütfen Docker'ı kurun: https://docs.docker.com/get-docker/"
        exit 1
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        print_error "Docker Compose bulunamadı! Lütfen Docker Compose'u kurun."
        exit 1
    fi
    
    print_success "Docker ve Docker Compose kurulu"
}

# Port kontrolü
check_ports() {
    print_step "Port kullanımı kontrol ediliyor..."
    
    PORTS=(8080 3306 8081 6379)
    for port in "${PORTS[@]}"; do
        if lsof -i :$port &> /dev/null; then
            print_warning "Port $port kullanımda. Çakışma olabilir."
        fi
    done
    
    print_success "Port kontrolü tamamlandı"
}

# Upload klasörü oluştur
create_upload_dir() {
    print_step "Upload klasörü oluşturuluyor..."
    
    mkdir -p public/uploads
    
    # .gitkeep dosyası oluştur
    touch public/uploads/.gitkeep
    
    print_success "Upload klasörü oluşturuldu"
}

# Docker network oluştur
create_network() {
    print_step "Docker network oluşturuluyor..."
    
    if ! docker network ls | grep -q spor_network; then
        docker network create spor_network
        print_success "spor_network oluşturuldu"
    else
        print_success "spor_network zaten mevcut"
    fi
}

# Container'ları başlat
start_containers() {
    print_step "Docker container'ları başlatılıyor..."
    
    # İlk build
    docker-compose build --no-cache
    
    # Container'ları başlat
    docker-compose up -d
    
    print_success "Container'lar başlatıldı"
}

# Veritabanının hazır olmasını bekle
wait_for_database() {
    print_step "Veritabanının hazır olması bekleniyor..."
    
    max_attempts=30
    attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if docker-compose exec -T database mysql -u spor_user -pspor_password -e "SELECT 1" &> /dev/null; then
            print_success "Veritabanı hazır"
            return 0
        fi
        
        echo -n "."
        sleep 2
        ((attempt++))
    done
    
    print_error "Veritabanı başlatma timeout"
    exit 1
}

# Upload klasörü izinlerini ayarla
fix_permissions() {
    print_step "Dosya izinleri ayarlanıyor..."
    
    docker-compose exec web chown -R www-data:www-data /var/www/html/public/uploads
    docker-compose exec web chmod -R 755 /var/www/html/public/uploads
    
    print_success "İzinler ayarlandı"
}

# Test et
test_installation() {
    print_step "Kurulum test ediliyor..."
    
    # Web sitesi erişim testi
    if curl -s http://localhost:8080 > /dev/null; then
        print_success "Web sitesi erişilebilir: http://localhost:8080"
    else
        print_warning "Web sitesi henüz erişilebilir değil, birkaç saniye bekleyin"
    fi
    
    # phpMyAdmin erişim testi
    if curl -s http://localhost:8081 > /dev/null; then
        print_success "phpMyAdmin erişilebilir: http://localhost:8081"
    else
        print_warning "phpMyAdmin henüz erişilebilir değil"
    fi
}

# Bilgilendirme
show_info() {
    echo ""
    echo "🎉 Kurulum tamamlandı!"
    echo ""
    echo "📍 Erişim Bilgileri:"
    echo "   🌐 Web Sitesi: http://localhost:8080"
    echo "   🔐 Admin Panel: http://localhost:8080/admin/login"
    echo "   📊 phpMyAdmin: http://localhost:8081"
    echo ""
    echo "🔑 Giriş Bilgileri:"
    echo "   👤 Admin E-posta: admin@sporkulubu.com"
    echo "   🔒 Admin Şifre: password"
    echo "   🗄️  DB Kullanıcı: spor_user"
    echo "   🔑 DB Şifre: spor_password"
    echo ""
    echo "🛠️  Faydalı Komutlar:"
    echo "   📋 Container durumu: docker-compose ps"
    echo "   📄 Logları görüntüle: docker-compose logs -f"
    echo "   ⏹️  Durdur: docker-compose down"
    echo "   🔄 Yeniden başlat: docker-compose restart"
    echo ""
}

# Cleanup function
cleanup() {
    print_warning "Kurulum iptal edildi"
    docker-compose down 2>/dev/null || true
    exit 1
}

# Signal handler
trap cleanup INT TERM

# Ana kurulum
main() {
    echo "🏆 Spor Kulübü Web Sitesi Docker Kurulumu"
    echo "=========================================="
    echo ""
    
    check_docker
    check_ports
    create_upload_dir
    create_network
    start_containers
    wait_for_database
    fix_permissions
    
    # Biraz bekle
    sleep 5
    
    test_installation
    show_info
}

# Script'i çalıştır
main "$@"