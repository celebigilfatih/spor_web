-- Sample Data for Sports Club Database
-- Insert demo data for testing and demonstration

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Insert site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_title', 'Spor Kulübü', 'general'),
('site_description', 'Türkiye\'nin önde gelen spor kulüplerinden biri', 'general'),
('contact_email', 'info@sporkulubu.com', 'contact'),
('contact_phone', '+90 (212) 555-0123', 'contact'),
('contact_address', 'Spor Caddesi No:123, Beşiktaş, İstanbul', 'contact'),
('facebook_url', 'https://facebook.com/sporkulubu', 'social'),
('twitter_url', 'https://twitter.com/sporkulubu', 'social'),
('instagram_url', 'https://instagram.com/sporkulubu', 'social'),
('youtube_url', 'https://youtube.com/sporkulubu', 'social');

-- Insert admin user (password: admin123)
INSERT INTO `admins` (`username`, `email`, `password`, `full_name`, `role`, `status`) VALUES
('admin', 'admin@sporkulubu.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'super_admin', 'active');

-- Insert teams
INSERT INTO `teams` (`name`, `team_type`, `category`, `league`, `season`, `status`, `description`) VALUES
('A Takımı', 'A', 'men', '1. Lig', '2024-25', 'active', 'Kulübümüzün en üst düzey takımı'),
('B Takımı', 'B', 'men', '2. Lig', '2024-25', 'active', 'Yedek ve genç oyunculardan oluşan takım'),
('U21 Takımı', 'U21', 'youth', 'U21 Ligi', '2024-25', 'active', '21 yaş altı gençler takımı'),
('U19 Takımı', 'U19', 'youth', 'U19 Ligi', '2024-25', 'active', '19 yaş altı gençler takımı'),
('U17 Takımı', 'U17', 'youth', 'U17 Ligi', '2024-25', 'active', '17 yaş altı gençler takımı');

-- Insert technical staff
INSERT INTO `technical_staff` (`name`, `position`, `team_id`, `bio`, `experience_years`, `license_type`, `nationality`, `birth_date`, `joined_date`, `status`) VALUES
('Mehmet Özkan', 'Baş Antrenör', 1, 'Deneyimli baş antrenör. 15 yıllık profesyonel futbol geçmişi var.', 15, 'UEFA A Lisansı', 'Türkiye', '1975-06-15', '2023-07-01', 'active'),
('Ali Demir', 'Antrenör', 1, 'Yardımcı antrenör olarak görev yapıyor.', 8, 'UEFA B Lisansı', 'Türkiye', '1980-03-22', '2023-07-01', 'active'),
('Fatih Kaya', 'Kaleci Antrenörü', 1, 'Kaleciler için özel antrenörlük yapıyor.', 12, 'Kaleci Antrenörü Lisansı', 'Türkiye', '1978-11-30', '2023-07-01', 'active'),
('Dr. Ahmet Yıldız', 'Doktor', 1, 'Takım doktoru olarak görev yapıyor.', 20, 'Tıp Doktoru', 'Türkiye', '1970-09-10', '2020-01-15', 'active'),
('Hasan Çelik', 'Kondisyoner', 1, 'Fitness ve kondisyon antrenörü.', 10, 'Kondisyon Antrenörü Sertifikası', 'Türkiye', '1982-04-18', '2022-08-01', 'active');

-- Insert players for A Team
INSERT INTO `players` (`name`, `jersey_number`, `position`, `team_id`, `team_type`, `birth_date`, `nationality`, `height`, `weight`, `bio`, `goals_scored`, `assists`, `matches_played`, `status`) VALUES
('Emre Güven', 1, 'Kaleci', 1, 'A', '1995-03-15', 'Türkiye', 185, 80, 'Deneyimli kaleci. Takımın lideri.', 0, 0, 25, 'active'),
('Burak Yılmaz', 2, 'Defans', 1, 'A', '1996-07-20', 'Türkiye', 180, 75, 'Sağ bek pozisyonunda oynuyor.', 2, 5, 23, 'active'),
('Serkan Polat', 3, 'Defans', 1, 'A', '1994-11-08', 'Türkiye', 183, 78, 'Sol bek. Hızlı ve teknikli oyuncu.', 1, 8, 24, 'active'),
('Murat Arslan', 4, 'Defans', 1, 'A', '1993-05-12', 'Türkiye', 188, 82, 'Stopor. Takımın kaptanı.', 3, 2, 25, 'active'),
('Can Öztürk', 5, 'Defans', 1, 'A', '1997-09-25', 'Türkiye', 186, 79, 'Merkez bek. Genç ve yetenekli.', 1, 1, 20, 'active'),
('Oğuz Şahin', 6, 'Orta Saha', 1, 'A', '1995-12-03', 'Türkiye', 175, 70, 'Defansif orta saha. Pas ustası.', 2, 12, 24, 'active'),
('Tolga Acar', 7, 'Orta Saha', 1, 'A', '1996-08-18', 'Türkiye', 172, 68, 'Sağ kanat. Hızlı ve dribling ustası.', 8, 15, 23, 'active'),
('Kemal Doğan', 8, 'Orta Saha', 1, 'A', '1994-04-30', 'Türkiye', 178, 73, 'Merkez orta saha. Oyun kurucu.', 5, 18, 25, 'active'),
('Deniz Kara', 9, 'Forvet', 1, 'A', '1995-01-22', 'Türkiye', 182, 76, 'Santrafor. Takımın gol makinesi.', 18, 6, 24, 'active'),
('Arda Turan', 10, 'Orta Saha', 1, 'A', '1993-02-14', 'Türkiye', 174, 69, 'Sol kanat. Kreatif oyuncu.', 12, 14, 22, 'active'),
('Cenk Erdem', 11, 'Forvet', 1, 'A', '1996-10-05', 'Türkiye', 179, 74, 'Sol forvet. Genç yetenek.', 6, 4, 18, 'active');

-- Insert groups
INSERT INTO `groups` (`name`, `age_group`, `age_category`, `min_age`, `max_age`, `description`, `training_days`, `training_times`, `monthly_fee`, `max_capacity`, `current_members`, `status`) VALUES
('Minikler Grubu', '6-8 yaş', 'minikler', 6, 8, 'En küçük yaş grubu. Top ile tanışma ve temel motor beceriler.', 'Salı, Perşembe', '16:00-17:00', 150.00, 15, 12, 'active'),
('Küçükler Grubu', '9-11 yaş', 'küçükler', 9, 11, 'Temel futbol teknikleri ve oyun kuralları öğretiliyor.', 'Pazartesi, Çarşamba, Cuma', '16:30-17:30', 200.00, 18, 16, 'active'),
('Yıldızlar Grubu', '12-14 yaş', 'yıldızlar', 12, 14, 'Taktik bilgisi ve takım oyunu üzerine odaklanılan grup.', 'Pazartesi, Salı, Perşembe, Cuma', '17:00-18:30', 250.00, 20, 18, 'active'),
('Gençler Grubu', '15-17 yaş', 'gençler', 15, 17, 'Profesyonel futbola hazırlık grubu.', 'Pazartesi, Salı, Çarşamba, Perşembe, Cuma', '18:00-19:30', 300.00, 22, 20, 'active'),
('Yetişkinler Grubu', '18+ yaş', 'yetişkinler', 18, 50, 'Yetişkinler için futbol grubu.', 'Salı, Perşembe', '20:00-21:30', 180.00, 25, 15, 'active');

-- Insert training schedules
INSERT INTO `training_schedules` (`group_id`, `day_of_week`, `start_time`, `end_time`, `location`, `training_type`) VALUES
(1, 'tuesday', '16:00:00', '17:00:00', 'Ana Saha', 'normal'),
(1, 'thursday', '16:00:00', '17:00:00', 'Ana Saha', 'normal'),
(2, 'monday', '16:30:00', '17:30:00', 'Ana Saha', 'normal'),
(2, 'wednesday', '16:30:00', '17:30:00', 'Ana Saha', 'normal'),
(2, 'friday', '16:30:00', '17:30:00', 'Ana Saha', 'normal'),
(3, 'monday', '17:00:00', '18:30:00', 'Ana Saha', 'normal'),
(3, 'tuesday', '17:00:00', '18:30:00', 'Ana Saha', 'normal'),
(3, 'thursday', '17:00:00', '18:30:00', 'Ana Saha', 'normal'),
(3, 'friday', '17:00:00', '18:30:00', 'Ana Saha', 'normal');

-- Insert matches
INSERT INTO `matches` (`team_id`, `home_team`, `away_team`, `match_date`, `venue`, `league`, `season`, `match_week`, `home_score`, `away_score`, `status`) VALUES
(1, 'Spor Kulübü', 'Rakip Takım A', '2024-10-20 15:00:00', 'Ev Sahası', '1. Lig', '2024-25', 8, 2, 1, 'finished'),
(1, 'Deplasman Takımı', 'Spor Kulübü', '2024-10-13 19:00:00', 'Deplasman Stadı', '1. Lig', '2024-25', 7, 1, 3, 'finished'),
(1, 'Spor Kulübü', 'Güçlü Rakip', '2024-10-25 20:00:00', 'Ev Sahası', '1. Lig', '2024-25', 9, NULL, NULL, 'scheduled'),
(1, 'İyi Takım', 'Spor Kulübü', '2024-11-01 16:00:00', 'Şehir Stadı', '1. Lig', '2024-25', 10, NULL, NULL, 'scheduled'),
(1, 'Spor Kulübü', 'Zor Rakip', '2024-11-08 19:30:00', 'Ev Sahası', '1. Lig', '2024-25', 11, NULL, NULL, 'scheduled');

-- Insert news
INSERT INTO `news` (`title`, `slug`, `content`, `excerpt`, `author`, `category`, `is_featured`, `status`, `published_at`) VALUES
('Yeni Sezon Hazırlıkları Başladı', 'yeni-sezon-hazirliklari-basladi', 
'<p>Kulübümüz 2024-25 sezonuna hazırlanmak için antrenmanlarına başladı. Teknik direktörümüz Mehmet Özkan yönetiminde yapılan ilk antrenmanda tüm oyuncular yer aldı.</p>
<p>Bu sezon hedefimiz ligin üst sıralarında yer almak ve genç yetenekleri üst düzey futbola kazandırmak.</p>
<p>Sezon öncesi hazırlık kampımız 15 gün sürecek ve bu süre zarfında takımımız 3 hazırlık maçı oynayacak.</p>',
'Kulübümüz 2024-25 sezonuna hazırlanmak için antrenmanlarına başladı.', 
'Spor Kulübü', 'takım', 1, 'published', '2024-10-10 10:00:00'),

('Yeni Transfer: Deniz Kara Takımımızda', 'yeni-transfer-deniz-kara', 
'<p>Kulübümüz, deneyimli forvet Deniz Kara ile 2 yıllık sözleşme imzaladı. 29 yaşındaki oyuncu, geçen sezon 18 gol atarak dikkat çekmişti.</p>
<p>Deniz Kara: "Bu kulüpte oynamaktan çok mutluyum. Elimden gelen her şeyi yapacağım." dedi.</p>
<p>Başkan Ahmet Yılmaz ise transferin kulüp için önemli olduğunu belirtti.</p>',
'Deneyimli forvet Deniz Kara kulübümüze katıldı.', 
'Spor Kulübü', 'transfer', 1, 'published', '2024-10-08 14:30:00'),

('Altyapıdan Yeni Yıldız: Can Öztürk', 'altyapidan-yeni-yildiz-can-ozturk', 
'<p>Kulübümüz altyapısından yetişen Can Öztürk, A takıma yükseldi. 19 yaşındaki genç oyuncu, merkez bek pozisyonunda forma giyecek.</p>
<p>Altyapı sorumlusu: "Can\'ın büyük bir potansiyeli var. Çok çalışkan ve yetenekli bir oyuncu." değerlendirmesinde bulundu.</p>',
'Altyapımızdan Can Öztürk A takıma yükseldi.', 
'Spor Kulübü', 'altyapı', 0, 'published', '2024-10-05 16:15:00'),

('Sosyal Sorumluluk Projesi Başlatıldı', 'sosyal-sorumluluk-projesi', 
'<p>Kulübümüz, dezavantajlı çocuklar için ücretsiz futbol kursu projesi başlattı. Proje kapsamında 50 çocuk ücretsiz antrenman yapabilecek.</p>
<p>Başkan Yardımcısı Mehmet Demir: "Sporun toplumsal faydası için elimizden geleni yapıyoruz." dedi.</p>',
'Dezavantajlı çocuklar için ücretsiz futbol kursu başlatıldı.', 
'Spor Kulübü', 'sosyal', 0, 'published', '2024-10-03 11:00:00');

-- Insert sliders
INSERT INTO `sliders` (`title`, `description`, `image`, `link`, `button_text`, `sort_order`, `status`) VALUES
('Yeni Transferlerimiz Takımımıza Katıldı', 'Bu sezon kadromuzu güçlendiren yeni oyuncularımız ilk antrenmanlarına başladı. Teknik direktörümüz ve yönetimimizin onayladığı transferlerle hedeflerimize emin adımlarla ilerliyoruz.', 'slider1.jpg', '/news', 'Detayları Gör', 1, 'active'),
('Yeni Sezon Hazırlıkları Başladı', '2024-25 sezonunda hedefimiz daha üst seviyelere çıkmak. Takımımız yoğun antrenman programıyla sezona hazırlanıyor. Taraftarımızın desteğiyle başarıya ulaşacağız.', 'slider2.jpg', '/ateam', 'A Takımı', 2, 'active'),
('Altyapıya Katıl', '6-18 yaş arası tüm gençleri altyapımıza bekliyoruz. Profesyonel antrenörlerimiz ve modern tesislerimizle yeteneğinizi geliştirin. Geleceğin yıldızları olun.', 'slider3.jpg', '/groups', 'Programı Görüntüle', 3, 'active');

-- Insert about us sections
INSERT INTO `about_us` (`section_name`, `title`, `content`, `sort_order`, `status`) VALUES
('main', 'Kulübümüz Hakkında', 
'<p>1929 yılında kurulan spor kulübümüz, Türkiye\'nin en köklü ve başarılı spor kuruluşlarından biridir. 95 yıllık geçmişimizde, binlerce gencin spor hayatına başlamasına vesile olmuş, çok sayıda milli sporcu yetiştirmiş ve ulusal ile uluslararası arenada önemli başarılara imza atmışız.</p>
<p>Modern tesislerimiz, deneyimli teknik kadromuz ve güçlü altyapımızla geleceğin yıldızlarını yetiştirmeye devam ediyoruz. Sporun sadece fiziksel değil, aynı zamanda karakteri de geliştiren bir araç olduğuna inanıyor, bu doğrultuda gençlerimizi yetiştiriyoruz.</p>', 
1, 'active'),

('history', 'Tarihçemiz', 
'<p>Kulübümüz 1929 yılında bir grup futbol sevdalısı tarafından kuruldu. İlk yıllarda mahalle takımı olarak başlayan yolculuğumuz, zamanla profesyonel lige kadar uzandı.</p>
<p><strong>1929:</strong> Kulüp kuruldu<br>
<strong>1950:</strong> İlk şampiyonluk<br>
<strong>1975:</strong> Modern tesis açıldı<br>
<strong>1995:</strong> Altyapı akademisi kuruldu<br>
<strong>2010:</strong> Yeni stadyum inşaatı<br>
<strong>2024:</strong> 95. yıl kutlamaları</p>', 
2, 'active'),

('mission', 'Misyon ve Vizyon', 
'<p><strong>Misyonumuz:</strong> Gençleri spora yönlendirmek, yeteneklerini geliştirmek ve sporin evrensel değerlerini benimseyen, başarılı sporcular yetiştirmek.</p>
<p><strong>Vizyonumuz:</strong> Türkiye\'nin önde gelen spor kulüplerinden biri olarak, uluslararası arenada ülkemizi en iyi şekilde temsil etmek.</p>
<p><strong>Değerlerimiz:</strong> Dürüstlük, takım ruhu, mükemmellik, sürekli gelişim ve toplumsal sorumluluk.</p>', 
3, 'active');

SET FOREIGN_KEY_CHECKS = 1;