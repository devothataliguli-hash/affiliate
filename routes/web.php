<?php

use Illuminate\Support\Facades\Route;

// ==================== CONTROLLERS ====================
use App\Http\Controllers\LandingPageController;

// Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// User
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\SkillController as UserSkillController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\ProfileController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\TestimonialController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [LandingPageController::class, 'index'])->name('landing');


// ==================== GUEST ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


// ==================== AUTH ROUTES ====================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ==================== USER ROUTES ====================
    Route::prefix('user')->name('user.')->group(function () {

        // Dashboard
Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->name('dashboard');
        // Skills
        Route::get('/skills/{skill:slug}', [UserSkillController::class, 'show'])->name('skill.show');
        Route::get('/skills/{skill:slug}/content/{categorySlug}/{content}', [UserSkillController::class, 'content'])->name('skill.content');

        // My Skills
        Route::get('/my-skills', [UserSkillController::class, 'mySkills'])->name('my-skills');

        // Payments
        Route::get('/payments', [UserPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{skill}/create', [UserPaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments/{skill}', [UserPaymentController::class, 'store'])->name('payments.store');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });


    // ==================== ADMIN ROUTES ====================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
          // Users Management (Add this)
    Route::resource('users', UserController::class);


        // Skills
        Route::resource('skills', AdminSkillController::class);

        // Categories (Nested under Skills)
        Route::prefix('skills/{skill}')->name('skills.')->group(function () {
            Route::resource('categories', CategoryController::class);
        });

        // Contents (Nested under Categories)
        Route::prefix('categories/{category}')->name('categories.')->group(function () {
            Route::resource('contents', ContentController::class);
        });

        // Payments
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class);
    });
});