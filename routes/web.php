<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/donate', [FrontendController::class, 'donate'])->name('donate');
Route::get('/book-lesson', [FrontendController::class, 'bookLesson'])->name('book.lesson');
Route::get('/contact', [FrontendController::class, 'contactUs'])->name('contact');
Route::get('/safeguarding-policy', [FrontendController::class, 'safeguard'])->name('safeguard');
// privacy policy
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy.policy');
// refund policy
Route::get('/refund-policy', [FrontendController::class, 'refundPolicy'])->name('refund.policy');
// terms and conditions
Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndCondition'])->name('terms.and.conditions');
// news
Route::get('/news', [FrontendController::class, 'news'])->name('news');
// news details
Route::get('/news/{slug}', [FrontendController::class, 'newsDetails'])->name('news.details');

Route::get('/cookie-policy', [FrontendController::class, 'cookiePolicy'])->name('cookie.policy');



// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    });
});



require __DIR__.'/auth.php';
