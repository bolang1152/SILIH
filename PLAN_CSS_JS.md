# Rencana Implementasi CSS dan JS Terpisah untuk SILIH

## 📁 Struktur File yang akan dibuat:

### CSS Files (di `resources/css/`)
```
resources/css/
├── app.css              (file utama - sudah ada)
├── custom.css           (CSS kustom utama)
├── components.css       (CSS untuk komponen reusable)
├── pages.css            (CSS untuk halaman spesifik)
└── plugins.css          (CSS untuk plugin eksternal)
```

### JS Files (di `resources/js/`)
```
resources/js/
├── app.js               (file utama - sudah ada)
├── custom.js            (JS kustom utama)
├── components.js        (Vue components)
├── pages.js             (JS untuk halaman spesifik)
└── utils.js             (Utility functions)
```

## 🔧 Langkah Implementasi:

### 1. Update `vite.config.js`
- Tambahkan input file CSS dan JS kustom

### 2. Update `resources/views/layouts/app.blade.php`
- Load file CSS dan JS kustom

### 3. Buat File CSS Baru
- `resources/css/custom.css`
- `resources/css/components.css`
- `resources/css/pages.css`

### 4. Buat File JS Baru
- `resources/js/custom.js`
- `resources/js/components.js`
- `resources/js/pages.js`
- `resources/js/utils.js`

### 5. Build & Test
- Jalankan `npm run dev` atau `npm run build`

## ✅ Keuntungan:
- Modular dan mudah maintenance
- Setiap halaman bisa load CSS/JS yang diperlukan saja
- Tim bisa bekerja pada file berbeda tanpa konflik
- Loading lebih optimal dengan code splitting

