/**
 * Vue Components for SILIH Application
 * 
 * File ini berisi komponen-komponen Vue.js yang dapat digunakan di aplikasi SILIH.
 */

// ============================================
// CONFIRMATION MODAL COMPONENT
// ============================================

const ConfirmModal = {
    props: {
        id: { type: String, required: true },
        title: { type: String, default: 'Konfirmasi' },
        message: { type: String, required: true },
        confirmText: { type: String, default: 'Ya' },
        cancelText: { type: String, default: 'Batal' },
        confirmClass: { type: String, default: 'btn-primary' },
        type: { type: String, default: 'danger' } // danger, warning, info, success
    },
    template: `
        <div :id="id" class="modal-silih" tabindex="-1" :class="{ 'show': show }">
            <div class="modal-backdrop-silih" :class="{ 'show': show }" @click="close"></div>
            <div class="modal-content-silih" role="dialog" aria-labelledby="${id}-title">
                <div class="modal-header-silih">
                    <h5 class="modal-title-silih" :id="${id}-title">{{ title }}</h5>
                    <button type="button" class="modal-close-silih" @click="close" aria-label="Close">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body-silih">
                    <div class="d-flex align-items-start gap-3">
                        <svg v-if="type === 'danger'" class="text-danger" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <svg v-else-if="type === 'warning'" class="text-warning" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <svg v-else class="text-primary" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>{{ message }}</div>
                    </div>
                </div>
                <div class="modal-footer-silih">
                    <button type="button" class="btn btn-secondary" @click="close">{{ cancelText }}</button>
                    <button type="button" class="btn" :class="confirmClass" @click="confirm">{{ confirmText }}</button>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            show: false,
            resolve: null,
            reject: null
        };
    },
    methods: {
        open() {
            this.show = true;
            document.body.style.overflow = 'hidden';
            return new Promise((resolve, reject) => {
                this.resolve = resolve;
                this.reject = reject;
            });
        },
        close() {
            this.show = false;
            document.body.style.overflow = '';
            if (this.reject) {
                this.reject(false);
            }
        },
        confirm() {
            this.show = false;
            document.body.style.overflow = '';
            if (this.resolve) {
                this.resolve(true);
            }
        }
    },
    mounted() {
        // Listen for custom open event
        this.$el.addEventListener('open-confirm-modal', () => this.open());
    }
};

// ============================================
// DATA TABLE COMPONENT
// ============================================

const DataTable = {
    props: {
        id: { type: String, required: true },
        headers: { type: Array, required: true },
        data: { type: Array, default: () => [] },
        actions: { type: Array, default: () => [] },
        searchable: { type: Boolean, default: true },
        sortable: { type: Boolean, default: true },
        pageLength: { type: Number, default: 10 },
        responsive: { type: Boolean, default: true }
    },
    template: `
        <div class="data-table-wrapper">
            <div class="d-flex justify-between align-center mb-3" v-if="searchable">
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search" @input="filterData">
                </div>
                <div class="table-actions" v-if="$slots.actions">
                    <slot name="actions"></slot>
                </div>
            </div>
            <div class="table-responsive" v-if="responsive">
                <table :id="id" class="table-silih">
                    <thead>
                        <tr>
                            <th v-for="header in headers" :key="header.key" 
                                :class="{ 'sortable': sortable && header.sortable !== false }"
                                @click="sort(header.key)">
                                {{ header.label }}
                                <span v-if="sortKey === header.key" class="sort-icon">
                                    {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                </span>
                            </th>
                            <th v-if="actions.length > 0" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in paginatedData" :key="index">
                            <td v-for="header in headers" :key="header.key">
                                <slot :name="'cell-' + header.key" :row="row" :value="row[header.key]">
                                    {{ row[header.key] }}
                                </slot>
                            </td>
                            <td v-if="actions.length > 0" class="actions-cell text-center">
                                <button v-for="action in actions" :key="action.text"
                                    class="btn btn-sm" 
                                    :class="'btn-' + (action.class || 'secondary')"
                                    @click="handleAction(action, row, index)"
                                    :title="action.text">
                                    <span v-if="action.icon" v-html="action.icon"></span>
                                    <span v-else>{{ action.text }}</span>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="filteredData.length === 0">
                            <td :colspan="headers.length + (actions.length > 0 ? 1 : 0)" class="text-center py-4">
                                <div class="empty-state">
                                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <div class="empty-state-title">Tidak ada data</div>
                                    <div class="empty-state-description">Data yang Anda cari tidak ditemukan.</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper d-flex justify-between align-center mt-3" v-if="filteredData.length > 0">
                <div class="pagination-info">
                    Menampilkan {{ (currentPage - 1) * pageLength + 1 }} - {{ Math.min(currentPage * pageLength, filteredData.length) }} dari {{ filteredData.length }} data
                </div>
                <ul class="pagination-silih">
                    <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                        <a class="page-link" href="#" @click.prevent="prevPage">←</a>
                    </li>
                    <li class="page-item" v-for="page in visiblePages" :key="page" 
                        :class="{ 'active': currentPage === page }">
                        <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                        <a class="page-link" href="#" @click.prevent="nextPage">→</a>
                    </li>
                </ul>
            </div>
        </div>
    `,
    data() {
        return {
            search: '',
            sortKey: '',
            sortOrder: 'asc',
            currentPage: 1,
            pageLength: this.pageLength
        };
    },
    computed: {
        filteredData() {
            let data = [...this.data];
            
            // Search
            if (this.search) {
                const searchLower = this.search.toLowerCase();
                data = data.filter(row => {
                    return Object.values(row).some(val => 
                        String(val).toLowerCase().includes(searchLower)
                    );
                });
            }
            
            // Sort
            if (this.sortKey) {
                data.sort((a, b) => {
                    const aVal = a[this.sortKey];
                    const bVal = b[this.sortKey];
                    
                    if (aVal < bVal) return this.sortOrder === 'asc' ? -1 : 1;
                    if (aVal > bVal) return this.sortOrder === 'asc' ? 1 : -1;
                    return 0;
                });
            }
            
            return data;
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.pageLength;
            return this.filteredData.slice(start, start + this.pageLength);
        },
        totalPages() {
            return Math.ceil(this.filteredData.length / this.pageLength);
        },
        visiblePages() {
            const pages = [];
            const total = this.totalPages;
            const current = this.currentPage;
            
            let start = Math.max(1, current - 2);
            let end = Math.min(total, current + 2);
            
            if (end - start < 4) {
                if (start === 1) {
                    end = Math.min(5, total);
                } else {
                    start = Math.max(1, total - 4);
                }
            }
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            
            return pages;
        }
    },
    methods: {
        sort(key) {
            if (!this.sortable) return;
            
            if (this.sortKey === key) {
                this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortOrder = 'asc';
            }
        },
        filterData() {
            this.currentPage = 1;
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        handleAction(action, row, index) {
            if (action.handler) {
                action.handler(row, index);
            }
        }
    }
};

// ============================================
// STATUS BADGE COMPONENT
// ============================================

const StatusBadge = {
    props: {
        status: { type: [String, Number], required: true },
        mapping: { type: Object, default: () => ({
            'active': { label: 'Aktif', class: 'success' },
            'inactive': { label: 'Tidak Aktif', class: 'secondary' },
            'pending': { label: 'Menunggu', class: 'warning' },
            'approved': { label: 'Disetujui', class: 'success' },
            'rejected': { label: 'Ditolak', class: 'danger' },
            'completed': { label: 'Selesai', class: 'success' },
            'cancelled': { label: 'Dibatalkan', class: 'danger' }
        })},
        defaultClass: { type: String, default: 'secondary' }
    },
    template: `
        <span class="badge-silih" :class="'badge-silih-' + badgeClass">
            {{ label }}
        </span>
    `,
    computed() {
        const config = this.mapping[this.status] || { label: this.status, class: this.defaultClass };
        return {
            label: config.label || this.status,
            badgeClass: config.class || this.defaultClass
        };
    }
};

// ============================================
// LOADER COMPONENT
// ============================================

const Loader = {
    props: {
        size: { type: String, default: 'md' }, // sm, md, lg
        text: { type: String, default: '' },
        overlay: { type: Boolean, default: false }
    },
    template: `
        <div :class="{ 'loader-overlay': overlay }" v-if="show">
            <div class="text-center">
                <div class="loader-silih" :class="'loader-silih-' + size"></div>
                <div v-if="text" class="loader-text">{{ text }}</div>
            </div>
        </div>
    `,
    data() {
        return {
            show: true
        };
    },
    methods: {
        hide() {
            this.show = false;
        },
        show() {
            this.show = true;
        }
    }
};

// ============================================
// TOAST COMPONENT
// ============================================

const ToastContainer = {
    props: {
        position: { type: String, default: 'top-right' } // top-right, top-left, bottom-right, bottom-left
    },
    template: `
        <div class="toast-container" :class="'toast-' + position">
            <div v-for="toast in toasts" :key="toast.id" class="toast" :class="'toast-' + toast.type" :class="{ 'show': toast.visible }">
                <div class="toast-icon" v-html="getIcon(toast.type)"></div>
                <div class="toast-content">
                    <div v-if="toast.title" class="toast-title">{{ toast.title }}</div>
                    <div class="toast-message">{{ toast.message }}</div>
                </div>
                <button class="toast-close" @click="removeToast(toast.id)">×</button>
            </div>
        </div>
    `,
    data() {
        return {
            toasts: []
        };
    },
    methods: {
        add(type, message, title = '', duration = 5000) {
            const id = Date.now();
            const toast = { id, type, message, title, visible: false };
            this.toasts.push(toast);
            
            setTimeout(() => {
                toast.visible = true;
            }, 10);
            
            setTimeout(() => {
                this.removeToast(id);
            }, duration);
            
            return id;
        },
        success(message, title = '') {
            return this.add('success', message, title);
        },
        error(message, title = '') {
            return this.add('error', message, title);
        },
        warning(message, title = '') {
            return this.add('warning', message, title);
        },
        info(message, title = '') {
            return this.add('info', message, title);
        },
        removeToast(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) {
                this.toasts[index].visible = false;
                setTimeout(() => {
                    this.toasts.splice(index, 1);
                }, 300);
            }
        },
        getIcon(type) {
            const icons = {
                success: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
                error: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
                warning: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                info: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            };
            return icons[type] || icons.info;
        }
    }
};

// ============================================
// FORM INPUT COMPONENT
// ============================================

const FormInput = {
    props: {
        id: { type: String, default: '' },
        name: { type: String, required: true },
        label: { type: String, default: '' },
        type: { type: String, default: 'text' },
        value: { type: [String, Number], default: '' },
        placeholder: { type: String, default: '' },
        required: { type: Boolean, default: false },
        disabled: { type: Boolean, default: false },
        readonly: { type: Boolean, default: false },
        error: { type: String, default: '' },
        help: { type: String, default: '' }
    },
    template: `
        <div class="form-group-silih">
            <label v-if="label" :for="id || name" class="form-label-silih">
                {{ label }}
                <span v-if="required" class="required">*</span>
            </label>
            <input :id="id || name" :type="type" :name="name" :value="value" 
                class="form-control-silih" :class="{ 'is-invalid': error }"
                :placeholder="placeholder" :required="required" :disabled="disabled" :readonly="readonly"
                @input="$emit('input', $event.target.value)"
                @blur="$emit('blur', $event)"
                @focus="$emit('focus', $event)">
            <div v-if="error" class="form-text-silih error">{{ error }}</div>
            <div v-else-if="help" class="form-text-silih">{{ help }}</div>
        </div>
    `,
    model: {
        prop: 'value',
        event: 'input'
    }
};

// ============================================
// REGISTER COMPONENTS GLOBALLY
// ============================================

// Create a global toast instance
window.ToastInstance = {
    success: (message, title) => showAlert('success', message, title),
    error: (message, title) => showAlert('error', message, title),
    warning: (message, title) => showAlert('warning', message, title),
    info: (message, title) => showAlert('info', message, title)
};

