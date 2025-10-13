/**
 * Admin Panel JavaScript
 * Yönetim paneli için özel JavaScript fonksiyonları
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Sidebar menu aktif link belirleme
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-menu-link');
    
    sidebarLinks.forEach(link => {
        if (currentPath.includes(link.getAttribute('href').split('/').pop())) {
            link.classList.add('active');
        }
    });
    
    // Admin form validasyonu
    const adminForms = document.querySelectorAll('form[data-validate]');
    adminForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateAdminForm(this)) {
                e.preventDefault();
            }
        });
    });
    
    // Resim önizleme
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            previewImage(this);
        });
    });
    
    // Otomatik kaydetme (taslak)
    const contentTextarea = document.getElementById('content');
    if (contentTextarea) {
        let saveTimeout;
        contentTextarea.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                autoSaveDraft();
            }, 30000); // 30 saniye sonra otomatik kaydet
        });
    }
    
    // Tablo sıralama
    initTableSorting();
    
    // Bulk actions
    initBulkActions();
    
    console.log('Admin panel JavaScript yüklendi! 🎯');
});

// Admin form validasyonu
function validateAdminForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showFieldError(input, 'Bu alan zorunludur');
            isValid = false;
        } else if (input.type === 'email' && !isValidEmail(input.value)) {
            showFieldError(input, 'Geçerli bir e-posta adresi giriniz');
            isValid = false;
        } else if (input.type === 'number' && input.hasAttribute('min')) {
            const min = parseInt(input.getAttribute('min'));
            if (parseInt(input.value) < min) {
                showFieldError(input, `Minimum değer: ${min}`);
                isValid = false;
            }
        } else {
            clearFieldError(input);
        }
    });
    
    // Özel validasyonlar
    const jerseyNumber = form.querySelector('input[name="jersey_number"]');
    if (jerseyNumber && jerseyNumber.value) {
        const number = parseInt(jerseyNumber.value);
        if (number < 1 || number > 99) {
            showFieldError(jerseyNumber, 'Forma numarası 1-99 arasında olmalıdır');
            isValid = false;
        }
    }
    
    return isValid;
}

// Resim önizleme
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = input.parentElement.querySelector('.image-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'image-preview';
                preview.style.marginTop = '10px';
                input.parentElement.appendChild(preview);
            }
            
            preview.innerHTML = `
                <img src="${e.target.result}" 
                     style="max-width: 200px; max-height: 200px; border-radius: 8px; object-fit: cover;">
                <button type="button" onclick="removePreview(this)" class="btn btn-admin-danger btn-xs" style="margin-left: 10px;">
                    <i class="fas fa-times"></i> Kaldır
                </button>
            `;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removePreview(button) {
    const preview = button.parentElement;
    const input = preview.parentElement.querySelector('input[type="file"]');
    input.value = '';
    preview.remove();
}

// Otomatik taslak kaydetme
function autoSaveDraft() {
    const form = document.querySelector('form[data-validate]');
    if (!form) return;
    
    const formData = new FormData(form);
    formData.append('auto_save', '1');
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Taslak otomatik kaydedildi', 'info');
        }
    })
    .catch(error => {
        console.log('Otomatik kaydetme hatası:', error);
    });
}

// Tablo sıralama
function initTableSorting() {
    const tables = document.querySelectorAll('.admin-table table');
    tables.forEach(table => {
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            if (!header.textContent.includes('İşlemler') && !header.textContent.includes('Fotoğraf')) {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => sortTable(table, index));
            }
        });
    });
}

function sortTable(table, column) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const sorted = rows.sort((a, b) => {
        const aText = a.cells[column].textContent.trim();
        const bText = b.cells[column].textContent.trim();
        
        // Sayısal değerleri kontrol et
        if (!isNaN(aText) && !isNaN(bText)) {
            return parseFloat(aText) - parseFloat(bText);
        }
        
        return aText.localeCompare(bText, 'tr');
    });
    
    // Sıralamayı tersine çevir (toggle)
    if (table.dataset.lastSort === column.toString()) {
        sorted.reverse();
        table.dataset.lastSort = '';
    } else {
        table.dataset.lastSort = column.toString();
    }
    
    // Tabloyu yeniden oluştur
    tbody.innerHTML = '';
    sorted.forEach(row => tbody.appendChild(row));
}

// Toplu işlemler
function initBulkActions() {
    const checkAll = document.querySelector('.check-all');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
}

function updateBulkActions() {
    const checked = document.querySelectorAll('.row-checkbox:checked');
    const bulkActions = document.querySelector('.bulk-actions');
    
    if (bulkActions) {
        if (checked.length > 0) {
            bulkActions.style.display = 'block';
            bulkActions.querySelector('.selected-count').textContent = checked.length;
        } else {
            bulkActions.style.display = 'none';
        }
    }
}

// Konfirmasyon modali
function showConfirmModal(title, message, onConfirm) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">${title}</h3>
                <button type="button" class="modal-close" onclick="closeModal(this)">&times;</button>
            </div>
            <div class="modal-body">
                <p>${message}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-admin-secondary" onclick="closeModal(this)">İptal</button>
                <button type="button" class="btn btn-admin-danger" onclick="confirmAction(this)">Onayla</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Onay butonuna tıklandığında
    modal.querySelector('.btn-admin-danger').addEventListener('click', function() {
        onConfirm();
        closeModal(this);
    });
}

function closeModal(button) {
    const modal = button.closest('.modal-overlay');
    if (modal) {
        modal.remove();
    }
}

// Dosya boyutu kontrolü
function checkFileSize(input, maxSizeMB = 5) {
    if (input.files && input.files[0]) {
        const fileSize = input.files[0].size / 1024 / 1024; // MB cinsinden
        if (fileSize > maxSizeMB) {
            showToast(`Dosya boyutu ${maxSizeMB}MB'den büyük olamaz!`, 'error');
            input.value = '';
            return false;
        }
    }
    return true;
}

// Karakter sayacı
function initCharacterCounters() {
    const textareas = document.querySelectorAll('textarea[maxlength]');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const counter = document.createElement('div');
        counter.className = 'character-counter';
        counter.style.cssText = 'text-align: right; font-size: 0.8rem; color: var(--gray); margin-top: 5px;';
        
        textarea.parentElement.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            counter.textContent = `${textarea.value.length}/${maxLength}`;
            counter.style.color = remaining < 50 ? 'var(--danger)' : 'var(--gray)';
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });
}

// Slug oluşturucu
function generateSlug(text) {
    return text
        .toLowerCase()
        .replace(/ğ/g, 'g')
        .replace(/ü/g, 'u')
        .replace(/ş/g, 's')
        .replace(/ı/g, 'i')
        .replace(/ö/g, 'o')
        .replace(/ç/g, 'c')
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
}

// Admin panel özel toast mesajları
window.showAdminToast = function(message, type = 'info', duration = 5000) {
    const toast = document.createElement('div');
    toast.className = `admin-toast admin-toast-${type}`;
    toast.innerHTML = `
        <div class="admin-toast-content">
            <i class="fas fa-${getToastIcon(type)}"></i>
            <span>${message}</span>
            <button class="admin-toast-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'});
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        min-width: 300px;
    `;
    
    document.body.appendChild(toast);
    
    // Otomatik kaldırma
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, duration);
};

// Arama filtresi
function initSearchFilter() {
    const searchInput = document.querySelector('.admin-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('.admin-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
}

// Sayfa yüklendiğinde çalıştır
document.addEventListener('DOMContentLoaded', function() {
    initCharacterCounters();
    initSearchFilter();
});

// Yardımcı fonksiyonlar
function showFieldError(input, message) {
    input.classList.add('is-invalid');
    let errorDiv = input.parentElement.querySelector('.invalid-feedback');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        input.parentElement.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
}

function clearFieldError(input) {
    input.classList.remove('is-invalid');
    const errorDiv = input.parentElement.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function getToastIcon(type) {
    switch(type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-triangle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

// CSS Animasyonları
const adminStyle = document.createElement('style');
adminStyle.textContent = `
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .admin-table th:hover {
        background-color: var(--dark-navy);
    }
    
    .image-preview img {
        transition: transform 0.3s ease;
    }
    
    .image-preview img:hover {
        transform: scale(1.05);
    }
`;
document.head.appendChild(adminStyle);