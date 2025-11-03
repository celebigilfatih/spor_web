<?php
/**
 * Database Schema Update Script
 * Bu dosya mevcut veritabanı şemasını yeni şemayla uyumlu hale getirir
 */

// Docker ortamında mı çalışıyoruz?
if (getenv('DB_HOST') || isset($_ENV['DB_HOST'])) {
    require_once 'config/docker.php';
} else {
    require_once 'config/database.php';
}

require_once 'core/Database.php';

try {
    $db = new Database();
    
    echo "Veritabanı bağlantısı başarılı!\n";
    
    // 1. About Us tablosu oluştur
    $createAboutUsTable = "
    CREATE TABLE IF NOT EXISTS about_us (
        id INT NOT NULL AUTO_INCREMENT,
        section_name VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        title VARCHAR(255) COLLATE utf8mb4_turkish_ci NOT NULL,
        content LONGTEXT COLLATE utf8mb4_turkish_ci NOT NULL,
        image VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        sort_order INT DEFAULT '0',
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY section_name (section_name),
        KEY status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createAboutUsTable);
    echo "About Us tablosu oluşturuldu veya zaten mevcut!\n";
    
    // About Us örnek verileri ekle
    $aboutUsCount = $db->query("SELECT COUNT(*) as count FROM about_us")[0]['count'];
    if ($aboutUsCount == 0) {
        $insertAboutUs = "
        INSERT INTO about_us (id, section_name, title, content, image, sort_order, status, created_at, updated_at) VALUES
        (1, 'main', 'Kulübümüz Hakkında', '<p>1929 yılında kurulan spor kulübümüz, Türkiye''nin en köklü ve başarılı spor kuruluşlarından biridir. 95 yıllık geçmişimizde, binlerce gencin spor hayatına başlamasına vesile olmuş, çok sayıda milli sporcu yetiştirmiş ve ulusal ile uluslararası arenada önemli başarılara imza atmışız.</p>\\n<p>Modern tesislerimiz, deneyimli teknik kadromuz ve güçlü altyapımızla geleceğin yıldızlarını yetiştirmeye devam ediyoruz. Sporun sadece fiziksel değil, aynı zamanda karakteri de geliştiren bir araç olduğuna inanıyor, bu doğrultuda gençlerimizi yetiştiriyoruz.</p>', NULL, 1, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (2, 'history', 'Tarihçemiz', '<p>Kulübümüz 1929 yılında bir grup futbol sevdalısı tarafından kuruldu. İlk yıllarda mahalle takımı olarak başlayan yolculuğumuz, zamanla profesyonel lige kadar uzandı.</p>\\n<p><strong>1929:</strong> Kulüp kuruldu<br>\\n<strong>1950:</strong> İlk şampiyonluk<br>\\n<strong>1975:</strong> Modern tesis açıldı<br>\\n<strong>1995:</strong> Altyapı akademisi kuruldu<br>\\n<strong>2010:</strong> Yeni stadyum inşaatı<br>\\n<strong>2024:</strong> 95. yıl kutlamaları</p>', NULL, 2, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (3, 'mission', 'Misyon ve Vizyon', '<p><strong>Misyonumuz:</strong> Gençleri spora yönlendirmek, yeteneklerini geliştirmek ve sporin evrensel değerlerini benimseyen, başarılı sporcular yetiştirmek.</p>\\n<p><strong>Vizyonumuz:</strong> Türkiye''nin önde gelen spor kulüplerinden biri olarak, uluslararası arenada ülkemizi en iyi şekilde temsil etmek.</p>\\n<p><strong>Değerlerimiz:</strong> Dürüstlük, takım ruhu, mükemmellik, sürekli gelişim ve toplumsal sorumluluk.</p>', NULL, 3, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38');
        ";
        $db->execute($insertAboutUs);
        echo "About Us örnek verileri eklendi!\n";
    }
    
    // 2. Admins tablosunu güncelle (full_name alanı ekle)
    try {
        $db->execute("ALTER TABLE admins ADD COLUMN full_name VARCHAR(100) NULL AFTER password");
        echo "Admins tablosuna full_name alanı eklendi!\n";
    } catch (Exception $e) {
        // Column might already exist
        echo "Admins tablosunda full_name alanı zaten mevcut!\n";
    }
    
    try {
        $db->execute("ALTER TABLE admins MODIFY COLUMN role ENUM('admin','super_admin') COLLATE utf8mb4_turkish_ci DEFAULT 'admin'");
        echo "Admins tablosu role alanı güncellendi!\n";
    } catch (Exception $e) {
        echo "Admins tablosu role alanı zaten doğru formatta!\n";
    }
    
    // 3. Announcements tablosu oluştur
    $createAnnouncementsTable = "
    CREATE TABLE IF NOT EXISTS announcements (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        content TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
        type ENUM('important','info','warning','success') COLLATE utf8mb4_unicode_ci DEFAULT 'info',
        status ENUM('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
        published_at DATETIME DEFAULT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME DEFAULT NULL,
        PRIMARY KEY (id),
        KEY idx_status (status),
        KEY idx_published (published_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createAnnouncementsTable);
    echo "Announcements tablosu oluşturuldu veya zaten mevcut!\n";
    
    // Announcements örnek verileri ekle
    $announcementsCount = $db->query("SELECT COUNT(*) as count FROM announcements")[0]['count'];
    if ($announcementsCount == 0) {
        $insertAnnouncements = "
        INSERT INTO announcements (id, title, content, type, status, published_at, created_at, updated_at) VALUES
        (1, 'Maç Bilet Satışları', 'Galatasaray derbisi biletleri yarın saat 10:00''da satışa çıkacaktır. Üye önceliği uygulanacaktır.', 'important', 'active', '2025-10-16 12:56:56', '2025-10-16 12:56:56', NULL),
        (2, 'Antrenman Saatleri', 'Bu hafta antrenmanlarımız saat 16:00''da başlayacaktır. Taraftarlarımız izleyebilir.', 'info', 'active', '2025-10-16 12:56:56', '2025-10-16 12:56:56', NULL),
        (3, 'Yeni Sezon Forma Satışları', 'Yeni sezon formaları kulüp mağazalarımızda satışa sunulmuştur. Online sipariş de verebilirsiniz.', 'info', 'active', '2025-10-16 12:56:56', '2025-10-16 12:56:56', NULL);
        ";
        $db->execute($insertAnnouncements);
        echo "Announcements örnek verileri eklendi!\n";
    }
    
    // 4. Groups tablosu oluştur
    $createGroupsTable = "
    CREATE TABLE IF NOT EXISTS groups (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        age_group VARCHAR(20) COLLATE utf8mb4_turkish_ci NOT NULL,
        age_category ENUM('minikler','küçükler','yıldızlar','gençler','yetişkinler') COLLATE utf8mb4_turkish_ci NOT NULL,
        min_age INT NOT NULL,
        max_age INT NOT NULL,
        description TEXT COLLATE utf8mb4_turkish_ci,
        training_days VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        training_times VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        monthly_fee DECIMAL(8,2) DEFAULT NULL,
        max_capacity INT DEFAULT '20',
        current_members INT DEFAULT '0',
        status ENUM('active','inactive','full') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createGroupsTable);
    echo "Groups tablosu oluşturuldu veya zaten mevcut!\n";
    
    // Groups örnek verileri ekle
    $groupsCount = $db->query("SELECT COUNT(*) as count FROM groups")[0]['count'];
    if ($groupsCount == 0) {
        $insertGroups = "
        INSERT INTO groups (id, name, age_group, age_category, min_age, max_age, description, training_days, training_times, monthly_fee, max_capacity, current_members, status, created_at, updated_at) VALUES
        (1, 'Minikler Grubu', '6-8 yaş', 'minikler', 6, 8, 'En küçük yaş grubu. Top ile tanışma ve temel motor beceriler.', 'Salı, Perşembe', '16:00-17:00', 150.00, 15, 12, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (2, 'Küçükler Grubu', '9-11 yaş', 'küçükler', 9, 11, 'Temel futbol teknikleri ve oyun kuralları öğretiliyor.', 'Pazartesi, Çarşamba, Cuma', '16:30-17:30', 200.00, 18, 16, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (3, 'Yıldızlar Grubu', '12-14 yaş', 'yıldızlar', 12, 14, 'Taktik bilgisi ve takım oyunu üzerine odaklanılan grup.', 'Pazartesi, Salı, Perşembe, Cuma', '17:00-18:30', 250.00, 20, 18, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (4, 'Gençler Grubu', '15-17 yaş', 'gençler', 15, 17, 'Profesyonel futbola hazırlık grubu.', 'Pazartesi, Salı, Çarşamba, Perşembe, Cuma', '18:00-19:30', 300.00, 22, 20, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (5, 'Yetişkinler Grubu', '18+ yaş', 'yetişkinler', 18, 50, 'Yetişkinler için futbol grubu.', 'Salı, Perşembe', '20:00-21:30', 180.00, 25, 15, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38');
        ";
        $db->execute($insertGroups);
        echo "Groups örnek verileri eklendi!\n";
    }
    
    // 5. Group Coaches tablosu oluştur
    $createGroupCoachesTable = "
    CREATE TABLE IF NOT EXISTS group_coaches (
        id INT NOT NULL AUTO_INCREMENT,
        group_id INT NOT NULL,
        coach_id INT NOT NULL,
        role ENUM('head_coach','assistant_coach','goalkeeper_coach') COLLATE utf8mb4_turkish_ci DEFAULT 'head_coach',
        assigned_date DATE DEFAULT NULL,
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        PRIMARY KEY (id),
        KEY group_id (group_id),
        KEY coach_id (coach_id),
        CONSTRAINT group_coaches_ibfk_1 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE,
        CONSTRAINT group_coaches_ibfk_2 FOREIGN KEY (coach_id) REFERENCES technical_staff (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createGroupCoachesTable);
    echo "Group Coaches tablosu oluşturuldu veya zaten mevcut!\n";
    
    // 6. Matches tablosunu güncelle
    // Yeni alanları ekle
    $matchColumns = [
        "team_id INT NULL AFTER id",
        "league VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER competition",
        "season VARCHAR(20) COLLATE utf8mb4_turkish_ci DEFAULT '2024-25' AFTER league",
        "match_week INT DEFAULT NULL AFTER season",
        "referee VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER status",
        "attendance INT DEFAULT NULL AFTER referee",
        "weather_conditions VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER attendance",
        "match_report TEXT COLLATE utf8mb4_turkish_ci AFTER weather_conditions",
        "highlights_video VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER match_report"
    ];
    
    foreach ($matchColumns as $column) {
        try {
            $db->execute("ALTER TABLE matches ADD COLUMN " . $column);
            echo "Matches tablosuna yeni alan eklendi: " . substr($column, 0, strpos($column, ' ')) . "\n";
        } catch (Exception $e) {
            echo "Matches tablosunda alan zaten mevcut: " . substr($column, 0, strpos($column, ' ')) . "\n";
        }
    }
    
    // Foreign key constraint ekle
    try {
        $db->execute("ALTER TABLE matches ADD CONSTRAINT matches_ibfk_1 FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE SET NULL");
        echo "Matches tablosuna foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Matches tablosunda foreign key constraint zaten mevcut!\n";
    }
    
    // 7. News tablosunu güncelle
    // Yeni alanları ekle
    $newsColumns = [
        "author VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER image",
        "tags VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER category",
        "is_featured TINYINT(1) DEFAULT '0' AFTER views"
    ];
    
    foreach ($newsColumns as $column) {
        try {
            $db->execute("ALTER TABLE news ADD COLUMN " . $column);
            echo "News tablosuna yeni alan eklendi: " . substr($column, 0, strpos($column, ' ')) . "\n";
        } catch (Exception $e) {
            echo "News tablosunda alan zaten mevcut: " . substr($column, 0, strpos($column, ' ')) . "\n";
        }
    }
    
    // category alanını güncelle
    try {
        $db->execute("ALTER TABLE news MODIFY COLUMN category VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'genel'");
        echo "News tablosu category alanı güncellendi!\n";
    } catch (Exception $e) {
        echo "News tablosu category alanı zaten doğru formatta!\n";
    }
    
    // 8. Players tablosunu güncelle
    // Yeni alanları ekle
    $playerColumns = [
        "team_id INT DEFAULT NULL AFTER position",
        "birth_date DATE DEFAULT NULL AFTER team_type",
        "bio TEXT COLLATE utf8mb4_turkish_ci AFTER photo",
        "goals_scored INT DEFAULT '0' AFTER bio",
        "assists INT DEFAULT '0' AFTER goals_scored",
        "yellow_cards INT DEFAULT '0' AFTER assists",
        "red_cards INT DEFAULT '0' AFTER yellow_cards",
        "matches_played INT DEFAULT '0' AFTER red_cards",
        "market_value DECIMAL(12,2) DEFAULT NULL AFTER matches_played",
        "contract_end DATE DEFAULT NULL AFTER market_value",
        "is_captain TINYINT(1) DEFAULT '0' AFTER status",
        "youth_group_id INT DEFAULT NULL AFTER team_id"
    ];
    
    foreach ($playerColumns as $column) {
        try {
            $db->execute("ALTER TABLE players ADD COLUMN " . $column);
            echo "Players tablosuna yeni alan eklendi: " . substr($column, 0, strpos($column, ' ')) . "\n";
        } catch (Exception $e) {
            echo "Players tablosunda alan zaten mevcut: " . substr($column, 0, strpos($column, ' ')) . "\n";
        }
    }
    
    // team_type alanını güncelle
    try {
        $db->execute("ALTER TABLE players MODIFY COLUMN team_type ENUM('A','B','U21','U19','U17','U15','U13','U11','U9') COLLATE utf8mb4_turkish_ci DEFAULT 'A'");
        echo "Players tablosu team_type alanı güncellendi!\n";
    } catch (Exception $e) {
        echo "Players tablosu team_type alanı zaten doğru formatta!\n";
    }
    
    // status alanını güncelle
    try {
        $db->execute("ALTER TABLE players MODIFY COLUMN status ENUM('active','injured','suspended','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active'");
        echo "Players tablosu status alanı güncellendi!\n";
    } catch (Exception $e) {
        echo "Players tablosu status alanı zaten doğru formatta!\n";
    }
    
    // Foreign key constraint ekle
    try {
        $db->execute("ALTER TABLE players ADD CONSTRAINT players_ibfk_1 FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE SET NULL");
        echo "Players tablosuna foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Players tablosunda foreign key constraint zaten mevcut!\n";
    }
    
    // 9. Site Settings tablosunu güncelle
    // Yeni alanları ekle
    $settingsColumns = [
        "setting_group VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'general' AFTER setting_value"
    ];
    
    foreach ($settingsColumns as $column) {
        try {
            $db->execute("ALTER TABLE site_settings ADD COLUMN " . $column);
            echo "Site Settings tablosuna yeni alan eklendi: " . substr($column, 0, strpos($column, ' ')) . "\n";
        } catch (Exception $e) {
            echo "Site Settings tablosunda alan zaten mevcut: " . substr($column, 0, strpos($column, ' ')) . "\n";
        }
    }
    
    // 10. Sliders tablosu oluştur
    $createSlidersTable = "
    CREATE TABLE IF NOT EXISTS sliders (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) COLLATE utf8mb4_turkish_ci NOT NULL,
        description TEXT COLLATE utf8mb4_turkish_ci,
        image VARCHAR(255) COLLATE utf8mb4_turkish_ci NOT NULL,
        link VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        button_text VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        sort_order INT DEFAULT '0',
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY status (status),
        KEY sort_order (sort_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createSlidersTable);
    echo "Sliders tablosu oluşturuldu veya zaten mevcut!\n";
    
    // Sliders örnek verileri ekle
    $slidersCount = $db->query("SELECT COUNT(*) as count FROM sliders")[0]['count'];
    if ($slidersCount == 0) {
        $insertSliders = "
        INSERT INTO sliders (id, title, description, image, link, button_text, sort_order, status, created_at, updated_at) VALUES
        (1, 'Yeni Transferlerimiz Takımımıza Katıldı', 'Bu sezon kadromuzu güçlendiren yeni oyuncularımız ilk antrenmanlarına başladı. Teknik direktörümüz ve yönetimimizin onayladığı transferlerle hedeflerimize emin adımlarla ilerliyoruz.', 'slider1.jpg', '/news', 'Detayları Gör', 1, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (2, 'Yeni Sezon Hazırlıkları Başladı', '2024-25 sezonunda hedefimiz daha üst seviyelere çıkmak. Takımımız yoğun antrenman programıyla sezona hazırlanıyor. Taraftarımızın desteğiyle başarıya ulaşacağız.', 'slider2.jpg', '/ateam', 'A Takımı', 2, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (3, 'Altyapıya Katıl', '6-18 yaş arası tüm gençleri altyapımıza bekliyoruz. Profesyonel antrenörlerimiz ve modern tesislerimizle yeteneğinizi geliştirin. Geleceğin yıldızları olun.', 'slider3.jpg', '/groups', 'Programı Görüntüle', 3, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38');
        ";
        $db->execute($insertSliders);
        echo "Sliders örnek verileri eklendi!\n";
    }
    
    // 11. Teams tablosunu güncelle
    // Yeni alanları ekle
    $teamsColumns = [
        "team_type ENUM('A','B','U21','U19','U17','U15','U13','U11','U9') COLLATE utf8mb4_turkish_ci NOT NULL AFTER name",
        "category ENUM('men','women','youth') COLLATE utf8mb4_turkish_ci DEFAULT 'men' AFTER team_type",
        "league VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER category",
        "coach_id INT DEFAULT NULL AFTER league",
        "season VARCHAR(20) COLLATE utf8mb4_turkish_ci DEFAULT '2024-25' AFTER coach_id",
        "description TEXT COLLATE utf8mb4_turkish_ci AFTER status",
        "founded_year YEAR DEFAULT NULL AFTER description"
    ];
    
    // İlk alanı ekleyelim (team_type)
    try {
        $db->execute("ALTER TABLE teams ADD COLUMN team_type ENUM('A','B','U21','U19','U17','U15','U13','U11','U9') COLLATE utf8mb4_turkish_ci NOT NULL AFTER name");
        echo "Teams tablosuna team_type alanı eklendi!\n";
    } catch (Exception $e) {
        echo "Teams tablosunda team_type alanı zaten mevcut!\n";
    }
    
    // Diğer alanları ekleyelim
    foreach (array_slice($teamsColumns, 1) as $column) {
        try {
            $db->execute("ALTER TABLE teams ADD COLUMN " . $column);
            echo "Teams tablosuna yeni alan eklendi: " . substr($column, 0, strpos($column, ' ')) . "\n";
        } catch (Exception $e) {
            echo "Teams tablosunda alan zaten mevcut: " . substr($column, 0, strpos($column, ' ')) . "\n";
        }
    }
    
    // coach alanını kaldır (yeni coach_id alanı eklendi)
    try {
        $db->execute("ALTER TABLE teams DROP COLUMN coach");
        echo "Teams tablosundan coach alanı kaldırıldı!\n";
    } catch (Exception $e) {
        echo "Teams tablosunda coach alanı zaten kaldırılmış!\n";
    }
    
    // category alanını güncelle
    try {
        $db->execute("ALTER TABLE teams MODIFY COLUMN category ENUM('men','women','youth') COLLATE utf8mb4_turkish_ci DEFAULT 'men'");
        echo "Teams tablosu category alanı güncellendi!\n";
    } catch (Exception $e) {
        echo "Teams tablosu category alanı zaten doğru formatta!\n";
    }
    
    // 12. Technical Staff tablosunu güncelle
    // Yeni alanları ekle
    $technicalStaffColumns = [
        "experience_years INT DEFAULT '0' AFTER bio",
        "license_type VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER experience_years",
        "nationality VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'Türkiye' AFTER license_type",
        "birth_date DATE DEFAULT NULL AFTER nationality",
        "joined_date DATE DEFAULT NULL AFTER birth_date",
        "contract_end DATE DEFAULT NULL AFTER joined_date",
        "phone VARCHAR(20) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER contract_end",
        "email VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL AFTER phone"
    ];
    
    foreach ($technicalStaffColumns as $column) {
        try {
            $db->execute("ALTER TABLE technical_staff ADD COLUMN " . $column);
            echo "Technical Staff tablosuna yeni alan eklendi: " . substr($column, 0, strpos($column, ' ')) . "\n";
        } catch (Exception $e) {
            echo "Technical Staff tablosunda alan zaten mevcut: " . substr($column, 0, strpos($column, ' ')) . "\n";
        }
    }
    
    // position alanını güncelle
    try {
        $db->execute("ALTER TABLE technical_staff MODIFY COLUMN position VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL");
        echo "Technical Staff tablosu position alanı güncellendi!\n";
    } catch (Exception $e) {
        echo "Technical Staff tablosu position alanı zaten doğru formatta!\n";
    }
    
    // 13. Training Schedules tablosu oluştur
    $createTrainingSchedulesTable = "
    CREATE TABLE IF NOT EXISTS training_schedules (
        id INT NOT NULL AUTO_INCREMENT,
        group_id INT NOT NULL,
        day_of_week ENUM('monday','tuesday','wednesday','thursday','friday','saturday','sunday') COLLATE utf8mb4_turkish_ci NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        location VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        training_type VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'normal',
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        PRIMARY KEY (id),
        KEY group_id (group_id),
        CONSTRAINT training_schedules_ibfk_1 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createTrainingSchedulesTable);
    echo "Training Schedules tablosu oluşturuldu veya zaten mevcut!\n";
    
    // Training Schedules örnek verileri ekle
    $trainingSchedulesCount = $db->query("SELECT COUNT(*) as count FROM training_schedules")[0]['count'];
    if ($trainingSchedulesCount == 0) {
        $insertTrainingSchedules = "
        INSERT INTO training_schedules (id, group_id, day_of_week, start_time, end_time, location, training_type, status) VALUES
        (1, 1, 'tuesday', '16:00:00', '17:00:00', 'Ana Saha', 'normal', 'active'),
        (2, 1, 'thursday', '16:00:00', '17:00:00', 'Ana Saha', 'normal', 'active'),
        (3, 2, 'monday', '16:30:00', '17:30:00', 'Ana Saha', 'normal', 'active'),
        (4, 2, 'wednesday', '16:30:00', '17:30:00', 'Ana Saha', 'normal', 'active'),
        (5, 2, 'friday', '16:30:00', '17:30:00', 'Ana Saha', 'normal', 'active'),
        (6, 3, 'monday', '17:00:00', '18:30:00', 'Ana Saha', 'normal', 'active'),
        (7, 3, 'tuesday', '17:00:00', '18:30:00', 'Ana Saha', 'normal', 'active'),
        (8, 3, 'thursday', '17:00:00', '18:30:00', 'Ana Saha', 'normal', 'active'),
        (9, 3, 'friday', '17:00:00', '18:30:00', 'Ana Saha', 'normal', 'active');
        ";
        $db->execute($insertTrainingSchedules);
        echo "Training Schedules örnek verileri eklendi!\n";
    }
    
    // 14. Youth Groups tablosu oluştur
    $createYouthGroupsTable = "
    CREATE TABLE IF NOT EXISTS youth_groups (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
        age_group VARCHAR(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'U9, U11, U13, U15, U17, U19, U21',
        min_age INT NOT NULL,
        max_age INT NOT NULL,
        coach_name VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        assistant_coach VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        training_days VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Pazartesi, Çarşamba, Cuma',
        training_time VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '16:00-18:00',
        max_capacity INT DEFAULT '25',
        current_count INT DEFAULT '0',
        status ENUM('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
        season VARCHAR(20) COLLATE utf8mb4_unicode_ci DEFAULT '2024-25',
        description TEXT COLLATE utf8mb4_unicode_ci,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_age_group (age_group),
        KEY idx_status (status),
        KEY idx_season (season)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->execute($createYouthGroupsTable);
    echo "Youth Groups tablosu oluşturuldu veya zaten mevcut!\n";
    
    // 15. Players tablosuna youth_group_id alanı ekle
    try {
        $db->execute("ALTER TABLE players ADD COLUMN youth_group_id INT DEFAULT NULL AFTER team_id");
        echo "Players tablosuna youth_group_id alanı eklendi!\n";
    } catch (Exception $e) {
        echo "Players tablosunda youth_group_id alanı zaten mevcut!\n";
    }
    
    // 16. Players tablosuna youth_group_id için foreign key constraint ekle
    try {
        $db->execute("ALTER TABLE players ADD CONSTRAINT players_ibfk_2 FOREIGN KEY (youth_group_id) REFERENCES youth_groups (id) ON DELETE SET NULL");
        echo "Players tablosuna youth_group_id için foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Players tablosunda youth_group_id için foreign key constraint zaten mevcut!\n";
    }
    
    // Youth Groups örnek verileri ekle
    $youthGroupsCount = $db->query("SELECT COUNT(*) as count FROM youth_groups")[0]['count'];
    if ($youthGroupsCount == 0) {
        $insertYouthGroups = "
        INSERT INTO youth_groups (id, name, age_group, min_age, max_age, coach_name, assistant_coach, training_days, training_time, max_capacity, current_count, status, season, description, created_at, updated_at) VALUES
        (3, 'U13 Gelecek Grubu', 'U13', 11, 13, 'Ali Kaya', NULL, 'Pazartesi, Çarşamba, Cuma', '16:30-18:00', 25, 0, 'active', '2024-25', 'Temel futbol tekniklerini öğrenen ve takım çalışmasını geliştiren grup.', '2025-10-15 11:20:22', '2025-10-16 13:41:59'),
        (4, 'U15 Yetenek Grubu', 'U15', 13, 15, 'Hasan Çelik', NULL, 'Salı, Perşembe, Cumartesi', '17:00-18:30', 25, 0, 'active', '2024-25', 'Taktik bilgisini artıran ve fiziksel gelişimi destekleyen yetenek grubu.', '2025-10-15 11:20:22', '2025-10-16 13:41:59'),
        (5, 'U17 Elit Grubu', 'U17', 15, 17, 'Mustafa Arslan', NULL, 'Pazartesi, Çarşamba, Cuma, Cumartesi', '17:00-19:00', 25, 0, 'active', '2024-25', 'Profesyonel futbola hazırlanan ve elite seviye eğitim alan grup.', '2025-10-15 11:20:22', '2025-10-16 13:41:59'),
        (6, 'U19 Genç Takım', 'U19', 17, 19, 'Osman Türk', NULL, 'Her gün', '17:00-19:00', 30, 0, 'active', '2024-25', 'A takımına geçiş için hazırlanan genç profesyoneller grubu.', '2025-10-15 11:20:22', '2025-10-16 13:41:59'),
        (7, 'U21 Profesyonel Hazırlık', 'U21', 19, 21, 'İbrahim Şahin', NULL, 'Her gün', '10:00-12:00', 30, 0, 'active', '2024-25', 'Profesyonel kariyere tam hazırlık yapan gelişmiş oyuncular grubu.', '2025-10-15 11:20:22', '2025-10-16 13:41:59'),
        (8, 'U10', 'U10', 8, 10, 'Fatih ÇELEBGİL', 'Oğuz Ünal', 'Pazartesi 10:00, Perşembe 20:00', '', 25, 0, 'active', '2024-25', 'Futbol sevgisini aşılayan ve temel motor becerileri geliştiren grup.', '2025-10-15 12:49:19', '2025-10-16 13:41:59');
        ";
        $db->execute($insertYouthGroups);
        echo "Youth Groups örnek verileri eklendi!\n";
    }
    
    echo "\nVeritabanı şeması başarıyla güncellendi!\n";
    
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}
?>