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
Route::resource('items', ItemController::class);

// **Pemesanan Ruangan** (CRUD)
Route::resource('rooms', RoomController::class);

// **Room Booking** (CRUD untuk pemesanan ruangan)
Route::resource('room_bookings', RoomBookingController::class);

// **Item Borrowing** (CRUD untuk peminjaman barang)
Route::resource('item_borrowings', ItemBorrowingController::class);
