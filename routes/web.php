<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/dashboard");

Route::get('/chart-data', [DashboardController::class, 'chartData'])
    ->middleware('auth');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/users', action: [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])
        ->name('admin.categories.index');

    // Route to login as user
    Route::post('/users/{user}/login-as', [AdminUserController::class, 'loginAsUser'])
        ->name('admin.users.login-as');

    Route::put(
        '/admin/users/{user}/toggle-suspend',
        [AdminUserController::class, 'toggleSuspend']
    )->name('admin.users.toggle-suspend');

});

// User routes
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile');
    
    Route::view('/about', 'others.about')->name('about');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route to login back as admin
    Route::post('/admin/login-back', [AdminUserController::class, 'loginAsAdminBack'])
        ->name('admin.users.login-as-back');

    // Route to reset all transactions
    Route::post('/transactions/reset', [TransactionController::class, 'resetAll'])
        ->name('transactions.reset');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/cashflow', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/dashboard/cashflow', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/dashboard/incomes', [IncomeExpenseController::class, 'incomeIndex'])->name('incomes.index');
    Route::get('/dashboard/expenses', [IncomeExpenseController::class, 'expenseIndex'])->name('expenses.index');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
