/**
 * Modern Delete Confirmation System
 * Replaces basic confirm() dialogs with beautiful modals
 */

// CSS Custom Properties for the deletion system
const deleteModalStyles = `
    :root {
        --delete-overlay-bg: rgba(30, 60, 114, 0.85);
        --delete-modal-bg: #ffffff;
        --delete-danger-color: #dc3545;
        --delete-danger-hover: #c82333;
        --delete-secondary-color: #6c757d;
        --delete-secondary-hover: #5a6268;
        --delete-border-radius: 12px;
        --delete-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        --delete-transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .delete-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--delete-overlay-bg);
        backdrop-filter: blur(8px);
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
        transition: var(--delete-transition);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .delete-modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .delete-modal {
        background: var(--delete-modal-bg);
        border-radius: var(--delete-border-radius);
        box-shadow: var(--delete-shadow);
        max-width: 480px;
        width: 100%;
        transform: scale(0.8) translateY(50px);
        transition: var(--delete-transition);
        overflow: hidden;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    .delete-modal-overlay.show .delete-modal {
        transform: scale(1) translateY(0);
    }

    .delete-modal-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 24px 28px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
    }

    .delete-modal-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .delete-modal-title {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .delete-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--delete-transition);
        font-size: 14px;
    }

    .delete-modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .delete-modal-body {
        padding: 32px 28px;
        text-align: center;
    }

    .delete-modal-warning {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: #e17055;
        animation: deleteWarningPulse 2s infinite;
    }

    @keyframes deleteWarningPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .delete-modal-message {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 8px;
        font-weight: 500;
        line-height: 1.4;
    }

    .delete-modal-submessage {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .delete-modal-item-info {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 16px;
        margin: 20px 0;
        text-align: left;
    }

    .delete-modal-item-name {
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }

    .delete-modal-item-details {
        font-size: 13px;
        color: #6c757d;
    }

    .delete-modal-actions {
        padding: 20px 28px 28px;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .delete-modal-btn {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--delete-transition);
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 120px;
        justify-content: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .delete-modal-btn-cancel {
        background: var(--delete-secondary-color);
        color: white;
    }

    .delete-modal-btn-cancel:hover {
        background: var(--delete-secondary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .delete-modal-btn-confirm {
        background: var(--delete-danger-color);
        color: white;
    }

    .delete-modal-btn-confirm:hover {
        background: var(--delete-danger-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .delete-modal-btn:active {
        transform: translateY(0);
    }

    .delete-modal-btn-loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .delete-modal-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: deleteSpinner 1s linear infinite;
    }

    @keyframes deleteSpinner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive design */
    @media (max-width: 480px) {
        .delete-modal {
            margin: 20px;
            max-width: calc(100% - 40px);
        }
        
        .delete-modal-header {
            padding: 20px 24px;
        }
        
        .delete-modal-body {
            padding: 24px 20px;
        }
        
        .delete-modal-actions {
            padding: 16px 24px 24px;
            flex-direction: column;
        }
        
        .delete-modal-btn {
            width: 100%;
        }
    }

    /* Animation classes */
    .delete-modal-overlay.removing {
        opacity: 0;
        visibility: hidden;
    }

    .delete-modal-overlay.removing .delete-modal {
        transform: scale(0.8) translateY(50px);
    }
`;

// Inject styles
const styleSheet = document.createElement('style');
styleSheet.textContent = deleteModalStyles;
document.head.appendChild(styleSheet);

// Delete confirmation system
class DeleteConfirmation {
    constructor() {
        this.currentModal = null;
        this.bindEvents();
    }

    bindEvents() {
        // Close modal when clicking outside
        document.addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('delete-modal-overlay')) {
                this.close();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.currentModal) {
                this.close();
            }
        });
    }

    show(options = {}) {
        const {
            title = 'Silme Onayı',
            message = 'Bu öğeyi silmek istediğinizden emin misiniz?',
            submessage = 'Bu işlem geri alınamaz.',
            itemName = '',
            itemDetails = '',
            confirmText = 'Sil',
            cancelText = 'İptal',
            onConfirm = () => {},
            onCancel = () => {}
        } = options;

        // Remove existing modal if any
        this.close();

        // Create modal HTML
        const modalHTML = `
            <div class="delete-modal-overlay">
                <div class="delete-modal">
                    <div class="delete-modal-header">
                        <div class="delete-modal-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="delete-modal-title">${title}</h3>
                        <button class="delete-modal-close" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="delete-modal-body">
                        <div class="delete-modal-warning">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <div class="delete-modal-message">${message}</div>
                        <div class="delete-modal-submessage">${submessage}</div>
                        ${itemName ? `
                            <div class="delete-modal-item-info">
                                <div class="delete-modal-item-name">${itemName}</div>
                                ${itemDetails ? `<div class="delete-modal-item-details">${itemDetails}</div>` : ''}
                            </div>
                        ` : ''}
                    </div>
                    <div class="delete-modal-actions">
                        <button class="delete-modal-btn delete-modal-btn-cancel" type="button">
                            <i class="fas fa-times"></i>
                            <span>${cancelText}</span>
                        </button>
                        <button class="delete-modal-btn delete-modal-btn-confirm" type="button">
                            <i class="fas fa-trash-alt"></i>
                            <span>${confirmText}</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add modal to DOM
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.currentModal = document.querySelector('.delete-modal-overlay:last-child');

        // Add event listeners
        const closeBtn = this.currentModal.querySelector('.delete-modal-close');
        const cancelBtn = this.currentModal.querySelector('.delete-modal-btn-cancel');
        const confirmBtn = this.currentModal.querySelector('.delete-modal-btn-confirm');

        closeBtn.addEventListener('click', () => {
            onCancel();
            this.close();
        });

        cancelBtn.addEventListener('click', () => {
            onCancel();
            this.close();
        });

        confirmBtn.addEventListener('click', () => {
            this.setLoading(confirmBtn, true);
            onConfirm(() => this.close());
        });

        // Show modal with animation
        requestAnimationFrame(() => {
            this.currentModal.classList.add('show');
        });

        // Focus on confirm button for keyboard navigation
        setTimeout(() => {
            confirmBtn.focus();
        }, 100);

        return this.currentModal;
    }

    setLoading(button, isLoading) {
        if (isLoading) {
            button.classList.add('delete-modal-btn-loading');
            const icon = button.querySelector('i');
            icon.className = 'delete-modal-spinner';
        } else {
            button.classList.remove('delete-modal-btn-loading');
            const icon = button.querySelector('i');
            icon.className = 'fas fa-trash-alt';
        }
    }

    close() {
        if (!this.currentModal) return;

        this.currentModal.classList.add('removing');
        
        setTimeout(() => {
            if (this.currentModal && this.currentModal.parentNode) {
                this.currentModal.parentNode.removeChild(this.currentModal);
            }
            this.currentModal = null;
        }, 300);
    }

    // Static method for easy use
    static confirm(options) {
        const instance = new DeleteConfirmation();
        return instance.show(options);
    }
}

// Global delete confirmation function
window.showDeleteConfirmation = (options) => {
    return DeleteConfirmation.confirm(options);
};

// Enhanced success notification
window.showDeleteSuccess = (message = 'Öğe başarıyla silindi!') => {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 30px;
        right: 30px;
        background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 184, 148, 0.3);
        z-index: 10001;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInRight 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        min-width: 300px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    `;

    notification.innerHTML = `
        <div style="
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        ">
            <i class="fas fa-check" style="font-size: 12px;"></i>
        </div>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 4px;
            margin-left: auto;
            border-radius: 4px;
            transition: all 0.2s ease;
        ">
            <i class="fas fa-times"></i>
        </button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 4 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 400);
        }
    }, 4000);
};

// Enhanced error notification
window.showDeleteError = (message = 'Silme işlemi sırasında bir hata oluştu!') => {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 30px;
        right: 30px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(231, 76, 60, 0.3);
        z-index: 10001;
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInRight 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        min-width: 300px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    `;

    notification.innerHTML = `
        <div style="
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        ">
            <i class="fas fa-exclamation-triangle" style="font-size: 12px;"></i>
        </div>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 4px;
            margin-left: auto;
            border-radius: 4px;
            transition: all 0.2s ease;
        ">
            <i class="fas fa-times"></i>
        </button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds (longer for errors)
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 400);
        }
    }, 5000);
};

// Add required CSS animations
const animationStyles = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

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
`;

const animationStyleSheet = document.createElement('style');
animationStyleSheet.textContent = animationStyles;
document.head.appendChild(animationStyleSheet);

console.log('✅ Delete Confirmation System loaded successfully');