/**
 * Custom JavaScript for SILIH Application
 * 
 * File ini berisi kustomisasi JS utama untuk aplikasi SILIH.
 */

// ============================================
// DOM READY
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initCommon();
    initAlerts();
    initTooltips();
    initDropdowns();
    initModals();
    initForms();
    initTables();
});

// ============================================
// COMMON FUNCTIONS
// ============================================

function initCommon() {
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('.alert, .alert-silih, [class*="flash-message"]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            fadeOut(message);
        }, 5000);
    });

    // Active nav link
    setActiveNavLink();

    // Check for sidebar
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        initSidebar();
    }

    // Initialize lazy loading for images
    initLazyLoading();
}

function fadeOut(element) {
    if (!element) return;
    element.style.opacity = '1';
    element.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        element.style.opacity = '0';
        setTimeout(() => {
            if (element.parentNode) {
                element.parentNode.removeChild(element);
            }
        }, 500);
    }, 500);
}

function setActiveNavLink() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link, .sidebar-item');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath === href) {
            link.classList.add('active');
        } else if (href && currentPath.startsWith(href) && href !== '/') {
            link.classList.add('active');
        }
    });
}

function initSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('sidebar-collapsed'));
        });
    }
    
    // Restore sidebar state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        sidebar.classList.add('sidebar-collapsed');
    }
}

function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }
}

// ============================================
// ALERT FUNCTIONS
// ============================================

function initAlerts() {
    const alerts = document.querySelectorAll('.alert-dismissible, .alert-close, [data-dismiss="alert"]');
    alerts.forEach(alert => {
        alert.addEventListener('click', function() {
            fadeOut(this.closest('.alert'));
        });
    });
}

function showAlert(type, message, title = '') {
    const icons = {
        success: '<svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        error: '<svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
        warning: '<svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        info: '<svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    };
    
    const alertHtml = `
        <div class="alert-silih alert-silih-${type} animate-slide-up" role="alert">
            ${icons[type]}
            <div class="alert-content">
                ${title ? `<div class="alert-title">${title}</div>` : ''}
                <div>${message}</div>
            </div>
            <button type="button" class="alert-dismissible" data-dismiss="alert" aria-label="Close">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    // Insert alert
    const container = document.querySelector('.alert-container') || document.body;
    const alertDiv = document.createElement('div');
    alertDiv.innerHTML = alertHtml;
    container.insertBefore(alertDiv.firstElementChild, container.firstChild);
    
    // Add close event
    alertDiv.querySelector('.alert-dismissible').addEventListener('click', function() {
        fadeOut(this.closest('.alert-silih'));
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert-silih');
        if (alert) fadeOut(alert);
    }, 5000);
}

// ============================================
// TOOLTIP FUNCTIONS
// ============================================

function initTooltips() {
    const tooltips = document.querySelectorAll('[data-toggle="tooltip"], [title]');
    
    tooltips.forEach(tooltip => {
        // Skip if already initialized
        if (tooltip.classList.contains('tooltip-initialized')) return;
        
        const title = tooltip.getAttribute('data-title') || tooltip.getAttribute('title');
        if (!title) return;
        
        tooltip.classList.add('tooltip-initialized');
        tooltip.removeAttribute('title');
        
        const tooltipEl = document.createElement('span');
        tooltipEl.className = 'tooltip-text-silih';
        tooltipEl.textContent = title;
        tooltip.appendChild(tooltipEl);
        
        tooltip.addEventListener('mouseenter', function() {
            this.classList.add('tooltip-show');
        });
        
        tooltip.addEventListener('mouseleave', function() {
            this.classList.remove('tooltip-show');
        });
    });
}

function showTooltip(element, message) {
    let tooltip = element.querySelector('.tooltip-text-silih');
    if (!tooltip) {
        tooltip = document.createElement('span');
        tooltip.className = 'tooltip-text-silih';
        element.appendChild(tooltip);
    }
    tooltip.textContent = message;
    element.classList.add('tooltip-show');
}

function hideTooltip(element) {
    element.classList.remove('tooltip-show');
}

// ============================================
// DROPDOWN FUNCTIONS
// ============================================

function initDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown, .dropdown-silih');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle, .dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu, .dropdown-menu-silih');
        
        if (!toggle || !menu) return;
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close other dropdowns
            dropdowns.forEach(d => {
                if (d !== dropdown) {
                    d.classList.remove('show');
                }
            });
            
            dropdown.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown, .dropdown-silih')) {
            dropdowns.forEach(d => d.classList.remove('show'));
        }
    });
    
    // Close dropdowns on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            dropdowns.forEach(d => d.classList.remove('show'));
        }
    });
}

// ============================================
// MODAL FUNCTIONS
// ============================================

function initModals() {
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"], [data-target]');
    
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target') || this.getAttribute('href');
            if (targetId) {
                openModal(targetId.replace('#', ''));
            }
        });
    });
    
    const closeButtons = document.querySelectorAll('.modal-close, .modal-close-silih, [data-dismiss="modal"]');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal, .modal-silih');
            if (modal) {
                closeModal(modal);
            }
        });
    });
    
    // Close on backdrop click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop', 'modal-backdrop-silih')) {
            const modal = e.target.closest('.modal, .modal-silih');
            if (modal) {
                closeModal(modal);
            }
        }
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    
    const backdrop = modal.querySelector('.modal-backdrop, .modal-backdrop-silih') || createModalBackdrop();
    const content = modal.querySelector('.modal-content, .modal-content-silih');
    
    if (backdrop) {
        document.body.appendChild(backdrop);
        document.body.classList.add('modal-open');
        setTimeout(() => backdrop.classList.add('show'), 10);
    }
    
    if (content) {
        setTimeout(() => modal.classList.add('show'), 10);
    }
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
    
    // Focus trap
    focusTrap(modal);
}

function closeModal(modal) {
    if (!modal) return;
    
    const backdrop = modal.querySelector('.modal-backdrop, .modal-backdrop-silih');
    
    modal.classList.remove('show');
    
    setTimeout(() => {
        if (backdrop && backdrop.parentNode) {
            backdrop.parentNode.removeChild(backdrop);
        }
        if (!document.querySelector('.modal.show, .modal-silih.show')) {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
        }
    }, 200);
}

function createModalBackdrop() {
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop-silih';
    return backdrop;
}

function focusTrap(modal) {
    const focusableElements = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    if (focusableElements.length === 0) return;
    
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    
    modal.addEventListener('keydown', function(e) {
        if (e.key !== 'Tab') return;
        
        if (e.shiftKey) {
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    });
}

// ============================================
// FORM FUNCTIONS
// ============================================

function initForms() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea[data-auto-resize]');
    textareas.forEach(textarea => {
        autoResize(textarea);
        textarea.addEventListener('input', () => autoResize(textarea));
    });
    
    // Character count
    const charCounters = document.querySelectorAll('[data-maxlength]');
    charCounters.forEach(counter => {
        updateCharCount(counter);
        counter.addEventListener('input', () => updateCharCount(counter));
    });
    
    // Form validation
    const forms = document.querySelectorAll('form[data-validation]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

function updateCharCount(element) {
    const maxLength = parseInt(element.getAttribute('data-maxlength'));
    const currentLength = element.value.length;
    const counter = document.querySelector(`[data-char-counter="${element.id}"]`);
    
    if (counter) {
        counter.textContent = `${currentLength}/${maxLength}`;
        if (currentLength > maxLength) {
            counter.classList.add('text-danger');
        } else {
            counter.classList.remove('text-danger');
        }
    }
}

function validateForm(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    let isValid = true;
    
    inputs.forEach(input => {
        const validation = input.getAttribute('data-validation');
        if (!validation) return;
        
        const rules = validation.split('|');
        const error = validateField(input, rules);
        
        if (error) {
            isValid = false;
            showFieldError(input, error);
        } else {
            hideFieldError(input);
        }
    });
    
    return isValid;
}

function validateField(input, rules) {
    const value = input.value.trim();
    
    for (const rule of rules) {
        const [ruleName, param] = rule.split(':');
        
        switch(ruleName) {
            case 'required':
                if (!value) return 'Field ini wajib diisi';
                break;
            case 'email':
                if (value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    return 'Format email tidak valid';
                }
                break;
            case 'min':
                if (value.length < parseInt(param)) {
                    return `Minimal ${param} karakter`;
                }
                break;
            case 'max':
                if (value.length > parseInt(param)) {
                    return `Maksimal ${param} karakter`;
                }
                break;
            case 'numeric':
                if (value && isNaN(value)) {
                    return 'Harus berupa angka';
                }
                break;
            case 'phone':
                if (value && !/^[0-9+\-\s]{10,}$/.test(value)) {
                    return 'Nomor telepon tidak valid';
                }
                break;
        }
    }
    
    return null;
}

function showFieldError(input, message) {
    let errorEl = input.parentNode.querySelector('.field-error, .error-message, label.error');
    
    if (!errorEl) {
        errorEl = document.createElement('div');
        errorEl.className = 'field-error text-danger mt-1';
        input.parentNode.appendChild(errorEl);
    }
    
    errorEl.textContent = message;
    input.classList.add('is-invalid');
}

function hideFieldError(input) {
    const errorEl = input.parentNode.querySelector('.field-error, .error-message, label.error');
    if (errorEl) {
        errorEl.remove();
    }
    input.classList.remove('is-invalid');
}

// ============================================
// TABLE FUNCTIONS
// ============================================

function initTables() {
    // Add row actions
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.classList.add('row-hover');
        });
        row.addEventListener('mouseleave', function() {
            this.classList.remove('row-hover');
        });
    });
}

function addTableActions(tableId, actions) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    if (!tbody) return;
    
    tbody.querySelectorAll('tr').forEach((row, index) => {
        const actionsCell = row.querySelector('.actions-cell') || createActionsCell(row);
        
        actions.forEach(action => {
            const btn = document.createElement('button');
            btn.className = `btn btn-sm btn-${action.type || 'secondary'}`;
            btn.innerHTML = action.icon || action.text;
            btn.title = action.title || action.text;
            
            if (action.onclick) {
                btn.addEventListener('click', () => action.onclick(row, index));
            }
            
            if (action.href) {
                btn.setAttribute('href', action.href);
            }
            
            actionsCell.appendChild(btn);
        });
    });
}

function createActionsCell(row) {
    const cell = document.createElement('td');
    cell.className = 'actions-cell';
    row.appendChild(cell);
    return cell;
}

// ============================================
// AJAX HELPERS
// ============================================

const SilihAjax = {
    baseUrl: '',
    
    setBaseUrl: function(url) {
        this.baseUrl = url;
    },
    
    get: function(url, data = {}) {
        const queryString = Object.keys(data).length 
            ? '?' + new URLSearchParams(data).toString() 
            : '';
        
        return fetch(this.baseUrl + url + queryString, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(this.handleResponse);
    },
    
    post: function(url, data = {}) {
        return fetch(this.baseUrl + url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        }).then(this.handleResponse);
    },
    
    put: function(url, data = {}) {
        return fetch(this.baseUrl + url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        }).then(this.handleResponse);
    },
    
    delete: function(url) {
        return fetch(this.baseUrl + url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(this.handleResponse);
    },
    
    handleResponse: function(response) {
        if (!response.ok) {
            throw response;
        }
        return response.json();
    }
};

// Export ke global window
window.SilihAjax = SilihAjax;
window.showAlert = showAlert;
window.showTooltip = showTooltip;
window.hideTooltip = hideTooltip;
window.openModal = openModal;
window.closeModal = closeModal;
window.validateForm = validateForm;
window.addTableActions = addTableActions;

