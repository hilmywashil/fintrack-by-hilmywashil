<?php

use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\IncomeExpenseController;

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| Public / Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/test-mail', function () {
    Mail::raw('Testing email dari Laravel', function ($message) {
        $message->to('mikejimmythegoat@gmail.com')
            ->subject('Test Email FinTrack');
    });

    return 'Email terkirim!';
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});

/* Forgot Password Routes */
Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('forgot.password.send');
Route::view('/preview-email', 'emails.otp'); // For testing email template
Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])
    ->name('otp.resend');

Route::middleware(['password.reset.flow'])->group(function () {

    Route::get('/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('otp.verify');

    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');

});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /* ---------- User Management (Admin Impersonation) ---------- */
    Route::post('/login-back', [AdminUserController::class, 'loginAsAdminBack'])
        ->name('admin.users.login-as-back');


    /* ---------- Dashboard ---------- */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/chart-data', [DashboardController::class, 'chartData']);

    /* ---------- Profile ---------- */

    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
        ->name('profile.photo.delete');

    /* ---------- Transactions ---------- */

    Route::get('/cashflow', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::post('/cashflow', [TransactionController::class, 'store'])
        ->name('transactions.store');

    Route::post('/transactions/reset', [TransactionController::class, 'resetAll'])
        ->name('transactions.reset');

    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');

    /* ---------- Income & Expense ---------- */

    Route::get('/incomes', [IncomeExpenseController::class, 'incomeIndex'])
        ->name('incomes.index');

    Route::get('/expenses', [IncomeExpenseController::class, 'expenseIndex'])
        ->name('expenses.index');

    /* ---------- Static Pages ---------- */

    Route::view('/about', 'others.about')
        ->name('about');

    Route::view('/help-center', 'others.help-center')
        ->name('help-center');

    /* ---------- Logout ---------- */

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    /* ---------- Login Activity ---------- */
    Route::get('/login-activity', [SettingsController::class, 'loginActivity'])
        ->name('settings.login-activity');

    Route::delete('/login-activity/clear', [SettingsController::class, 'clearLoginActivity'])
        ->name('settings.login-activity.clear');

    /* ---------- Report ---------- */
    Route::get('/reports/overview', [ReportController::class, 'overview'])
        ->name('reports.overview');

    /* ---------- Feedback ---------- */
    Route::get('/send-feedback', [FeedbackController::class, 'index'])
        ->name('feedback.index');

    Route::post('/send-feedback', [FeedbackController::class, 'store'])
        ->name('feedback.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    /* ---------- Admin Dashboard ---------- */

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    /* ---------- User Management ---------- */

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/users/{user}/login-as', [AdminUserController::class, 'loginAsUser'])
        ->name('admin.users.login-as');

    Route::put('/users/{user}/toggle-suspend', [AdminUserController::class, 'toggleSuspend'])
        ->name('admin.users.toggle-suspend');

    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
        ->name('admin.users.destroy');

    /* ---------- Category Management ---------- */

    Route::get('/categories', [AdminCategoryController::class, 'index'])
        ->name('admin.categories.index');


    /* ---------- Feedback Management ---------- */
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::delete('/feedback/{id}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');

});
