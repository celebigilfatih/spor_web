<?php
/**
 * News Seeder - 10 Sample News Articles
 */

// Include the framework
require_once dirname(__DIR__) . '/index.php';

try {
    // Load the News model
    require_once BASE_PATH . '/app/models/News.php';
    $newsModel = new News();
    
    $sampleNews = [
        [
            'title' => 'Şampiyonluk Yolunda Kritik Galibiyet',
            'slug' => 'sampiyonluk-yolunda-kritik-galibiyet',
            'content' => 'Takımımız dün akşam sahasında oynadığı maçta rakibini 3-1 mağlup ederek şampiyonluk yarışında önemli bir adım attı. İlk yarıda etkili bir futbol sergileyen takımımız, ikinci yarıda da üstünlüğünü sürdürerek sahadan galip ayrıldı. Teknik Direktörümüz maç sonrası yaptığı açıklamada oyuncularını kutladı ve şampiyonluk yolunda iddialı olduklarını belirtti.',
            'excerpt' => 'Takımımız şampiyonluk yarışında kritik bir galibiyet aldı.',
            'category' => 'mac_sonucu',
            'status' => 'published',
            'featured' => 1,
            'published_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
            'title' => 'Yeni Transfer Açıklaması',
            'slug' => 'yeni-transfer-aciklamasi',
            'content' => 'Kulüp yönetimi, yeni sezon hazırlıkları kapsamında yapılacak transferler hakkında önemli açıklamalarda bulundu. Teknik ekibin istekleri doğrultusunda hem savunma hem de hücum hattına takviyeler yapılacağı belirtildi. Transfer görüşmelerinin devam ettiği ve yakın zamanda sürpriz isimlerin açıklanacağı müjdesi verildi.',
            'excerpt' => 'Transfer çalışmaları hakkında önemli açıklama yapıldı.',
            'category' => 'transfer',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'title' => 'Alt Yapı Takımlarımız Başarılı',
            'slug' => 'alt-yapi-takimlarimiz-basarili',
            'content' => 'Kulübümüzün alt yapı takımları bu hafta sonu oynadıkları maçlarda başarılı sonuçlar aldı. U19 takımımız liginde 4-2 galip gelirken, U16 takımımız da rakibini 3-0 mağlup etti. U14 ve U12 takımlarımız da berabere kaldı. Alt yapı koordinatörümüz, genç yeteneklerin gösterdiği performanstan son derece memnun olduklarını ifade etti.',
            'excerpt' => 'Alt yapı takımlarımız hafta sonu başarılı sonuçlar aldı.',
            'category' => 'haber',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
        ],
        [
            'title' => 'Stadyum Modernizasyon Çalışmaları',
            'slug' => 'stadyum-modernizasyon-calismalari',
            'content' => 'Stadyumumuzun modernizasyon çalışmaları yoğun bir şekilde devam ediyor. Koltuk yenileme, aydınlatma sistemi güncellemesi ve kamera altyapısı iyileştirmesi yapılan çalışmalar arasında. Taraftarlarımızın daha konforlu bir ortamda maç izlemesi için yapılan bu yatırımın önümüzdeki ay tamamlanması planlanıyor.',
            'excerpt' => 'Stadyum modernizasyon çalışmaları devam ediyor.',
            'category' => 'duyuru',
            'status' => 'published',
            'featured' => 1,
            'published_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ],
        [
            'title' => 'Kaptanımız Milli Takıma Çağrıldı',
            'slug' => 'kaptanimiz-milli-takima-cagirildi',
            'content' => 'Takım kaptanımız, önümüzdeki hafta oynanacak milli maçlar için A Milli Takım kadrosuna çağrıldı. Sezon başından beri gösterdiği istikrarlı performansla dikkat çeken oyuncumuz, milli forma için büyük bir heyecan yaşadığını belirtti. Kulübümüz olarak kaptanımızı kutluyor ve başarılar diliyoruz.',
            'excerpt' => 'Takım kaptanımız milli takım kadrosuna seçildi.',
            'category' => 'haber',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
        ],
        [
            'title' => 'Gençlik Akademisi Kayıtları Başladı',
            'slug' => 'genclik-akademisi-kayitlari-basladi',
            'content' => 'Kulübümüzün Gençlik Akademisi 2024-2025 sezonu kayıtları başladı. 8-16 yaş arası futbol sevdalısı gençlerin başvurabileceği akademimizde, deneyimli antrenörler eşliğinde profesyonel eğitim verilmektedir. Kayıt için kulüp web sitemizden online başvuru yapabilir veya kulüp merkezimizi ziyaret edebilirsiniz.',
            'excerpt' => 'Gençlik akademisi kayıtları için başvurular alınıyor.',
            'category' => 'duyuru',
            'status' => 'published',
            'featured' => 1,
            'published_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
        ],
        [
            'title' => 'Deplasman Galibiyeti Moralleri Yükseltti',
            'slug' => 'deplasman-galibiyeti-moralleri-yukseltti',
            'content' => 'Zor bir deplasmanda aldığımız 2-1\'lik galibiyet takım moralini yükseltti. İlk yarıda geride başladığımız maçta ikinci yarıda harika bir dönüş yaparak sahadan 3 puanla ayrıldık. Bu galibiyet sayesinde ligde üst sıralara yükseldik. Oyuncularımız ve teknik ekibimiz büyük bir mücadele ortaya koydu.',
            'excerpt' => 'Deplasmanda kazandığımız galibiyet moralleri yükseltti.',
            'category' => 'mac_sonucu',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-8 days'))
        ],
        [
            'title' => 'Sosyal Sorumluluk Projesi Hayata Geçti',
            'slug' => 'sosyal-sorumluluk-projesi-hayata-gecti',
            'content' => 'Kulübümüzün öncülüğünde başlatılan "Her Çocuk Futbol Oynasın" projesi hayata geçirildi. Proje kapsamında maddi imkansızlıkları olan çocuklara spor malzemesi yardımı yapılacak ve ücretsiz futbol eğitimi verilecek. İlk etapta 100 çocuğa ulaşmayı hedeflediğimiz projenin toplumsal duyarlılık açısından örnek olmasını umuyoruz.',
            'excerpt' => 'Sosyal sorumluluk projemiz başarıyla hayata geçirildi.',
            'category' => 'duyuru',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-9 days'))
        ],
        [
            'title' => 'Teknik Direktör Röportajı',
            'slug' => 'teknik-direktor-roportaji',
            'content' => 'Teknik Direktörümüz özel bir röportajda sezonun ilk yarısını değerlendirdi ve ikinci yarı hedeflerinden bahsetti. "Oyuncularımızın gösterdiği gelişimden son derece memnunum. Takım olarak her geçen gün daha iyi bir uyum yakalıyoruz" diyen hoca, şampiyonluk için mücadele edeceklerini vurguladı. Transfer konusunda da iyimser olduğunu belirtti.',
            'excerpt' => 'Teknik direktörümüz sezon değerlendirmesi yaptı.',
            'category' => 'haber',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
        ],
        [
            'title' => 'Taraftar Buluşması Düzenlendi',
            'slug' => 'taraftar-bulusmasi-duzenlendi',
            'content' => 'Kulüp yönetimi ve futbolcularımız taraftarlarımızla özel bir buluşma gerçekleştirdi. Etkinlikte yöneticilerimiz sezon hedeflerini paylaşırken, futbolcularımız da taraftarlarla sohbet etti ve fotoğraf çektirdi. Yoğun ilgi gören organizasyonda imza günü de düzenlendi. Kulüp başkanı, taraftarlarımızın desteğinin her zaman yanlarında olduğunu söyledi.',
            'excerpt' => 'Taraftarlarımızla özel bir buluşma gerçekleştirildi.',
            'category' => 'haber',
            'status' => 'published',
            'featured' => 0,
            'published_at' => date('Y-m-d H:i:s', strtotime('-11 days'))
        ]
    ];
    
    echo "Haberler ekleniyor...\n\n";
    
    foreach ($sampleNews as $index => $news) {
        $news['created_at'] = $news['published_at'];
        $news['updated_at'] = date('Y-m-d H:i:s');
        $news['author_id'] = 1; // Default admin
        $news['views'] = rand(50, 500); // Random view count
        
        $result = $newsModel->create($news);
        
        if ($result) {
            echo "✅ " . ($index + 1) . ". Haber eklendi: " . $news['title'] . "\n";
        } else {
            echo "❌ " . ($index + 1) . ". Haber eklenemedi: " . $news['title'] . "\n";
            $error = $newsModel->getLastError();
            if ($error) {
                echo "   Hata: " . $error . "\n";
            }
        }
    }
    
    echo "\n✨ İşlem tamamlandı! 10 haber başarıyla eklendi.\n";
    echo "📰 Haberleri görüntülemek için: " . BASE_URL . "/admin/news\n";
    
} catch (Exception $e) {
    echo "❌ Hata: " . $e->getMessage() . "\n";
}
