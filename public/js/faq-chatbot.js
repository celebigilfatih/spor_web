// FAQ Data
const faqData = {
    kayit: [
        {
            question: "Kulübe nasıl üye olabilirim?",
            answer: "Kulübümüze üye olmak için iletişim sayfasındaki telefon numaralarından bizi arayabilir veya email gönderebilirsiniz. Alternatif olarak tesislerimize gelerek kayıt işlemlerinizi tamamlayabilirsiniz."
        },
        {
            question: "Üyelik için gerekli belgeler nelerdir?",
            answer: "Üyelik için nüfus cüzdanı fotokopisi, 2 adet vesikalık fotoğraf ve veli izin belgesi (18 yaş altı için) gerekmektedir. Ayrıca sağlık raporu da istenmektedir."
        },
        {
            question: "Kaç yaşında çocuklar katılabilir?",
            answer: "Alt yapı gruplarımız 8 yaş ve üzeri çocukları kabul etmektedir. U8, U9, U10... şeklinde yaş gruplarına ayrılmış programlarımız bulunmaktadır."
        },
        {
            question: "Deneme antrenmanına katılabilir miyim?",
            answer: "Evet, ilk antrenmanınıza ücretsiz olarak katılabilirsiniz. Böylece hem tesislerimizi hem de antrenman programımızı tanıma fırsatı bulabilirsiniz."
        }
    ],
    antrenman: [
        {
            question: "Antrenmanlar hangi günlerde yapılıyor?",
            answer: "Antrenman günleri yaş gruplarına göre değişiklik göstermektedir. Genellikle hafta içi 3 gün antrenman yapılmaktadır. Detaylı program için Alt Yapı Grupları sayfamızı ziyaret edebilirsiniz."
        },
        {
            question: "Antrenman saatleri nedir?",
            answer: "Antrenmanlar genellikle 16:00-18:00 ve 18:00-20:00 saatleri arasında yapılmaktadır. Yaş grubuna göre antrenman saatleri değişebilir."
        },
        {
            question: "Antrenmanlara hangi malzemeleri getirmeliyim?",
            answer: "Antrenman kıyafeti, krampon, futbol ayakkabısı, içme suyu ve havlu getirmeniz gerekmektedir. Kaleci eldiveni ve dizlik gibi özel ekipmanlar pozisyona göre değişebilir."
        },
        {
            question: "Antrenmanlara katılamadığımda ne olur?",
            answer: "Önceden haber vermeniz durumunda sorun olmaz. Ancak düzenli katılım gelişim için önemlidir. Uzun süreli devamsızlık durumunda antrenörünüz ile görüşmenizi öneriyoruz."
        }
    ],
    ucret: [
        {
            question: "Aylık ücreti ne kadardır?",
            answer: "Aylık üyelik ücretimiz yaş grubuna ve antrenman sayısına göre değişmektedir. Detaylı ücret bilgisi için bizimle iletişime geçebilirsiniz."
        },
        {
            question: "Ödeme şekilleri nelerdir?",
            answer: "Nakit, kredi kartı veya havale ile ödeme yapabilirsiniz. Ayrıca 3, 6 veya 12 aylık paket seçeneklerimiz mevcuttur."
        },
        {
            question: "İndirimler var mı?",
            answer: "Kardeş indirimi, yıllık ödeme indirimi ve erken kayıt indirimi gibi çeşitli kampanyalarımız mevcuttur. Güncel kampanyalar için bizi arayabilirsiniz."
        },
        {
            question: "Ücrete neler dahildir?",
            answer: "Aylık ücrete antrenman programı, antrenör hizmeti, tesis kullanımı ve antrenman malzemeleri dahildir. Forma ve ekipman ücreti ayrıdır."
        }
    ],
    genel: [
        {
            question: "Tesisleriniz nerede bulunuyor?",
            answer: "Tesislerimiz İstanbul'da bulunmaktadır. Detaylı adres bilgisi için iletişim sayfamızı ziyaret edebilirsiniz."
        },
        {
            question: "Antrenörleriniz kimlerdir?",
            answer: "Tüm antrenörlerimiz UEFA lisanslı ve deneyimli profesyonellerdir. Teknik kadro sayfamızdan antrenörlerimizi tanıyabilirsiniz."
        },
        {
            question: "Tesislerinizde neler var?",
            answer: "Modern futbol sahalarımız, soyunma odaları, duşlar, spor malzeme deposu ve izleyici tribünlerimiz bulunmaktadır. Tüm tesislerimiz modern ve güvenli standardlardadır."
        },
        {
            question: "Maçlara katılım var mı?",
            answer: "Evet, yaş gruplarına göre düzenlenen lig ve turnuvalara katılım sağlanmaktadır. Hafta sonları dostluk maçları ve turnuvalar düzenlenmektedir."
        },
        {
            question: "Veliler antrenmanları izleyebilir mi?",
            answer: "Evet, velilerimiz tribünlerden antrenmanları izleyebilirler. Ancak antrenman sahasına giriş sadece antrenörler ve oyunculara açıktır."
        },
        {
            question: "İletişim bilgileriniz nelerdir?",
            answer: "Telefon: +90 (212) 123 45 67, Email: info@sporkulubu.com adreslerinden bize ulaşabilirsiniz. Çalışma saatlerimiz: Pazartesi-Cuma 09:00-18:00, Cumartesi 09:00-15:00."
        }
    ]
};

// DOM Elements
let chatbotMessages, faqCategories, faqItems, faqSearch, clearSearch, resetChat;

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    chatbotMessages = document.getElementById('chatbotMessages');
    faqCategories = document.getElementById('faqCategories');
    faqItems = document.getElementById('faqItems');
    faqSearch = document.getElementById('faqSearch');
    clearSearch = document.getElementById('clearSearch');
    resetChat = document.getElementById('resetChat');
    
    // Add event listeners
    initializeEventListeners();
});

function initializeEventListeners() {
    // Category buttons
    const categoryButtons = document.querySelectorAll('.category-btn');
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            showCategoryQuestions(category);
        });
    });
    
    // Search input
    if (faqSearch) {
        faqSearch.addEventListener('input', handleSearch);
    }
    
    // Clear search button
    if (clearSearch) {
        clearSearch.addEventListener('click', function() {
            faqSearch.value = '';
            clearSearch.style.display = 'none';
            handleSearch();
        });
    }
    
    // Reset chat button
    if (resetChat) {
        resetChat.addEventListener('click', resetChatbot);
    }
}

function showCategoryQuestions(category) {
    const questions = faqData[category];
    
    if (!questions) return;
    
    // Add user message
    addUserMessage(getCategoryName(category));
    
    // Hide categories
    faqCategories.style.display = 'none';
    
    // Show questions
    setTimeout(() => {
        displayFAQItems(questions);
        scrollToBottom();
    }, 300);
}

function getCategoryName(category) {
    const names = {
        kayit: 'Kayıt & Üyelik',
        antrenman: 'Antrenman',
        ucret: 'Ücretler',
        genel: 'Genel Bilgiler'
    };
    return names[category] || category;
}

function addUserMessage(message) {
    const messageHTML = `
        <div class="message-bubble user-message">
            <div class="message-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="message-content">
                <p>${message}</p>
            </div>
        </div>
    `;
    
    chatbotMessages.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

function displayFAQItems(questions, searchTerm = '') {
    faqItems.innerHTML = '';
    
    if (questions.length === 0) {
        showNoResults();
        return;
    }
    
    questions.forEach((faq, index) => {
        const questionText = searchTerm ? highlightText(faq.question, searchTerm) : faq.question;
        const answerText = searchTerm ? highlightText(faq.answer, searchTerm) : faq.answer;
        
        const faqHTML = `
            <div class="faq-item" data-index="${index}">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>${questionText}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>${answerText}</p>
                    </div>
                </div>
            </div>
        `;
        
        faqItems.insertAdjacentHTML('beforeend', faqHTML);
    });
    
    faqItems.style.display = 'block';
}

function toggleFAQ(button) {
    const faqItem = button.closest('.faq-item');
    const isActive = faqItem.classList.contains('active');
    
    // Close all other FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Toggle current item
    if (!isActive) {
        faqItem.classList.add('active');
    }
}

function handleSearch() {
    const searchTerm = faqSearch.value.trim().toLowerCase();
    
    // Show/hide clear button
    clearSearch.style.display = searchTerm ? 'block' : 'none';
    
    if (searchTerm.length < 2) {
        // Reset to categories view if search is cleared
        if (searchTerm.length === 0) {
            resetChatbot();
        }
        return;
    }
    
    // Search across all categories
    const results = searchFAQs(searchTerm);
    
    // Hide categories
    faqCategories.style.display = 'none';
    
    // Display results
    displayFAQItems(results, searchTerm);
}

function searchFAQs(searchTerm) {
    const results = [];
    
    // Search through all categories
    Object.keys(faqData).forEach(category => {
        faqData[category].forEach(faq => {
            const questionMatch = faq.question.toLowerCase().includes(searchTerm);
            const answerMatch = faq.answer.toLowerCase().includes(searchTerm);
            
            if (questionMatch || answerMatch) {
                results.push(faq);
            }
        });
    });
    
    return results;
}

function highlightText(text, searchTerm) {
    if (!searchTerm) return text;
    
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    return text.replace(regex, '<span class="highlight">$1</span>');
}

function showNoResults() {
    const noResultsHTML = `
        <div class="no-results">
            <i class="fas fa-search"></i>
            <h4>Sonuç Bulunamadı</h4>
            <p>Aradığınız soruyu bulamadık. Lütfen farklı anahtar kelimeler deneyin veya bizimle iletişime geçin.</p>
        </div>
    `;
    
    faqItems.innerHTML = noResultsHTML;
    faqItems.style.display = 'block';
}

function resetChatbot() {
    // Clear search
    faqSearch.value = '';
    clearSearch.style.display = 'none';
    
    // Show categories
    faqCategories.style.display = 'grid';
    
    // Clear FAQ items
    faqItems.innerHTML = '';
    faqItems.style.display = 'none';
    
    // Remove user messages (keep only welcome message)
    const userMessages = chatbotMessages.querySelectorAll('.user-message');
    userMessages.forEach(msg => msg.remove());
    
    scrollToBottom();
}

function scrollToBottom() {
    setTimeout(() => {
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }, 100);
}

// Make toggleFAQ available globally
window.toggleFAQ = toggleFAQ;
