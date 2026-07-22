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
use App\Http\Controllers\Backend\PlanController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\SubscriptionController;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\AdminSubscriptionController;
use App\Http\Controllers\Backend\SocialController;
use App\Http\Controllers\Frontend\MakehubController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\SubscriptionController as BackendSubscriptionController;
use App\Http\Controllers\Backend\BookLessonController;


// Inside your admin middleware group:
Route::middleware(['auth', 'admin.auth'])->prefix('admin')->name('admin.')->group(function () {
 
    // ... your existing user routes ...
 
    // Subscription management routes
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::patch('/{id}/pause',      [AdminSubscriptionController::class, 'pause'])->name('pause');
        Route::patch('/{id}/resume',     [AdminSubscriptionController::class, 'resume'])->name('resume');
        Route::patch('/{id}/cancel',     [AdminSubscriptionController::class, 'cancel'])->name('cancel');
        Route::patch('/{id}/cancel-now', [AdminSubscriptionController::class, 'cancelNow'])->name('cancelNow');
    });
 
});


Route::middleware('auth')->group(function () {
      Route::get('/dashboard',          [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/profile',          [UserDashboardController::class, 'index'])->name('profile.index');
    Route::post('/dashboard/profile/update',  [UserDashboardController::class, 'update'])->name('profile.update');
    Route::post('/dashboard/profile/update',  [UserDashboardController::class, 'update'])->name('profile.update');
    Route::get('/dashboard/invoice', [UserDashboardController::class, 'invoice'])->name('profile.invoice');


    Route::get('/invoice/{invoiceId}/download', [UserDashboardController::class, 'downloadInvoice'])->name('invoice.download');
    Route::post('/dashboard/profile/password',[UserDashboardController::class, 'updatePassword'])->name('profile.password');
});



Route::middleware('auth:admin')->group(function () {
      Route::get('admin/social-update', [SocialController::class, 'index'])->name('admin.social.update');
    Route::post('admin/settings-social-update', [SocialController::class, 'update'])->name('admin.settings.social.update');
      
});


Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/register-verify-email', [UserLoginController::class, 'verifyEmail']);
Route::get('/user-forgot-password', [UserLoginController::class, 'showForgotPasswordForm'])->name('user.forgot.password');
Route::post('/user-forgot-password', [UserLoginController::class, 'sendResetLink'])->name('ajax.forgot-password');
Route::post('/user-reset-password', [UserLoginController::class, 'resetPassword'])->name('ajax.reset-password');

// logout
Route::get('/userlogout', [UserDashboardController::class, 'logout'])->name('logout');


Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
// Route::get('/donate', [FrontendController::class, 'donate'])->name('donate');
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
// Route::get('/cookie-policy', [FrontendController::class, 'cookiePolicy'])->name('cookie.policy');


Route::middleware('auth')->group(function () {

     Route::get('book-lesson/form/{plan}', [CheckoutController::class, 'checkout'])->name('checkout'); 

     Route::post('book-lesson/store', [CheckoutController::class, 'checkoutstore'])->name('checkout.store');


     Route::get('checkout/{plan}', [CheckoutController::class, 'checkoutreal'])->name('checkout.real'); 

     
    

 

});


    Route::get('subs-checkout/cancel', [MakehubController::class, 'checkoutCancel'])->name('checkout-cancel'); 
    Route::get('subs-checkout/success', [MakehubController::class, 'checkoutSuccess'])->name('checkout-success'); 


Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe',        [SubscriptionController::class, 'showPlans'])->name('subscribe');
    Route::post('/subscribe',       [SubscriptionController::class, 'create'])->name('subscribe.create');
    Route::post('/subscribe/pause/{id}', [SubscriptionController::class, 'pause'])->name('subscriptions.pause');
    Route::post('/subscribe/resume/{id}',[SubscriptionController::class, 'resume'])->name('subscriptions.resume');
    Route::post('/subscribe/cancel-now/{id}',[SubscriptionController::class, 'cancelNow'])->name('subscriptions.cancelNow');
    Route::post('/subscribe/cancel/{id}',[SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    
    Route::post('/subscribe/update',[SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('/subscribe/success', [SubscriptionController::class, 'success'])->name('subscriptions.success');
});

// At the top of web.php, outside any middleware group:
Route::post('/stripe/webhook', [App\Http\Controllers\Frontend\WebhookController::class, 'handleWebhook'])
     ->name('cashier.webhook');



Route::get('user/showPlans', [SubscriptionController::class, 'showPlans']);
Route::get('user/cancel', [SubscriptionController::class, 'cancel']);

// fluent-safe-chaste-quaint
// acct_1LZ7mIIi1Z8eD8I6

Route::prefix('admin')->name('admin.')->group(function () {
 
    // Export must be registered BEFORE the resource route to avoid
    // "export" being interpreted as a {book_lesson} id.
    Route::get('book-lessons/export', [BookLessonController::class, 'export'])
        ->name('book-lessons.export');
 
    Route::resource('book-lessons', BookLessonController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy']);
});
 

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login']);
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard',           [DashboardController::class, 'index'])->name('admin.dashboard.index');
  
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/data', [TransactionController::class, 'getData'])->name('transactions.data');
        
        Route::get('/subscriptions', [BackendSubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/data', [BackendSubscriptionController::class, 'getData'])->name('subscriptions.data');


        Route::get('/company-information', [CompanyInformationController::class, 'index'])->name('admin.company-information.index');
        Route::post('/company-information', [CompanyInformationController::class, 'Update'])->name('admin.company-information.index');
    // Page
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])
        ->name('contact-messages.index');

        
    Route::get('/contact-messages/view/{id}', [ContactMessageController::class, 'view'])->name('backend.contact_messages.view');
 
      Route::post('/contact-messages/notes/{id}', [ContactMessageController::class, 'notes'])->name('backend.contact_messages.notes');
    
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


// plans
Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::get('plans-create',         [PlanController::class, 'create'])->name('admin.plans.create');
        Route::get('plans-index',         [PlanController::class, 'index'])->name('admin.plans.index');
        Route::post('plans-store',         [PlanController::class, 'store'])->name('admin.plans.store');
        Route::get('plans-edit/{id}',         [PlanController::class, 'edit'])->name('admin.plans.edit');
        Route::post('plans-update/{id}',         [PlanController::class, 'update'])->name('admin.plans.update');
        Route::delete('plans-delete/{id}',         [PlanController::class, 'destroy'])->name('admin.plans.destroy');
    });
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth:admin')->group(function () {
       
        Route::get('user-index',         [UserController::class, 'index'])->name('user.index');
        
        Route::get('user-view/{id}',         [UserController::class, 'edit'])->name('admin.user.edit');
        
        Route::delete('user-delete/{id}',         [UserController::class, 'destroy'])->name('admin.user.destroy');
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



Route::prefix('admin/users')->name('admin.users.')->group(function () {
 
    Route::get('/',                        [UserController::class, 'index'])->name('index');
    Route::get('/data',                    [UserController::class, 'data'])->name('data');     // AJAX
    Route::get('/{id}',                    [UserController::class, 'show'])->name('show');     // AJAX modal
    Route::patch('/{id}/toggle-active',    [UserController::class, 'toggleActive'])->name('toggle-active');
    Route::patch('/{id}/verify-email',     [UserController::class, 'verifyEmail'])->name('verify-email');
    Route::delete('/{id}',                 [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/restore',          [UserController::class, 'restore'])->name('restore');
    Route::get('/{id}/subscriptions',      [UserController::class, 'subscriptions'])->name('subscriptions');
 
});



Route::post('/ajax-login', [UserLoginController::class, 'login'])->name('ajax.login');
Route::post('/ajax-register', [UserLoginController::class, 'register'])->name('ajax.register');
Route::post('/ajax-resend-verification', [UserLoginController::class, 'resendVerification'])->name('ajax.resend-verification');
require __DIR__.'/auth.php';
