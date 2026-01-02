/**
 * Utility Functions for SILIH Application
 * 
 * File ini berisi fungsi-fungsi utility yang dapat digunakan di seluruh aplikasi.
 */

const SilihUtils = {
    /**
     * Format tanggal ke format Indonesia
     * @param {Date|string} date - Tanggal yang akan diformat
     * @param {string} format - Format output (short, medium, long, full)
     * @returns {string} Tanggal yang sudah diformat
     */
    formatDate: function(date, format = 'medium') {
        if (!date) return '-';
        
        const d = new Date(date);
        const months = {
            short: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            medium: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            long: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
        };
        
        const day = d.getDate();
        const month = months[format][d.getMonth()];
        const year = d.getFullYear();
        
        switch(format) {
            case 'short':
                return `${day}/${d.getMonth() + 1}/${year}`;
            case 'long':
                return `${day} ${month} ${year}`;
            case 'full':
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                return `${days[d.getDay()]}, ${day} ${month} ${year}`;
            case 'medium':
            default:
                return `${day} ${month} ${year}`;
        }
    },

    /**
     * Format waktu ke format Indonesia
     * @param {Date|string} date - Tanggal/waktu yang akan diformat
     * @param {boolean} showSeconds - Apakah ingin menampilkan detik
     * @returns {string} Waktu yang sudah diformat
     */
    formatTime: function(date, showSeconds = false) {
        if (!date) return '-';
        
        const d = new Date(date);
        let hours = d.getHours();
        let minutes = d.getMinutes();
        let seconds = d.getSeconds();
        
        // Format 24 jam
        const formattedHours = hours.toString().padStart(2, '0');
        const formattedMinutes = minutes.toString().padStart(2, '0');
        const formattedSeconds = seconds.toString().padStart(2, '0');
        
        if (showSeconds) {
            return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
        }
        return `${formattedHours}:${formattedMinutes}`;
    },

    /**
     * Format tanggal dan waktu lengkap
     * @param {Date|string} date - Tanggal/waktu
     * @returns {string} Tanggal dan waktu yang sudah diformat
     */
    formatDateTime: function(date) {
        if (!date) return '-';
        return `${this.formatDate(date, 'long')} pukul ${this.formatTime(date)}`;
    },

    /**
     * Format angka ke format Indonesia
     * @param {number} number - Angka yang akan diformat
     * @returns {string} Angka yang sudah diformat
     */
    formatNumber: function(number) {
        if (number === null || number === undefined) return '0';
        return new Intl.NumberFormat('id-ID').format(number);
    },

    /**
     * Format mata uang ke format Indonesia
     * @param {number} amount - Jumlah uang
     * @param {string} currency - Mata uang (default: IDR)
     * @returns {string} Mata uang yang sudah diformat
     */
    formatCurrency: function(amount, currency = 'IDR') {
        if (amount === null || amount === undefined) return 'Rp 0';
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    },

    /**
     * Potong teks dan tambahkan ellipsis
     * @param {string} text - Teks yang akan dipotong
     * @param {number} maxLength - Panjang maksimum
     * @returns {string} Teks yang sudah dipotong
     */
    truncate: function(text, maxLength = 50) {
        if (!text) return '';
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    },

    /**
     * Capitalize huruf pertama
     * @param {string} text - Teks
     * @returns {string} Teks dengan huruf pertama kapital
     */
    capitalize: function(text) {
        if (!text) return '';
        return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    },

    /**
     * Format slug dari teks
     * @param {string} text - Teks
     * @returns {string} Slug
     */
    slugify: function(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    },

    /**
     * Generate UUID
     * @returns {string} UUID v4
     */
    generateUUID: function() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    },

    /**
     * Debounce function
     * @param {Function} func - Fungsi yang akan di-debounce
     * @param {number} wait - Waktu tunggu dalam ms
     * @returns {Function} Function yang sudah di-debounce
     */
    debounce: function(func, wait = 300) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    /**
     * Throttle function
     * @param {Function} func - Fungsi yang akan di-throttle
     * @param {number} limit - Batas waktu dalam ms
     * @returns {Function} Function yang sudah di-throttle
     */
    throttle: function(func, limit = 300) {
        let inThrottle;
        return function executedFunction(...args) {
            if (!inThrottle) {
                func(...args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    /**
     * Deep clone object
     * @param {Object} obj - Object yang akan di-clone
     * @returns {Object} Clone dari object
     */
    deepClone: function(obj) {
        return JSON.parse(JSON.stringify(obj));
    },

    /**
     * Check if object is empty
     * @param {Object} obj - Object yang akan dicek
     * @returns {boolean} true jika kosong
     */
    isEmpty: function(obj) {
        if (!obj) return true;
        if (Array.isArray(obj)) return obj.length === 0;
        if (typeof obj === 'object') return Object.keys(obj).length === 0;
        return false;
    },

    /**
     * Get random integer between min and max
     * @param {number} min - Nilai minimum
     * @param {number} max - Nilai maksimum
     * @returns {number} Random integer
     */
    randomInt: function(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    },

    /**
     * Sleep/Delay
     * @param {number} ms - Waktu delay dalam ms
     * @returns {Promise} Promise yang resolve setelah delay
     */
    sleep: function(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    },

    /**
     * Parse query string ke object
     * @param {string} queryString - Query string
     * @returns {Object} Object dari query string
     */
    parseQueryString: function(queryString) {
        const params = new URLSearchParams(queryString);
        const result = {};
        for (const [key, value] of params) {
            result[key] = value;
        }
        return result;
    },

    /**
     * Build query string dari object
     * @param {Object} params - Object parameter
     * @returns {string} Query string
     */
    buildQueryString: function(params) {
        return new URLSearchParams(params).toString();
    },

    /**
     * Download file
     * @param {string} url - URL file
     * @param {string} filename - Nama file
     */
    downloadFile: function(url, filename) {
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    },

    /**
     * Copy text ke clipboard
     * @param {string} text - Teks yang akan dicopy
     * @returns {Promise} Promise yang resolve jika berhasil
     */
    copyToClipboard: async function(text) {
        try {
            await navigator.clipboard.writeText(text);
            return true;
        } catch (err) {
            // Fallback untuk browser lama
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            return true;
        }
    },

    /**
     * Get selected text
     * @returns {string} Teks yang diseleksi
     */
    getSelectedText: function() {
        return window.getSelection().toString();
    },

    /**
     * Check if element is in viewport
     * @param {HTMLElement} element - Element
     * @returns {boolean} true jika di viewport
     */
    isInViewport: function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    },

    /**
     * Smooth scroll ke element
     * @param {string|HTMLElement} target - Target element
     * @param {number} offset - Offset dari atas
     */
    scrollTo: function(target, offset = 0) {
        const element = typeof target === 'string' ? document.querySelector(target) : target;
        if (element) {
            const top = element.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    },

    /**
     * Get error message dari berbagai tipe error
     * @param {Error|string} error - Error
     * @returns {string} Pesan error
     */
    getErrorMessage: function(error) {
        if (!error) return 'Terjadi kesalahan';
        if (typeof error === 'string') return error;
        if (error.message) return error.message;
        if (error.response && error.response.data && error.response.data.message) {
            return error.response.data.message;
        }
        return 'Terjadi kesalahan';
    }
};

// Export ke global window
window.SilihUtils = SilihUtils;

