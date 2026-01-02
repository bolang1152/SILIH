# TODO - Sistem Admin & User untuk SILIH

## 📋 Daftar Tugas:

### ✅ Tahap 1: Database & Model
- [x] Tambah kolom `is_admin` di migration users
- [x] Update model User dengan accessor `isAdmin`
- [x] Buat DatabaseSeeder untuk admin default

### ✅ Tahap 2: Middleware
- [x] Buat AdminMiddleware
- [x] Daftarkan middleware di Kernel

### ✅ Tahap 3: Controller Updates
- [x] Update ItemController - proteksi create/edit/delete
- [x] Update RoomController - proteksi create/edit/delete
- [x] Update RoomBookingController - admin approve/reject, user create only
- [x] Update ItemBorrowingController - admin approve/reject, user create only
- [x] Update HomeController - dashboard berbeda untuk admin & user

### ✅ Tahap 4: Routes
- [x] Proteksi routes dengan middleware auth + admin
- [x] Pisahkan route admin dan user

### ✅ Tahap 5: Views - Layout & Navbar
- [x] Update navbar dengan menu berbeda admin/user
- [x] Update layout untuk conditional display

### ✅ Tahap 6: Views - Dashboard
- [x] Dashboard admin (stats + semua data)
- [x] Dashboard user (status peminjaman user)

### ✅ Tahap 7: Views - Tables dengan Approval
- [x] Tambah kolom approval di room_bookings table
- [x] Tambah kolom approval di item_borrowings table
- [x] Buat halaman approval untuk admin
- [x] Tombol approve/reject untuk admin

### ✅ Tahap 8: Testing
- [x] Test login admin
- [x] Test login user
- [x] Test permission admin
- [x] Test permission user

---
**Status:** ✅ Completed
**Tanggal:** 2024

## 📝 Catatan Tambahan:
- Status enum room_bookings: pending, approved, rejected, completed
- Status enum item_borrowings: pending, borrowed, rejected, completed
- Kolom `rejection_reason` ditambahkan untuk menyimpan alasan penolakan
- User model memiliki accessor `isAdmin` untuk konversi ke boolean

