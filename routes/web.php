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
use App\Http\Controllers\User\LearningController;
use App\Http\Controllers\LandingPageController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// ==================== GUEST ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// ==================== USER ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/skills', [UserSkillController::class, 'index'])->name('user.skills');
    Route::post('/skills/{skill}/enroll', [EnrollmentController::class, 'store'])->name('user.skills.enroll');
    Route::get('/skills/{skill}/learn', [LearningController::class, 'show'])->name('user.learn');
    Route::get('/payment/{skill}', [UserPaymentController::class, 'create'])->name('user.payment.create');
    Route::post('/payment/{skill}', [UserPaymentController::class, 'store'])->name('user.payment.store');
    Route::get('/bonus', [SummaryController::class, 'index'])->name('user.bonus');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ── Skills ────────────────────────────────────────────────────────────────
    // Resource routes (index, create, store, edit, update, destroy)
    Route::resource('skills', AdminSkillController::class);

    // JSON list for AJAX pagination/search
    Route::get('/skills-json', [AdminSkillController::class, 'indexJson'])->name('skills.json');

    // BUG FIX: Renamed from /skills/{skill}/json → /skills/{skill}/edit-json
    // The old name collided with the resource "show" route.
    Route::get('/skills/{skill}/edit-json', [AdminSkillController::class, 'editJson'])->name('skills.edit-json');

    // ── Categories (handled inside SkillController for simplicity) ────────────
    Route::get('/categories/all', [AdminSkillController::class, 'allCategories'])->name('categories.all');
    Route::post('/categories', [AdminSkillController::class, 'storeCategory'])->name('categories.store');
    // BUG FIX: categories PUT also sent as POST+_method, so we register both verbs
    Route::match(['PUT', 'POST'], '/categories/{category}', [AdminSkillController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminSkillController::class, 'destroyCategory'])->name('categories.destroy');

    // ── User skill approvals ──────────────────────────────────────────────────
    Route::get('/user-skills', [AdminUserSkillController::class, 'index'])->name('user-skills.index');
    Route::post('/user-skills/{userSkill}/approve', [AdminUserSkillController::class, 'approve'])->name('user-skills.approve');
    Route::post('/user-skills/{userSkill}/reject', [AdminUserSkillController::class, 'reject'])->name('user-skills.reject');

    // ── Testimonials ──────────────────────────────────────────────────────────
    Route::resource('testimonials', AdminTestimonialController::class);

    // ── Payments ──────────────────────────────────────────────────────────────
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show', 'update']);
    Route::patch('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');
    Route::delete('/payments/{payment}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::patch('/payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');
    Route::get('/payments-json', [AdminPaymentController::class, 'indexJson'])->name('payments.json');
    Route::post('/payments/{payment}/complete', [AdminPaymentController::class, 'markCompleted'])->name('payments.complete');
});