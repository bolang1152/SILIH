<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\ItemBorrowingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UserController;

// **Middleware Alias untuk Admin**
Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

// **Beranda** - Halaman utama aplikasi (Dashboard SILIH)
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// **Autentikasi** (Login, Register, Logout)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// **Forgot Password & Reset Password**
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// **Email Verification** (Jika diperlukan)
Route::middleware('auth')->group(function () {
    // Menampilkan halaman verifikasi email
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');

    // Rute untuk melakukan verifikasi email
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

    // Rute untuk mengirim ulang email verifikasi
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});


// **Profil Pengguna** - Menampilkan profil pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

// **Peminjaman Barang** (CRUD)
// Admin: bisa create, edit, delete | User: hanya bisa lihat dan create
Route::resource('items', ItemController::class)->except(['destroy']);
Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy')
    ->middleware(['auth', 'admin']);

// **Pemesanan Ruangan** (CRUD)
// Admin: bisa create, edit, delete | User: hanya bisa lihat dan create
Route::resource('rooms', RoomController::class)->except(['destroy']);
Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy')
    ->middleware(['auth', 'admin']);

// **Room Booking** (CRUD)
// Admin: bisa approve/reject, lihat semua | User: hanya bisa create, lihat miliknya
Route::resource('room_bookings', RoomBookingController::class);

// **Item Borrowing** (CRUD)
// Admin: bisa approve/reject, lihat semua | User: hanya bisa create, lihat miliknya
Route::resource('item_borrowings', ItemBorrowingController::class);

// **Admin Routes** - Hanya untuk admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'adminDashboard'])->name('dashboard');
    
    // Kelola Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    
    // Approve Room Bookings
    Route::post('room_bookings/{booking}/approve', [RoomBookingController::class, 'approve'])->name('room_bookings.approve');
    Route::post('room_bookings/{booking}/reject', [RoomBookingController::class, 'reject'])->name('room_bookings.reject');
    
    // Approve Item Borrowings
    Route::post('item_borrowings/{borrowing}/approve', [ItemBorrowingController::class, 'approve'])->name('item_borrowings.approve');
    Route::post('item_borrowings/{borrowing}/reject', [ItemBorrowingController::class, 'reject'])->name('item_borrowings.reject');
    
    // Return Items
    Route::post('item_borrowings/{borrowing}/return', [ItemBorrowingController::class, 'returnItem'])->name('item_borrowings.return');
});

// **User Dashboard** - Untuk user biasa (non-admin)
Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'userDashboard'])->name('dashboard');
});

