<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Account Settings routes
Route::get('/account-settings', [DashboardController::class, 'accountSettings'])->name('account-settings');
Route::get('/account-settings/notifications', [DashboardController::class, 'notifications'])->name('account-settings.notifications');
Route::get('/account-settings/connections', [DashboardController::class, 'connections'])->name('account-settings.connections');

// Payment routes
Route::get('/payments/initiate', [DashboardController::class, 'initiatePayment'])->name('payments.initiate');
Route::get('/payments/history', [DashboardController::class, 'paymentHistory'])->name('payments.history');

// Payout routes
Route::get('/payouts/initiate', [DashboardController::class, 'initiatePayout'])->name('payouts.initiate');
Route::get('/payouts/history', [DashboardController::class, 'payoutHistory'])->name('payouts.history');

// BillPay routes
Route::get('/billpay/all', [DashboardController::class, 'allBills'])->name('billpay.all');
Route::get('/billpay/create', [DashboardController::class, 'createBill'])->name('billpay.create');

// Report routes
Route::get('/report/overview', [DashboardController::class, 'reportOverview'])->name('report.overview');
Route::get('/report/balance', [DashboardController::class, 'reportBalance'])->name('report.balance');
Route::get('/report/statement', [DashboardController::class, 'reportStatement'])->name('report.statement');

// System Settings Routes
Route::prefix('system-settings')->name('system-settings.')->group(function () {
    Route::get('/general', [DashboardController::class, 'systemGeneral'])->name('general');
    Route::get('/payment', [DashboardController::class, 'systemPayment'])->name('payment');
    Route::get('/security', [DashboardController::class, 'systemSecurity'])->name('security');
    Route::get('/notification', [DashboardController::class, 'systemNotification'])->name('notification');
    Route::get('/user', [DashboardController::class, 'systemUser'])->name('user');
    Route::get('/integration', [DashboardController::class, 'systemIntegration'])->name('integration');
    Route::get('/maintenance', [DashboardController::class, 'systemMaintenance'])->name('maintenance');
});

// Authentication routes
Route::get('/login', [DashboardController::class, 'login'])->name('login');
Route::get('/forgot-password', [DashboardController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/security', [DashboardController::class, 'security'])->name('security');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
