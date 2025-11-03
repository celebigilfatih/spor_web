<?php
/**
 * Database Initialization Script
 * Bu dosya veritabanı tablolarını oluşturur ve test verilerini ekler
 */

require_once '../config/database.php';
require_once '../core/Database.php';

try {
    $db = new Database();
    
    echo "Veritabanı bağlantısı başarılı!\n";
    
    // Admins tablosu oluştur
    $createAdminsTable = "
    CREATE TABLE IF NOT EXISTS admins (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(50) COLLATE utf8mb4_turkish_ci NOT NULL,
        email VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        password VARCHAR(255) COLLATE utf8mb4_turkish_ci NOT NULL,
        full_name VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        role ENUM('admin','super_admin') COLLATE utf8mb4_turkish_ci DEFAULT 'admin',
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        last_login TIMESTAMP NULL DEFAULT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY username (username),
        UNIQUE KEY email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createAdminsTable);
    echo "Admins tablosu oluşturuldu!\n";
    
    // Admins örnek verileri ekle
    $adminsCount = $db->query("SELECT COUNT(*) as count FROM admins")[0]['count'];
    if ($adminsCount == 0) {
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $insertAdmins = "
        INSERT INTO admins (id, username, email, password, full_name, role, status, last_login, created_at, updated_at) VALUES
        (1, 'admin', 'admin@sporkulubu.com', '$hashedPassword', 'Admin User', 'super_admin', 'active', '2025-10-17 12:42:52', '2025-10-13 10:07:38', '2025-10-17 12:42:52');
        ";
        $db->execute($insertAdmins);
        echo "Admins örnek verileri eklendi!\n";
        echo "Email: admin@sporkulubu.com\n";
        echo "Şifre: password\n";
    } else {
        echo "Admins örnek verileri zaten mevcut!\n";
    }
    
    // About Us tablosu oluştur
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
    echo "About Us tablosu oluşturuldu!\n";
    
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
    
    // Announcements tablosu oluştur
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
    echo "Announcements tablosu oluşturuldu!\n";
    
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
    
    // Groups tablosu oluştur
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
    echo "Groups tablosu oluşturuldu!\n";
    
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
    
    // Group Coaches tablosu oluştur
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
        KEY coach_id (coach_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createGroupCoachesTable);
    echo "Group Coaches tablosu oluşturuldu!\n";
    
    // Group Coaches tablosuna foreign key constraint ekle (varsa önce kaldır)
    try {
        $db->execute("ALTER TABLE group_coaches DROP FOREIGN KEY group_coaches_ibfk_1");
    } catch (Exception $e) {
        // Constraint zaten yok
    }
    
    try {
        $db->execute("ALTER TABLE group_coaches DROP FOREIGN KEY group_coaches_ibfk_2");
    } catch (Exception $e) {
        // Constraint zaten yok
    }
    
    try {
        $db->execute("ALTER TABLE group_coaches ADD CONSTRAINT group_coaches_ibfk_1 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE");
        echo "Group Coaches tablosuna group_id foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Group Coaches tablosunda group_id foreign key constraint zaten mevcut!\n";
    }
    
    try {
        $db->execute("ALTER TABLE group_coaches ADD CONSTRAINT group_coaches_ibfk_2 FOREIGN KEY (coach_id) REFERENCES technical_staff (id) ON DELETE CASCADE");
        echo "Group Coaches tablosuna coach_id foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Group Coaches tablosunda coach_id foreign key constraint zaten mevcut!\n";
    }
    
    // Matches tablosu oluştur
    $createMatchesTable = "
    CREATE TABLE IF NOT EXISTS matches (
        id INT NOT NULL AUTO_INCREMENT,
        team_id INT DEFAULT NULL,
        home_team VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        away_team VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        match_date DATETIME NOT NULL,
        venue VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        competition VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL COMMENT 'Competition type (Liga, Kupa, etc.)',
        league VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        season VARCHAR(20) COLLATE utf8mb4_turkish_ci DEFAULT '2024-25',
        match_week INT DEFAULT NULL,
        home_score INT DEFAULT NULL,
        away_score INT DEFAULT NULL,
        status ENUM('scheduled','live','finished','cancelled','postponed') COLLATE utf8mb4_turkish_ci DEFAULT 'scheduled',
        referee VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        attendance INT DEFAULT NULL,
        weather_conditions VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        match_report TEXT COLLATE utf8mb4_turkish_ci,
        highlights_video VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY team_id (team_id),
        KEY match_date (match_date),
        KEY status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createMatchesTable);
    echo "Matches tablosu oluşturuldu!\n";
    
    // Matches tablosuna foreign key constraint ekle (varsa önce kaldır)
    try {
        $db->execute("ALTER TABLE matches DROP FOREIGN KEY matches_ibfk_1");
    } catch (Exception $e) {
        // Constraint zaten yok
    }
    
    try {
        $db->execute("ALTER TABLE matches ADD CONSTRAINT matches_ibfk_1 FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE SET NULL");
        echo "Matches tablosuna foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Matches tablosunda foreign key constraint zaten mevcut!\n";
    }
    
    // Matches örnek verileri ekle
    $matchesCount = $db->query("SELECT COUNT(*) as count FROM matches")[0]['count'];
    if ($matchesCount == 0) {
        $insertMatches = "
        INSERT INTO matches (id, team_id, home_team, away_team, match_date, venue, competition, league, season, match_week, home_score, away_score, status, referee, attendance, weather_conditions, match_report, highlights_video, created_at, updated_at) VALUES
        (7, NULL, 'Fenerbahçe', 'Galatasaray', '2025-11-11 19:00:00', 'Şükrü Saraçoğlu', 'Liga', NULL, '2024-25', NULL, NULL, NULL, 'scheduled', NULL, NULL, NULL, NULL, NULL, '2025-10-17 15:11:04', '2025-10-17 12:11:04'),
        (8, NULL, 'Özlüce', 'Yeni Karaman', '2025-11-21 21:00:00', 'Şükrü Saraçoğlu', 'Hazırlık', NULL, '2024-25', NULL, NULL, NULL, 'scheduled', NULL, NULL, NULL, NULL, NULL, '2025-10-17 15:11:46', '2025-10-17 12:12:05'),
        (9, NULL, 'Nilüferspor', 'Yıldırımspor', '2025-11-11 22:22:00', 'Nilüfer Stadı', '', NULL, '2024-25', NULL, NULL, NULL, 'scheduled', NULL, NULL, NULL, NULL, NULL, '2025-10-17 15:44:51', '2025-10-17 12:44:51');
        ";
        $db->execute($insertMatches);
        echo "Matches örnek verileri eklendi!\n";
    }
    
    // News tablosu oluştur
    $createNewsTable = "
    CREATE TABLE IF NOT EXISTS news (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) COLLATE utf8mb4_turkish_ci NOT NULL,
        slug VARCHAR(255) COLLATE utf8mb4_turkish_ci NOT NULL,
        content LONGTEXT COLLATE utf8mb4_turkish_ci NOT NULL,
        excerpt TEXT COLLATE utf8mb4_turkish_ci,
        image VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        featured_image VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        author VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        category VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'genel',
        tags VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        views INT DEFAULT '0',
        priority INT DEFAULT '0',
        is_featured TINYINT(1) DEFAULT '0',
        status ENUM('draft','published','archived') COLLATE utf8mb4_turkish_ci DEFAULT 'published',
        published_at TIMESTAMP NULL DEFAULT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY slug (slug),
        KEY status (status),
        KEY published_at (published_at),
        KEY is_featured (is_featured)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createNewsTable);
    echo "News tablosu oluşturuldu!\n";
    
    // News örnek verileri ekle
    $newsCount = $db->query("SELECT COUNT(*) as count FROM news")[0]['count'];
    if ($newsCount == 0) {
        $insertNews = "
        INSERT INTO news (id, title, slug, content, excerpt, image, author, category, tags, views, is_featured, status, published_at, created_at, updated_at) VALUES
        (6, 'Şampiyonluk Yolunda Kritik Galibiyet', 'sampiyonluk-yolunda-kritik-galibiyet', '<p>Takımımız, şampiyonluk yolunda kritik bir adım atarak deplasmanda rakibini 3-1 mağlup etti. Maçın ilk yarısında etkili futbol sergileyen takımımız, ikinci yarıda da kontrolü elden bırakmadı.</p><p>Teknik direktörümüz maç sonrası yaptığı açıklamada, oyuncuların gösterdiği performanstan memnun olduğunu belirtti. \"Bugün sahada büyük bir mücadele verdik ve bunu galibiyetle taçlandırdık. Şampiyonluk yolunda önemli 3 puan aldık\" dedi.</p><p>Takımımız ligde şu ana kadar 15 maçta 35 puan toplayarak lider konumunu koruyor.</p>', 'Takımımız deplasmanda kazandığı 3-1''lik galibiyetle şampiyonluk yolunda önemli bir adım attı. Teknik direktör performanstan memnun.', '68f0db09ae428.jpg', 'admin', 'haber', 'şampiyonluk,galibiyet,maç', 250, 1, 'published', '2025-10-16 14:46:17', '2025-10-15 08:03:43', '2025-10-16 12:58:18'),
        (7, 'Yeni Transfer Açıklaması: Star Oyuncu Geliyor', 'yeni-transfer-aciklamasi-star-oyuncu-geliyor', '<p>Kulüp yönetimi, uzun süredir gündemde olan transfer çalışmaları hakkında açıklama yaptı. Yönetim kurulu başkanımız, önümüzdeki sezon için önemli takviyeler yapacaklarını söyledi.</p><p>\"Takımımızı daha da güçlendirmek için çalışmalarımız devam ediyor. Çok yakında önemli bir transferi açıklayacağız\" şeklinde konuşan başkan, taraftarlarımızı heyecanlandırdı.</p><p>Kulisten gelen bilgilere göre, Avrupa liglerinde forma giyen tecrübeli bir oyuncuyla ön anlaşma sağlandı.</p>', 'Kulüp yönetimi yeni sezon için önemli transfer hamlesi yapacağını açıkladı. Avrupa deneyimli star oyuncu geliyor.', 'transfer-haberi.jpg', 'admin', 'transfer', 'transfer,kadro,yeni sezon', 190, 0, 'published', '2025-10-16 14:11:02', '2025-10-15 08:03:43', '2025-10-16 14:11:02'),
        (8, 'Alt Yapı Takımlarımız Başarılı Sonuçlar Alıyor', 'alt-yapi-takimlarimiz-basarili-sonuclar-aliyor', '<p>Kulübümüzün alt yapı takımları, liglerde gösterdikleri performansla dikkat çekiyor. U19 takımımız son 5 maçın tamamını kazanarak zirve yarışında iddiasını sürdürüyor.</p><p>Alt yapı koordinatörümüz, genç oyuncuların gelişiminden son derece memnun olduklarını belirtti. \"Burada yetişen gençlerimiz yarın A takımımızın yıldızları olacak\" dedi.</p><p>U17 ve U15 takımlarımız da kategorilerinde üst sıralarda yer alıyor. Kulübümüzün geleceğe yönelik yatırımları meyve vermeye başladı.</p>', 'Alt yapı takımlarımız liglerinde başarılı sonuçlar almaya devam ediyor. U19 takımı zirve yarışında.', 'alt-yapi-basari.jpg', 'Genç Takımlar Editörü', 'alt-yapi', 'alt yapı,genç takımlar,u19', 156, 0, 'published', '2025-10-08 16:45:00', '2025-10-15 08:03:43', '2025-10-15 08:03:43'),
        (9, 'Futbol Takımımız Play-Off Kilitlendi', 'basketbol-takimimiz-play-off-a-kilitlendi', '<p>Basketbol takımımız, bu sezon gösterdiği istikrarlı performansla play-off''a katılmayı garantiledi. Dün akşam oynanan kritik maçı kazanan takımımız, matematiksel olarak ilk 8''e girdi.</p><p>Baş antrenörümüz, \"Sezon başında koyduğumuz hedeflere ulaşmanın mutluluğunu yaşıyoruz. Şimdi hedefimiz play-off''ta en iyi performansı sergilemek\" dedi.</p><p>Takım kaptanımız da başarıda emeği geçen herkese teşekkür etti ve taraftarlara destekleri için minnettarlığını ifade etti.</p>', 'Basketbol takımımız sezonun geri kalanında play-off garantisini aldı. Hedef şimdi play-off&amp;#039;ta iddialı olmak.', '68f0e969ce567.jpg', 'admin', 'haber', 'basketbol,play-off,başarı', 204, 0, 'published', '2025-10-16 15:47:37', '2025-10-15 08:03:43', '2025-10-16 12:49:12'),
        (10, 'Voleybol Şubemizden Çifte Şampiyonluk', 'voleybol-subemizden-cifte-sampiyonluk', '<p>Voleybol şubemiz muhteşem bir sezon geçirerek hem kadınlar hem de erkekler kategorisinde şampiyonluk sevinci yaşadı. Her iki takım da final maçlarını kazanarak kupalarını müzelerine götürdü.</p><p>Kadın voleybol takımımız, final serisini 3-1 önde tamamlayarak üst üste ikinci şampiyonluğunu kazandı. Erkek takımımız ise 10 yıl aradan sonra şampiyonluğa ulaştı.</p><p>Kulüp başkanımız, \"Voleybol şubemiz kulübümüzün gururu. Bu başarı herkesin emeğinin karşılığı\" dedi.</p>', 'Voleybol şubemiz hem kadınlar hem erkekler kategorisinde şampiyonluk kupasını kazandı. Tarihi başarı.', 'voleybol-sampiyonluk.jpg', 'admin', 'duyuru', 'voleybol,şampiyonluk,kadın,erkek', 312, 1, 'published', '2025-10-16 15:50:57', '2025-10-15 08:03:43', '2025-10-16 15:50:57'),
        (11, 'Yeni Tesisimiz Açılıyor', 'yeni-tesisimiz-aciliyor', '<p>Kulübümüzün yeni antrenman tesisleri gelecek hafta törenle açılacak. Modern altyapısıyla dikkat çeken tesis, sporcularımıza en iyi koşullarda çalışma imkanı sunacak.</p><p>10 bin metrekare alan üzerine kurulan tesiste; 2 tam boy futbol sahası, kapalı spor salonu, fitness merkezi ve olimpik yüzme havuzu bulunuyor.</p><p>Yönetim kurulu başkanımız, \"Bu tesis kulübümüzün geleceğine yapılmış en büyük yatırım. Sporcularımız artık Avrupa standartlarında tesislerde çalışacak\" dedi.</p>', 'Kulübümüzün modern antrenman tesisleri gelecek hafta açılıyor. Avropa standartlarında yeni tesis.', '68f0ee0f54632.jpg', 'admin', 'duyuru', 'tesis,yatırım,antrenman', 178, 0, 'published', '2025-10-16 16:07:27', '2025-10-15 08:03:43', '2025-10-16 16:07:27'),
        (12, 'Taraftar Derneklerimizle Buluşma Gerçekleşti', 'taraftar-derneklerimizle-bulusma-gerceklesti', '<p>Kulüp yönetimi, taraftar dernekleri temsilcileriyle bir araya geldi. Toplantıda kulübün güncel durumu, gelecek planları ve taraftarların talepleri konuşuldu.</p><p>Başkanımız, \"Taraftarlarımız kulübümüzün en önemli paydaşları. Onların görüş ve önerilerine her zaman değer veriyoruz\" dedi.</p><p>Toplantıda ayrıca yeni sezon kombine kart fiyatları, tribün düzenlemeleri ve taraftar etkinlikleri gibi konular da ele alındı. Taraftar temsilcileri, yönetimin yaklaşımından memnun kaldıklarını ifade etti.</p>', 'Kulüp yönetimi taraftar dernekleriyle bir araya geldi. Güncel durumlar ve gelecek planları konuşuldu.', 'taraftar-bulusmasi.jpg', 'Spor Editörü', 'genel', 'taraftar,yönetim,toplantı', 134, 0, 'published', '2025-10-04 15:20:00', '2025-10-15 08:03:43', '2025-10-15 08:03:43'),
        (13, 'Genç Yıldızımız Milli Takıma Çağrıldı', 'genc-yildizimiz-milli-takima-cagirildi', '<p>Alt yapımızdan yetişen genç futbolcumuz, milli takım teknik direktörünün radarına girdi ve ilk kez milli takım kadrosuna çağrıldı. 20 yaşındaki yetenekli oyuncumuz, önümüzdeki iki hazırlık maçında forma giyebilecek.</p><p>Genç yıldızımız, \"Çocukluk hayalim gerçek oluyor. Bu kulüpte yetişmekten gurur duyuyorum\" dedi.</p><p>Teknik direktörümüz, \"Onun bu başarısı alt yapı çalışmalarımızın ne kadar doğru olduğunu gösteriyor. Kendisiyle gurur duyuyoruz\" şeklinde konuştu.</p>', 'Alt yapımızdan yetişen genç futbolcumuz ilk kez milli takım kadrosuna çağrıldı. Kulübümüzün gururu.', 'milli-takim.jpg', 'Genç Takımlar Editörü', 'futbol', 'milli takım,genç oyuncu,alt yapı', 267, 1, 'published', '2025-10-03 09:45:00', '2025-10-15 08:03:43', '2025-10-15 08:03:43'),
        (14, 'Spor Okullarımıza Yoğun İlgi', 'spor-okulllarimiza-yogun-ilgi', '<p>Kulübümüzün yaz dönemi spor okulları için başvurular başladı. Futbol, basketbol, voleybol ve yüzme dallarında açılan kurslara yoğun ilgi gösteriliyor.</p><p>6-16 yaş arası çocuklar için düzenlenen spor okullarında, profesyonel antrenörler eşliğinde eğitim verilecek. Programda teknik çalışmaların yanı sıra fair-play, takım ruhu gibi değerler de öğretilecek.</p><p>Spor okulları koordinatörümüz, \"Çocuklarımıza sadece spor yapmayı değil, yaşam becerilerini de öğretiyoruz\" dedi. Başvurular önümüzdeki hafta sona erecek.</p>', 'Kulübümüzün yaz dönemi spor okulları için başvurular başladı. Çeşitli branşlarda eğitim verilecek.', 'spor-okulu.jpg', 'admin', 'duyuru', 'spor okulu,çocuklar,eğitim', 145, 0, 'published', '2025-10-16 16:11:59', '2025-10-15 08:03:43', '2025-10-16 16:11:59'),
        (15, 'Stadyum Renovasyonu Tamamlandı', 'stadyum-renovasyonu-tamamlandi', '<p>Ev sahamız olan stadyumun renovasyon çalışmaları tamamlandı. 6 ay süren çalışmalar sonucunda stadyum modern bir görünüme kavuştu.</p><p>Yenileme çalışmaları kapsamında; koltuklar yenilendi, aydınlatma sistemi güçlendirildi, VIP loca sayısı artırıldı ve engelli erişimi kolaylaştırıldı. Ayrıca stadyum çatısı tamamen yenilenerek su yalıtımı yapıldı.</p><p>Başkanımız, \"Taraftarlarımız artık daha konforlu bir ortamda takımlarını destekleyecekler. Bu yatırım kulübümüzün geleceğine yapılmış bir yatırımdır\" dedi.</p>', 'Stadyumumuzun 6 aylık renovasyon çalışmaları tamamlandı. Modern ve konforlu bir stadyum.', 'stadyum-renovasyon.jpg', 'admin', 'duyuru', 'stadyum,renovasyon,yatırım', 198, 0, 'published', '2025-10-16 15:53:43', '2025-10-15 08:03:43', '2025-10-16 15:53:43');
        ";
        $db->execute($insertNews);
        echo "News örnek verileri eklendi!\n";
    }
    
    // Players tablosu oluştur
    $createPlayersTable = "
    CREATE TABLE IF NOT EXISTS players (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        jersey_number INT DEFAULT NULL,
        position VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        team_id INT DEFAULT NULL,
        team_type ENUM('A','B','U21','U19','U17','U15','U13','U11','U9') COLLATE utf8mb4_turkish_ci DEFAULT 'A',
        birth_date DATE DEFAULT NULL,
        nationality VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'Türkiye',
        height INT DEFAULT NULL,
        weight INT DEFAULT NULL,
        photo VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        bio TEXT COLLATE utf8mb4_turkish_ci,
        goals_scored INT DEFAULT '0',
        assists INT DEFAULT '0',
        yellow_cards INT DEFAULT '0',
        red_cards INT DEFAULT '0',
        matches_played INT DEFAULT '0',
        market_value DECIMAL(12,2) DEFAULT NULL,
        contract_end DATE DEFAULT NULL,
        status ENUM('active','injured','suspended','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY team_id (team_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createPlayersTable);
    echo "Players tablosu oluşturuldu!\n";
    
    // Players tablosuna foreign key constraint ekle (varsa önce kaldır)
    try {
        $db->execute("ALTER TABLE players DROP FOREIGN KEY players_ibfk_1");
    } catch (Exception $e) {
        // Constraint zaten yok
    }
    
    try {
        $db->execute("ALTER TABLE players ADD CONSTRAINT players_ibfk_1 FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE SET NULL");
        echo "Players tablosuna foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Players tablosunda foreign key constraint zaten mevcut!\n";
    }
    
    // Players örnek verileri ekle
    $playersCount = $db->query("SELECT COUNT(*) as count FROM players")[0]['count'];
    if ($playersCount == 0) {
        $insertPlayers = "
        INSERT INTO players (id, name, jersey_number, position, team_id, team_type, birth_date, nationality, height, weight, photo, bio, goals_scored, assists, yellow_cards, red_cards, matches_played, market_value, contract_end, status, created_at, updated_at) VALUES
        (1, 'Emre Güven', 1, 'Kaleci', 1, 'A', '1995-03-15', 'Türkiye', 185, 80, NULL, 'Deneyimli kaleci. Takımın lideri.', 0, 0, 0, 0, 25, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (2, 'Burak Yılmaz', 2, 'Defans', 1, 'A', '1996-07-20', 'Türkiye', 180, 75, NULL, 'Sağ bek pozisyonunda oynuyor.', 2, 5, 0, 0, 23, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (3, 'Serkan Polat', 3, 'Defans', 1, 'A', '1994-11-08', 'Türkiye', 183, 78, NULL, 'Sol bek. Hızlı ve teknikli oyuncu.', 1, 8, 0, 0, 24, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (4, 'Murat Arslan', 4, 'Defans', 1, 'A', '1993-05-12', 'Türkiye', 188, 82, NULL, 'Stopor. Takımın kaptanı.', 3, 2, 0, 0, 25, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (5, 'Can Öztürk', 5, 'Defans', 1, 'A', '1997-09-25', 'Türkiye', 186, 79, NULL, 'Merkez bek. Genç ve yetenekli.', 1, 1, 0, 0, 20, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (6, 'Oğuz Şahin', 6, 'Orta Saha', 1, 'A', '1995-12-03', 'Türkiye', 175, 70, NULL, 'Defansif orta saha. Pas ustası.', 2, 12, 0, 0, 24, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (7, 'Tolga Acar', 7, 'Orta Saha', 1, 'A', '1996-08-18', 'Türkiye', 172, 68, NULL, 'Sağ kanat. Hızlı ve dribling ustası.', 8, 15, 0, 0, 23, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (8, 'Kemal Doğan', 8, 'Orta Saha', 1, 'A', '1994-04-30', 'Türkiye', 178, 73, NULL, 'Merkez orta saha. Oyun kurucu.', 5, 18, 0, 0, 25, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (9, 'Deniz Kara', 9, 'Forvet', 1, 'A', '1995-01-22', 'Türkiye', 182, 76, NULL, 'Santrafor. Takımın gol makinesi.', 18, 6, 0, 0, 24, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (10, 'Arda Turan', 10, 'Orta Saha', 1, 'A', '1993-02-14', 'Türkiye', 174, 69, NULL, 'Sol kanat. Kreatif oyuncu.', 12, 14, 0, 0, 22, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (11, 'Cenk Erdem', 11, 'Forvet', 1, 'A', '1996-10-05', 'Türkiye', 179, 74, NULL, 'Sol forvet. Genç yetenek.', 6, 4, 0, 0, 18, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (12, 'Alex De Souze', 31, 'Orta Saha', 1, 'A', '2000-10-10', 'Türkiye', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, 'active', '2025-10-15 16:59:23', '2025-10-15 13:59:23'),
        (13, 'Arda Güler', 33, 'Orta Saha', 1, 'A', '2000-01-10', 'Türkiye', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, 'active', '2025-10-15 16:59:51', '2025-10-15 13:59:51'),
        (14, 'Fatih Celebigil', 23, 'Forvet', 1, 'A', '2025-10-16', 'Türkiye', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL, 'active', '2025-10-16 09:09:34', '2025-10-16 06:09:34');
        ";
        $db->execute($insertPlayers);
        echo "Players örnek verileri eklendi!\n";
    }
    
    // Site Settings tablosu oluştur
    $createSiteSettingsTable = "
    CREATE TABLE IF NOT EXISTS site_settings (
        id INT NOT NULL AUTO_INCREMENT,
        setting_key VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        setting_value TEXT COLLATE utf8mb4_turkish_ci,
        setting_group VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'general',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY setting_key (setting_key)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createSiteSettingsTable);
    echo "Site Settings tablosu oluşturuldu!\n";
    
    // Site Settings örnek verileri ekle
    $siteSettingsCount = $db->query("SELECT COUNT(*) as count FROM site_settings")[0]['count'];
    if ($siteSettingsCount == 0) {
        $insertSiteSettings = "
        INSERT INTO site_settings (id, setting_key, setting_value, setting_group, created_at, updated_at) VALUES
        (1, 'site_title', 'Kültür Spor', 'general', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (2, 'site_description', 'Türkiye''nin önde gelen spor klüpleri bizim alt yapımızı kullanıyor.', 'general', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (3, 'contact_email', 'info@sporkulubu.com', 'contact', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (4, 'contact_phone', '+90 (212) 555-0123', 'contact', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (5, 'contact_address', 'Spor Caddesi No:123, Beşiktaş, İstanbul', 'contact', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (6, 'facebook_url', 'https://facebook.com/sporkulubu', 'social', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (7, 'twitter_url', 'https://twitter.com/sporkulubu', 'social', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (8, 'instagram_url', 'https://instagram.com/sporkulubu', 'social', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (9, 'youtube_url', 'https://youtube.com/sporkulubu', 'social', '2025-10-13 10:07:38', '2025-10-17 07:23:21'),
        (10, 'site_logo', '68f1df11ed903.jpeg', 'general', '2025-10-17 05:47:56', '2025-10-17 06:15:46'),
        (11, 'site_favicon', '', 'general', '2025-10-17 05:47:57', '2025-10-17 05:47:57'),
        (12, 'club_founded', '', 'general', '2025-10-17 05:58:26', '2025-10-17 07:23:21'),
        (13, 'club_colors', '', 'general', '2025-10-17 05:58:26', '2025-10-17 07:23:21'),
        (14, 'stadium_name', '', 'general', '2025-10-17 05:58:26', '2025-10-17 07:23:21'),
        (15, 'stadium_capacity', '', 'general', '2025-10-17 05:58:26', '2025-10-17 07:23:21');
        ";
        $db->execute($insertSiteSettings);
        echo "Site Settings örnek verileri eklendi!\n";
    }
    
    // Sliders tablosu oluştur
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
    echo "Sliders tablosu oluşturuldu!\n";
    
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
    
    // Teams tablosu oluştur
    $createTeamsTable = "
    CREATE TABLE IF NOT EXISTS teams (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        team_type ENUM('A','B','U21','U19','U17','U15','U13','U11','U9') COLLATE utf8mb4_turkish_ci NOT NULL,
        category ENUM('men','women','youth') COLLATE utf8mb4_turkish_ci DEFAULT 'men',
        league VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        coach_id INT DEFAULT NULL,
        season VARCHAR(20) COLLATE utf8mb4_turkish_ci DEFAULT '2024-25',
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        description TEXT COLLATE utf8mb4_turkish_ci,
        founded_year YEAR DEFAULT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createTeamsTable);
    echo "Teams tablosu oluşturuldu!\n";
    
    // Teams örnek verileri ekle
    $teamsCount = $db->query("SELECT COUNT(*) as count FROM teams")[0]['count'];
    if ($teamsCount == 0) {
        $insertTeams = "
        INSERT INTO teams (id, name, team_type, category, league, coach_id, season, status, description, founded_year, created_at, updated_at) VALUES
        (1, 'A Takımı', 'A', 'men', '1. Lig', NULL, '2024-25', 'active', 'Kulübümüzün en üst düzey takımı', NULL, '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (2, 'B Takımı', 'B', 'men', '2. Lig', NULL, '2024-25', 'active', 'Yedek ve genç oyunculardan oluşan takım', NULL, '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (3, 'U21 Takımı', 'U21', 'youth', 'U21 Ligi', NULL, '2024-25', 'active', '21 yaş altı gençler takımı', NULL, '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (4, 'U19 Takımı', 'U19', 'youth', 'U19 Ligi', NULL, '2024-25', 'active', '19 yaş altı gençler takımı', NULL, '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (5, 'U17 Takımı', 'U17', 'youth', 'U17 Ligi', NULL, '2024-25', 'active', '17 yaş altı gençler takımı', NULL, '2025-10-13 10:07:38', '2025-10-13 10:07:38');
        ";
        $db->execute($insertTeams);
        echo "Teams örnek verileri eklendi!\n";
    }
    
    // Technical Staff tablosu oluştur
    $createTechnicalStaffTable = "
    CREATE TABLE IF NOT EXISTS technical_staff (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        position VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
        team_id INT DEFAULT NULL,
        photo VARCHAR(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        bio TEXT COLLATE utf8mb4_turkish_ci,
        experience_years INT DEFAULT '0',
        license_type VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        nationality VARCHAR(50) COLLATE utf8mb4_turkish_ci DEFAULT 'Türkiye',
        birth_date DATE DEFAULT NULL,
        joined_date DATE DEFAULT NULL,
        contract_end DATE DEFAULT NULL,
        phone VARCHAR(20) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        email VARCHAR(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
        status ENUM('active','inactive') COLLATE utf8mb4_turkish_ci DEFAULT 'active',
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY team_id (team_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createTechnicalStaffTable);
    echo "Technical Staff tablosu oluşturuldu!\n";
    
    // Technical Staff tablosuna foreign key constraint ekle (varsa önce kaldır)
    try {
        $db->execute("ALTER TABLE technical_staff DROP FOREIGN KEY technical_staff_ibfk_1");
    } catch (Exception $e) {
        // Constraint zaten yok
    }
    
    try {
        $db->execute("ALTER TABLE technical_staff ADD CONSTRAINT technical_staff_ibfk_1 FOREIGN KEY (team_id) REFERENCES teams (id) ON DELETE SET NULL");
        echo "Technical Staff tablosuna foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Technical Staff tablosunda foreign key constraint zaten mevcut!\n";
    }
    
    // Technical Staff örnek verileri ekle
    $technicalStaffCount = $db->query("SELECT COUNT(*) as count FROM technical_staff")[0]['count'];
    if ($technicalStaffCount == 0) {
        $insertTechnicalStaff = "
        INSERT INTO technical_staff (id, name, position, team_id, photo, bio, experience_years, license_type, nationality, birth_date, joined_date, contract_end, phone, email, status, created_at, updated_at) VALUES
        (1, 'Mehmet Özkan', 'Baş Antrenör', 1, NULL, 'Deneyimli baş antrenör. 15 yıllık profesyonel futbol geçmişi var.', 15, 'UEFA A Lisansı', 'Türkiye', '1975-06-15', '2023-07-01', NULL, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (2, 'Ali Demir', 'Antrenör', 1, NULL, 'Yardımcı antrenör olarak görev yapıyor.', 8, 'UEFA B Lisansı', 'Türkiye', '1980-03-22', '2023-07-01', NULL, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (3, 'Fatih Kaya', 'Kaleci Antrenörü', 1, NULL, 'Kaleciler için özel antrenörlük yapıyor.', 12, 'Kaleci Antrenörü Lisansı', 'Türkiye', '1978-11-30', '2023-07-01', NULL, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (4, 'Dr. Ahmet Yıldız', 'Doktor', 1, NULL, 'Takım doktoru olarak görev yapıyor.', 20, 'Tıp Doktoru', 'Türkiye', '1970-09-10', '2020-01-15', NULL, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38'),
        (5, 'Hasan Çelik', 'Kondisyoner', 1, NULL, 'Fitness ve kondisyon antrenörü.', 10, 'Kondisyon Antrenörü Sertifikası', 'Türkiye', '1982-04-18', '2022-08-01', NULL, NULL, NULL, 'active', '2025-10-13 10:07:38', '2025-10-13 10:07:38');
        ";
        $db->execute($insertTechnicalStaff);
        echo "Technical Staff örnek verileri eklendi!\n";
    }
    
    // Training Schedules tablosu oluştur
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
        KEY group_id (group_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
    ";
    
    $db->execute($createTrainingSchedulesTable);
    echo "Training Schedules tablosu oluşturuldu!\n";
    
    // Training Schedules tablosuna foreign key constraint ekle (varsa önce kaldır)
    try {
        $db->execute("ALTER TABLE training_schedules DROP FOREIGN KEY training_schedules_ibfk_1");
    } catch (Exception $e) {
        // Constraint zaten yok
    }
    
    try {
        $db->execute("ALTER TABLE training_schedules ADD CONSTRAINT training_schedules_ibfk_1 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE");
        echo "Training Schedules tablosuna foreign key constraint eklendi!\n";
    } catch (Exception $e) {
        echo "Training Schedules tablosunda foreign key constraint zaten mevcut!\n";
    }
    
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
    
    // Youth Groups tablosu oluştur
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
    echo "Youth Groups tablosu oluşturuldu!\n";
    
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
    
    echo "\nVeritabanı başarıyla hazırlandı!\n";
    echo "Admin paneline erişmek için: " . BASE_URL . "/admin/login\n";
    echo "Email: admin@sporkulubu.com\n";
    echo "Şifre: password\n";
    
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}
?>