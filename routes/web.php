<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\UserSkillController as AdminUserSkillController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\SkillController as UserSkillController;
use App\Http\Controllers\User\EnrollmentController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\SummaryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\User\LearningController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Guest Routes (Not Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Both User and Admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| User Routes (Authenticated, Non-Admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Skills
    Route::get('/skills', [UserSkillController::class, 'index'])->name('user.skills');
    Route::post('/skills/{skill}/enroll', [EnrollmentController::class, 'store'])->name('user.skills.enroll');
       // Learning page
    Route::get('/skills/{skill}/learn', [LearningController::class, 'show'])->name('user.learn');
    // Payments
    Route::get('/payment/{skill}', [UserPaymentController::class, 'create'])->name('user.payment.create');
    Route::post('/payment/{skill}', [UserPaymentController::class, 'store'])->name('user.payment.store');
    
    // Bonus / Summary
    Route::get('/bonus', [SummaryController::class, 'index'])->name('user.bonus');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Authenticated + Admin Middleware)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Skills Management
    Route::resource('skills', AdminSkillController::class);
    
    // User Skill Approvals
    Route::get('user-skills', [AdminUserSkillController::class, 'index'])->name('user-skills.index');
    Route::post('user-skills/{userSkill}/approve', [AdminUserSkillController::class, 'approve'])->name('user-skills.approve');
    Route::post('user-skills/{userSkill}/reject', [AdminUserSkillController::class, 'reject'])->name('user-skills.reject');
    
    // Testimonials Management
    Route::resource('testimonials', AdminTestimonialController::class);
    
    // Payments Management
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show', 'update']);
    Route::post('payments/{payment}/complete', [AdminPaymentController::class, 'markCompleted'])->name('payments.complete');
});