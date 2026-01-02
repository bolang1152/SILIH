/**
 * Page-specific JavaScript for SILIH Application
 * 
 * File ini berisi JavaScript khusus untuk halaman-halaman tertentu.
 * Import halaman spesifik di sini.
 */

// ============================================
// HOME PAGE
// ============================================

function initHomePage() {
    // Dashboard stats animation
    animateStats();
    
    // Initialize charts if Chart.js is available
    initDashboardCharts();
}

function animateStats() {
    const stats = document.querySelectorAll('.stats-value');
    stats.forEach(stat => {
        const target = parseInt(stat.dataset.value || stat.textContent);
        if (!target || isNaN(target)) return;
        
        const duration = 1000;
        const step = target / (duration / 16);
        let current = 0;
        
        const update = () => {
            current += step;
            if (current < target) {
                stat.textContent = Math.floor(current);
                requestAnimationFrame(update);
            } else {
                stat.textContent = target;
            }
        };
        
        // Start animation when in viewport
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                update();
                observer.disconnect();
            }
        });
        
        observer.observe(stat);
    });
}

function initDashboardCharts() {
    const chartCanvas = document.getElementById('dashboardChart');
    if (!chartCanvas || typeof Chart === 'undefined') return;
    
    new Chart(chartCanvas, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Peminjaman',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// ============================================
// ITEMS PAGE
// ============================================

function initItemsPage() {
    // Item form validation
    const itemForm = document.getElementById('itemForm');
    if (itemForm) {
        itemForm.addEventListener('submit', validateItemForm);
    }
    
    // Stock counter
    initStockCounter();
    
    // Category filter
    initCategoryFilter();
}

function validateItemForm(e) {
    const name = document.getElementById('name');
    const category = document.getElementById('category_id');
    const stock = document.getElementById('stock');
    
    let isValid = true;
    
    if (!name.value.trim()) {
        showFieldError(name, 'Nama barang wajib diisi');
        isValid = false;
    }
    
    if (!category.value) {
        showFieldError(category, 'Kategori wajib dipilih');
        isValid = false;
    }
    
    if (stock.value < 0) {
        showFieldError(stock, 'Stok tidak boleh negatif');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }
}

function initStockCounter() {
    const stockInput = document.getElementById('stock');
    const incrementBtn = document.getElementById('stockIncrement');
    const decrementBtn = document.getElementById('stockDecrement');
    
    if (!stockInput || !incrementBtn || !decrementBtn) return;
    
    incrementBtn.addEventListener('click', () => {
        stockInput.value = parseInt(stockInput.value) + 1;
    });
    
    decrementBtn.addEventListener('click', () => {
        const current = parseInt(stockInput.value);
        if (current > 0) {
            stockInput.value = current - 1;
        }
    });
}

function initCategoryFilter() {
    const filterSelect = document.getElementById('categoryFilter');
    const items = document.querySelectorAll('.item-card');
    
    if (!filterSelect || items.length === 0) return;
    
    filterSelect.addEventListener('change', function() {
        const category = this.value;
        
        items.forEach(item => {
            if (!category || item.dataset.category === category) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// ============================================
// ROOMS PAGE
// ============================================

function initRoomsPage() {
    // Room capacity slider
    initCapacitySlider();
    
    // Room availability calendar
    initRoomCalendar();
    
    // Equipment checklist
    initEquipmentChecklist();
}

function initCapacitySlider() {
    const slider = document.getElementById('capacity');
    const display = document.getElementById('capacityDisplay');
    
    if (!slider || !display) return;
    
    slider.addEventListener('input', function() {
        display.textContent = this.value + ' orang';
    });
}

function initRoomCalendar() {
    const calendarEl = document.getElementById('roomCalendar');
    if (!calendarEl || typeof Flatpickr === 'undefined') return;
    
    new Flatpickr(calendarEl, {
        mode: 'range',
        minDate: 'today',
        dateFormat: 'Y-m-d',
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                checkRoomAvailability(selectedDates[0], selectedDates[1]);
            }
        }
    });
}

function checkRoomAvailability(start, end) {
    const roomId = document.getElementById('roomId')?.value;
    if (!roomId) return;
    
    SilihAjax.get('/api/rooms/' + roomId + '/availability', {
        start: start.toISOString(),
        end: end.toISOString()
    }).then(response => {
        const statusEl = document.getElementById('availabilityStatus');
        if (statusEl) {
            if (response.available) {
                statusEl.innerHTML = '<span class="badge-silih badge-silih-success">Tersedia</span>';
            } else {
                statusEl.innerHTML = '<span class="badge-silih badge-silih-danger">Tidak Tersedia</span>';
            }
        }
    });
}

function initEquipmentChecklist() {
    const checkboxes = document.querySelectorAll('.equipment-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const selected = document.querySelectorAll('.equipment-checkbox:checked').length;
            const counter = document.getElementById('selectedEquipment');
            if (counter) {
                counter.textContent = selected + ' peralatan dipilih';
            }
        });
    });
}

// ============================================
// BOOKINGS PAGE
// ============================================

function initBookingsPage() {
    // Booking form
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', validateBookingForm);
    }
    
    // Date picker
    initBookingDatePicker();
    
    // Status filter
    initStatusFilter();
}

function validateBookingForm(e) {
    const room = document.getElementById('room_id');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const purpose = document.getElementById('purpose');
    
    let isValid = true;
    
    if (!room.value) {
        showFieldError(room, 'Ruangan wajib dipilih');
        isValid = false;
    }
    
    if (!startDate.value) {
        showFieldError(startDate, 'Tanggal mulai wajib diisi');
        isValid = false;
    }
    
    if (!endDate.value) {
        showFieldError(endDate, 'Tanggal selesai wajib diisi');
        isValid = false;
    }
    
    if (startDate.value && endDate.value && startDate.value > endDate.value) {
        showFieldError(endDate, 'Tanggal selesai harus lebih besar dari tanggal mulai');
        isValid = false;
    }
    
    if (!purpose.value.trim()) {
        showFieldError(purpose, 'Tujuan peminjaman wajib diisi');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }
}

function initBookingDatePicker() {
    const dateInputs = document.querySelectorAll('.booking-date');
    if (dateInputs.length === 0 || typeof Flatpickr === 'undefined') return;
    
    dateInputs.forEach(input => {
        new Flatpickr(input, {
            minDate: 'today',
            dateFormat: 'Y-m-d'
        });
    });
}

function initStatusFilter() {
    const filterSelect = document.getElementById('statusFilter');
    const bookingRows = document.querySelectorAll('.booking-row');
    
    if (!filterSelect || bookingRows.length === 0) return;
    
    filterSelect.addEventListener('change', function() {
        const status = this.value;
        
        bookingRows.forEach(row => {
            if (!status || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// ============================================
// PROFILE PAGE
// ============================================

function initProfilePage() {
    // Profile form
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', validateProfileForm);
    }
    
    // Avatar preview
    initAvatarPreview();
    
    // Password change
    initPasswordChange();
}

function validateProfileForm(e) {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    
    let isValid = true;
    
    if (!name.value.trim()) {
        showFieldError(name, 'Nama wajib diisi');
        isValid = false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailRegex.test(email.value)) {
        showFieldError(email, 'Email tidak valid');
        isValid = false;
    }
    
    if (phone.value && !/^[0-9+\-\s]{10,}$/.test(phone.value)) {
        showFieldError(phone, 'Nomor telepon tidak valid');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }
}

function initAvatarPreview() {
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    
    if (!avatarInput || !avatarPreview) return;
    
    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}

function initPasswordChange() {
    const passwordForm = document.getElementById('passwordForm');
    if (!passwordForm) return;
    
    passwordForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        let isValid = true;
        
        if (newPassword.length < 8) {
            showFieldError(document.getElementById('new_password'), 'Password minimal 8 karakter');
            isValid = false;
        }
        
        if (newPassword !== confirmPassword) {
            showFieldError(document.getElementById('new_password_confirmation'), 'Password tidak cocok');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
}

// ============================================
// AUTH PAGES (LOGIN, REGISTER)
// ============================================

function initAuthPages() {
    // Toggle password visibility
    initPasswordToggle();
    
    // Form validation
    initAuthForm();
}

function initPasswordToggle() {
    const toggleBtns = document.querySelectorAll('.password-toggle');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            
            // Toggle icon
            this.innerHTML = type === 'password' 
                ? '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>'
                : '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>';
        });
    });
}

function initAuthForm() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            let isValid = true;
            
            if (!email.value.trim()) {
                showFieldError(email, 'Email wajib diisi');
                isValid = false;
            }
            
            if (!password.value) {
                showFieldError(password, 'Password wajib diisi');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            let isValid = true;
            
            if (!name.value.trim()) {
                showFieldError(name, 'Nama wajib diisi');
                isValid = false;
            }
            
            if (!email.value.trim()) {
                showFieldError(email, 'Email wajib diisi');
                isValid = false;
            }
            
            if (password.value.length < 8) {
                showFieldError(password, 'Password minimal 8 karakter');
                isValid = false;
            }
            
            if (password.value !== passwordConfirmation.value) {
                showFieldError(passwordConfirmation, 'Password tidak cocok');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
}

// ============================================
// PAGE INITIALIZATION MAP
// ============================================

const PageInitializer = {
    'home': initHomePage,
    'items.index': initItemsPage,
    'items.create': initItemsPage,
    'items.edit': initItemsPage,
    'rooms.index': initRoomsPage,
    'rooms.create': initRoomsPage,
    'rooms.edit': initRoomsPage,
    'room_bookings.index': initBookingsPage,
    'room_bookings.create': initBookingsPage,
    'item_borrowings.index': initBookingsPage,
    'item_borrowings.create': initBookingsPage,
    'profile': initProfilePage,
    'edit-profile': initProfilePage,
    'auth.login': initAuthPages,
    'auth.register': initAuthPages
};

// Initialize based on current page
document.addEventListener('DOMContentLoaded', function() {
    const bodyClass = document.body.className;
    
    for (const [page, initFn] of Object.entries(PageInitializer)) {
        if (bodyClass.includes(page) || document.body.id === page) {
            if (typeof initFn === 'function') {
                initFn();
            }
        }
    }
});

