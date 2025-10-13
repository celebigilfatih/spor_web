// Form Optimization and Enhancement Script
(function() {
    "use strict";
    
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Form elements
        const form = document.querySelector('.modern-admin-form');
        const fileInput = document.getElementById('photo');
        const submitButton = form ? form.querySelector('button[type="submit"]') : null;
        const firstNameInput = document.getElementById('first_name');
        const jerseyNumberInput = document.getElementById('jersey_number');
        
        // Only proceed if form exists
        if (!form) return;
        
        // Debounce function for performance
        function debounce(func, wait) {
            let timeout;
            return function executedFunction() {
                const args = arguments;
                const later = function() {
                    clearTimeout(timeout);
                    func.apply(null, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        // File Upload Enhancement
        if (fileInput) {
            const uploadLabel = fileInput.parentElement.querySelector('.file-upload-label');
            const uploadText = uploadLabel ? uploadLabel.querySelector('.upload-text') : null;
            const uploadHint = uploadLabel ? uploadLabel.querySelector('.upload-hint') : null;
            const progressContainer = uploadLabel ? uploadLabel.querySelector('.upload-progress') : null;
            const progressBar = progressContainer ? progressContainer.querySelector('.progress-bar') : null;
            const previewContainer = fileInput.parentElement.querySelector('.file-preview');
            
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                // Validate file size (5MB)
                const maxSize = parseInt(fileInput.dataset.maxSize) || 5242880;
                if (file.size > maxSize) {
                    showNotification('Dosya boyutu 5MB\'dan büyük olamaz!', 'error');
                    fileInput.value = '';
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    showNotification('Sadece JPG, PNG ve WebP formatları desteklenir!', 'error');
                    fileInput.value = '';
                    return;
                }
                
                // Show upload progress
                if (progressContainer) progressContainer.style.display = 'block';
                if (uploadText) uploadText.textContent = 'Yüklüyor...';
                
                // Simulate upload progress
                let progress = 0;
                const interval = setInterval(function() {
                    progress += Math.random() * 30;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(interval);
                        
                        // Show preview
                        showFilePreview(file);
                        if (uploadText) uploadText.textContent = 'Fotoğraf Seçildi';
                        if (uploadHint) uploadHint.textContent = file.name;
                        if (progressContainer) progressContainer.style.display = 'none';
                    }
                    if (progressBar) progressBar.style.width = progress + '%';
                }, 100);
            });
            
            function showFilePreview(file) {
                if (!previewContainer) return;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = 
                        '<div class="file-preview-item">' +
                            '<img src="' + e.target.result + '" alt="Önizleme" class="preview-image">' +
                            '<button type="button" class="remove-preview" onclick="removeFilePreview()">' +
                                '<i class="fas fa-times"></i>' +
                            '</button>' +
                        '</div>';
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Global function for removing file preview
        window.removeFilePreview = function() {
            if (fileInput) fileInput.value = '';
            const preview = document.querySelector('.file-preview');
            if (preview) preview.style.display = 'none';
            const uploadText = document.querySelector('.upload-text');
            if (uploadText) uploadText.textContent = 'Fotoğraf Yükle';
            const uploadHint = document.querySelector('.upload-hint');
            if (uploadHint) uploadHint.textContent = 'JPG, PNG, WebP (Max: 5MB)';
        };
        
        // Form Validation Enhancement
        function validateForm() {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    showFieldError(field, 'Bu alan zorunludur');
                    isValid = false;
                } else {
                    hideFieldError(field);
                }
            });
            
            // Jersey number validation
            if (jerseyNumberInput && jerseyNumberInput.value) {
                const number = parseInt(jerseyNumberInput.value);
                if (number < 1 || number > 99) {
                    showFieldError(jerseyNumberInput, 'Forma numarası 1-99 arasında olmalıdır');
                    isValid = false;
                }
            }
            
            return isValid;
        }
        
        function showFieldError(field, message) {
            const wrapper = field.closest('.modern-input-group') || field.closest('.select-wrapper');
            if (!wrapper) return;
            
            let errorElement = wrapper.querySelector('.field-error');
            
            if (!errorElement) {
                errorElement = document.createElement('small');
                errorElement.className = 'field-error';
                wrapper.appendChild(errorElement);
            }
            
            errorElement.textContent = message;
            field.classList.add('error');
        }
        
        function hideFieldError(field) {
            const wrapper = field.closest('.modern-input-group') || field.closest('.select-wrapper');
            if (!wrapper) return;
            
            const errorElement = wrapper.querySelector('.field-error');
            if (errorElement) {
                errorElement.remove();
            }
            field.classList.remove('error');
        }
        
        // Real-time validation
        const debouncedValidation = debounce(function(field) {
            if (field.hasAttribute('required') && field.value.trim()) {
                hideFieldError(field);
            }
        }, 500);
        
        // Add real-time validation to inputs
        form.querySelectorAll('input, select').forEach(function(field) {
            field.addEventListener('input', function() {
                debouncedValidation(field);
            });
            field.addEventListener('blur', function() {
                if (field.hasAttribute('required') && !field.value.trim()) {
                    showFieldError(field, 'Bu alan zorunludur');
                }
            });
        });
        
        // Auto-focus enhancement
        if (firstNameInput) {
            firstNameInput.focus();
        }
        
        // Form submission enhancement
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showNotification('Lütfen tüm zorunlu alanları doldurun', 'error');
                return;
            }
            
            // Show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Kaydediliyor...</span>';
            }
            
            // Add loading class to form
            form.classList.add('loading');
        });
        
        // Notification system
        function showNotification(message, type) {
            type = type || 'info';
            
            // Remove existing notification
            const existing = document.querySelector('.form-notification');
            if (existing) existing.remove();
            
            const notification = document.createElement('div');
            notification.className = 'form-notification notification-' + type;
            notification.innerHTML = 
                '<div class="notification-content">' +
                    '<i class="fas fa-' + (type === 'error' ? 'exclamation-triangle' : 'info-circle') + '"></i>' +
                    '<span>' + message + '</span>' +
                    '<button type="button" class="notification-close" onclick="this.parentElement.parentElement.remove()">' +
                        '<i class="fas fa-times"></i>' +
                    '</button>' +
                '</div>';
            
            // Insert after header
            const header = document.querySelector('.modern-page-header');
            if (header) {
                header.insertAdjacentElement('afterend', notification);
            }
            
            // Auto remove after 5 seconds
            setTimeout(function() {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Only handle shortcuts when form is focused
            if (!form.contains(document.activeElement)) return;
            
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (validateForm()) {
                    form.submit();
                }
            }
            
            // Escape to cancel
            if (e.key === 'Escape') {
                const cancelButton = form.querySelector('a[href*="/admin/players"]');
                if (cancelButton) {
                    cancelButton.click();
                }
            }
        });
        
        // Performance optimization: Preload common icons
        const iconPreloader = document.createElement('div');
        iconPreloader.style.display = 'none';
        iconPreloader.innerHTML = '<i class="fas fa-spinner"></i><i class="fas fa-check"></i><i class="fas fa-times"></i>';
        document.body.appendChild(iconPreloader);
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            document.body.removeChild(iconPreloader);
        });
    });
})();