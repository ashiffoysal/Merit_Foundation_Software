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
use App\Http\Controllers\Frontend\TrialBookingController;
use App\Http\Controllers\Backend\FreeTrialController; 


// Inside your admin middleware group:
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
 
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

// free Trial

// Route::middleware('auth:admin')->group(function () {
//     Route::get('admin/free-trial', [FreeTrialController::class, 'index'])->name('admin.free.index');
//     Route::get('admin/free-trial/view/{id}', [FreeTrialController::class, 'getDetails'])->name('admin.free.getDetails');
      
// });


Route::prefix('admin')->middleware(['auth:admin'])->group(function () {

    // Table data (search/filter/sort/paginate/stats)
    Route::get('free-trials', [FreeTrialController::class, 'getIndex'])
        ->name('admin.free.getindex');

    // View single record
    Route::get('contact-messages/view/{id}', [FreeTrialController::class, 'view']);

    // Update status
    Route::patch('contact-messages/{id}/status', [FreeTrialController::class, 'updateStatus']);

    // Delete single record
    Route::delete('contact-messages/{id}', [FreeTrialController::class, 'destroy']);

    // Bulk action (mark read/pending/delete)
    Route::post('contact-messages/bulk', [FreeTrialController::class, 'bulkAction'])
        ->name('contact-messages.bulk');

    // Export CSV/Excel
    Route::get('contact-messages/export', [FreeTrialController::class, 'export'])
        ->name('contact-messages.export');

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
 Route::get('/services', [FrontendController::class, 'services'])->name('services');

 Route::get('/book-free-trial', [FrontendController::class, 'bookFreeTrial'])->name('book.free.trial');
 Route::post('/book-free-trial', [FrontendController::class, 'bookFreeTrialsubmit'])->name('book.free.trial');

Route::get('/admission-procedure', [FrontendController::class, 'admissionProcedure'])->name('admissionProcedure.index');
Route::get('/prices', [FrontendController::class, 'bookLesson'])->name('prices.lesson');
Route::get('/contact', [FrontendController::class, 'contactUs'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactSubmt'])->name('contact.submit');
Route::get('/safeguarding-policy', [FrontendController::class, 'safeguard'])->name('safeguard');
// privacy policy
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy.policy');

// cookie policy
Route::get('/cookie-policy', [FrontendController::class, 'cookiePolicy'])->name('cookie.policy');
// refund policy
Route::get('/refund-policy', [FrontendController::class, 'refundPolicy'])->name('refund.policy');
// terms and conditions
Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndCondition'])->name('terms.and.conditions');
// news
Route::get('/news', [FrontendController::class, 'news'])->name('news');
// news details
Route::get('/news/{slug}', [FrontendController::class, 'newsDetails'])->name('news.details');

 Route::post('/free-trial-submit', [TrialBookingController::class, 'freemodalTrialSubmit']);


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
        
        Route::get('/subscriptions', [App\Http\Controllers\Backend\SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/data', [App\Http\Controllers\Backend\SubscriptionController::class, 'getData'])->name('subscriptions.data');


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

     Route::get('free-trial', [ContactMessageController::class, 'freetrialindex'])->name('admin.free.index');
    Route::get('free-trial/view/{id}', [ContactMessageController::class, 'freetrialgetDetails'])->name('admin.free.getDetails');


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
   Route::middleware('auth:admin')->group(function () {
    Route::get('/',                        [UserController::class, 'index'])->name('index');
    Route::get('/data',                    [UserController::class, 'data'])->name('data');     // AJAX
    Route::get('/{id}',                    [UserController::class, 'show'])->name('show');     // AJAX modal
    Route::patch('/{id}/toggle-active',    [UserController::class, 'toggleActive'])->name('toggle-active');
    Route::patch('/{id}/verify-email',     [UserController::class, 'verifyEmail'])->name('verify-email');
    Route::delete('/{id}',                 [UserController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/restore',          [UserController::class, 'restore'])->name('restore');
    Route::get('/{id}/subscriptions',      [UserController::class, 'subscriptions'])->name('subscriptions');
 });
});



Route::post('/ajax-login', [UserLoginController::class, 'login'])->name('ajax.login');
Route::post('/ajax-register', [UserLoginController::class, 'register'])->name('ajax.register');
Route::post('/ajax-resend-verification', [UserLoginController::class, 'resendVerification'])->name('ajax.resend-verification');
require __DIR__.'/auth.php';
// ─────────── Teacher / Parent / Student / Lesson management (Admin) ───────────
use App\Http\Controllers\Backend\Academic\DocumentController as AcademicDocumentController;
use App\Http\Controllers\Backend\Academic\LessonController as AcademicLessonController;
use App\Http\Controllers\Backend\Academic\LookupController as AcademicLookupController;
use App\Http\Controllers\Backend\Academic\ParentController as AcademicParentController;
use App\Http\Controllers\Backend\Academic\SearchController as AcademicSearchController;
use App\Http\Controllers\Backend\Academic\StudentController as AcademicStudentController;
use App\Http\Controllers\Backend\Academic\TeacherController as AcademicTeacherController;

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // Teachers
    Route::get('teachers/{teacher}/photo', [AcademicTeacherController::class, 'photo'])->name('teachers.photo');
    Route::resource('teachers', AcademicTeacherController::class);

    // Parents (model: Guardian, table: parents)
    Route::resource('parents', AcademicParentController::class)->parameters(['parents' => 'parent']);
    Route::bind('parent', fn ($v) => \App\Models\Guardian::findOrFail($v));

    // Students
    Route::get('students/{student}/photo', [AcademicStudentController::class, 'photo'])->name('students.photo');
    Route::resource('students', AcademicStudentController::class);

    // Lessons
    Route::get('lessons/timetable', [AcademicLessonController::class, 'timetable'])->name('lessons.timetable');
    Route::get('lessons/availability', [AcademicLessonController::class, 'availability'])->name('lessons.availability');
    Route::post('lessons/{lesson}/students', [AcademicLessonController::class, 'enroll'])->name('lessons.enroll');
    Route::delete('lessons/{lesson}/students/{student}', [AcademicLessonController::class, 'unenroll'])->name('lessons.unenroll');
    Route::resource('lessons', AcademicLessonController::class);

    // Private documents (teachers / parents)
    Route::post('{owner}/{id}/documents', [AcademicDocumentController::class, 'store'])
        ->whereIn('owner', ['teachers', 'parents'])->whereNumber('id')->name('documents.store');
    Route::get('documents/{owner}/{document}', [AcademicDocumentController::class, 'download'])
        ->whereIn('owner', ['teachers', 'parents'])->whereNumber('document')->name('documents.download');
    Route::delete('documents/{owner}/{document}', [AcademicDocumentController::class, 'destroy'])
        ->whereIn('owner', ['teachers', 'parents'])->whereNumber('document')->name('documents.destroy');

    // AJAX searchable dropdowns
    Route::get('academic-search/{type}', AcademicSearchController::class)
        ->whereIn('type', ['parents', 'students', 'teachers', 'classrooms'])->name('academic.search');

    // Settings: branches, subjects, levels, classrooms, schools, year groups, statuses
    Route::prefix('academic-settings/{type}')->name('lookups.')->group(function () {
        Route::get('/', [AcademicLookupController::class, 'index'])->name('index');
        Route::post('/', [AcademicLookupController::class, 'store'])->name('store');
        Route::put('{id}', [AcademicLookupController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('{id}', [AcademicLookupController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });
});


// ─────────── Teacher panel ───────────
use App\Http\Controllers\Teacher\AuthController as TeacherAuthController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\ReportController as TeacherReportController;

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('login', [TeacherAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [TeacherAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [TeacherAuthController::class, 'logout'])->name('logout');

    Route::middleware('teacher.auth')->group(function () {
        Route::redirect('/', '/teacher/dashboard');
        Route::get('dashboard', TeacherDashboardController::class)->name('dashboard');

        Route::get('lessons', [TeacherLessonController::class, 'index'])->name('lessons.index');
        Route::get('lessons/{lesson}', [TeacherLessonController::class, 'show'])->name('lessons.show');

        Route::get('reports', [TeacherReportController::class, 'index'])->name('reports.index');
        Route::get('reports/{session}', [TeacherReportController::class, 'show'])->whereNumber('session')->name('reports.show');
        Route::get('lessons/{lesson}/report/{date}', [TeacherReportController::class, 'edit'])->where('date', '\d{4}-\d{2}-\d{2}')->name('reports.edit');
        Route::put('lessons/{lesson}/report/{date}', [TeacherReportController::class, 'update'])->where('date', '\d{4}-\d{2}-\d{2}')->name('reports.update');

        Route::get('profile', [TeacherProfileController::class, 'show'])->name('profile');
        Route::put('profile/password', [TeacherProfileController::class, 'updatePassword'])->name('password.update');
    });
});

// Admin: view a submitted class report
Route::get('admin/class-reports/{session}', [AcademicLessonController::class, 'report'])
    ->middleware('auth:admin')->whereNumber('session')->name('admin.lessons.report');



    // ─────────── Learning resources + progress reports ───────────
use App\Http\Controllers\Backend\Academic\ProgressReportController as AcademicProgressReportController;
use App\Http\Controllers\Backend\Academic\ReportSettingsController as AcademicReportSettingsController;
use App\Http\Controllers\Backend\Academic\ResourceController as AcademicResourceController;
use App\Http\Controllers\Teacher\ResourceController as TeacherResourceController;

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('resources/{resource}/download', [AcademicResourceController::class, 'download'])->name('resources.download');
    Route::resource('resources', AcademicResourceController::class)->except('show');

    Route::get('progress-reports', [AcademicProgressReportController::class, 'index'])->name('progress.index');
    Route::patch('class-reports/{session}/edit-access', [AcademicProgressReportController::class, 'editAccess'])->whereNumber('session')->name('progress.edit-access');

    Route::get('report-settings', [AcademicReportSettingsController::class, 'edit'])->name('report-settings.edit');
    Route::put('report-settings', [AcademicReportSettingsController::class, 'update'])->name('report-settings.update');
});

Route::prefix('teacher')->name('teacher.')->middleware('teacher.auth')->group(function () {
    Route::get('resources', [TeacherResourceController::class, 'index'])->name('resources.index');
    Route::get('resources/{resource}/download', [TeacherResourceController::class, 'download'])->name('resources.download');
});
