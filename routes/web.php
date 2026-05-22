<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ContactMessageController;
use App\Http\Controllers\Frontend\UserLoginController;
use App\Http\Controllers\Backend\CompanyInformationController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BlogsController;
use App\Http\Controllers\Backend\SeoController;
use App\Http\Controllers\Backend\FeesCategoryController;
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
Route::post('/contact', [FrontendController::class, 'contactSubmt'])->name('contact.submit');
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
    Route::post('admin/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard',           [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::get('/company-information', [CompanyInformationController::class, 'index'])->name('admin.company-information.index');
        Route::post('/company-information', [CompanyInformationController::class, 'Update'])->name('admin.company-information.index');
    // Page
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])
        ->name('contact-messages.index');
 
    // AJAX DataTable
    Route::get('/contact-messages/data', [ContactMessageController::class, 'data'])
        ->name('contact-messages.data');
 
    // AJAX Export (CSV / Excel)
    Route::get('/contact-messages/export', [ContactMessageController::class, 'export'])
        ->name('contact-messages.export');
 
    // AJAX Bulk actions
    Route::post('/contact-messages/bulk', [ContactMessageController::class, 'bulk'])
        ->name('contact-messages.bulk');
 
    // AJAX Single message
    Route::get('/contact-messages/{contactMessage}',         [ContactMessageController::class, 'show']);
    Route::patch('/contact-messages/{contactMessage}/status',[ContactMessageController::class, 'updateStatus']);
    Route::delete('/contact-messages/{contactMessage}',      [ContactMessageController::class, 'destroy']);
    Route::post('/settings/admin-profile', [CompanyInformationController::class, 'saveAdminProfile'])->name('settings.admin.save');
    });

});

// 
Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('category-create',         [CategoryController::class, 'create'])->name('admin.category.create');
        Route::get('category-index',         [CategoryController::class, 'index'])->name('admin.category.index');
        Route::post('category-store',         [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('category-edit/{id}',         [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('category-update/{id}',         [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('category-delete/{id}',         [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });
});


// fees category
Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('fees-category-create',         [FeesCategoryController::class, 'create'])->name('admin.fees-category.create');
        Route::get('fees-category-index',         [FeesCategoryController::class, 'index'])->name('admin.fees-category.index');
        Route::post('fees-category-store',         [FeesCategoryController::class, 'store'])->name('admin.fees-category.store');
        Route::get('fees-category-edit/{id}',         [FeesCategoryController::class, 'edit'])->name('admin.fees-category.edit');
        Route::post('fees-category-update/{id}',         [FeesCategoryController::class, 'update'])->name('admin.fees-category.update');
        Route::delete('fees-category-delete/{id}',         [FeesCategoryController::class, 'destroy'])->name('admin.fees-category.destroy');
    });
});



// blogs
Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('blogs-create',         [BlogsController::class, 'create'])->name('admin.blogs.create');
        Route::get('blogs-index',         [BlogsController::class, 'index'])->name('admin.blogs.index');
        Route::post('blogs-store',         [BlogsController::class, 'store'])->name('admin.blogs.store');
        Route::get('blogs-edit/{id}',         [BlogsController::class, 'edit'])->name('admin.blogs.edit');
        Route::post('blogs-update/{id}',         [BlogsController::class, 'update'])->name('admin.blogs.update');
        Route::delete('blogs-delete/{id}',         [BlogsController::class, 'destroy'])->name('admin.blogs.destroy');
    }); 
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('seo-update',         [SeoController::class, 'index'])->name('admin.seo.update');
        Route::post('seo-update',         [SeoController::class, 'updateSeo'])->name('admin.settings.seo.update');
   
    }); 
});


Route::post('/ajax-login', [UserLoginController::class, 'login'])->name('ajax.login');
Route::post('/ajax-register', [UserLoginController::class, 'register'])->name('ajax.register');
Route::post('/ajax-resend-verification', [UserLoginController::class, 'resendVerification'])->name('ajax.resend-verification');
require __DIR__.'/auth.php';
