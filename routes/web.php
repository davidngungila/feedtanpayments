<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

// Members routes
Route::prefix('members')->name('members.')->group(function () {
    Route::get('/all', [DashboardController::class, 'membersAll'])->name('all');
    Route::get('/add', [DashboardController::class, 'membersAdd'])->name('add');
    Route::get('/profiles', [DashboardController::class, 'membersProfiles'])->name('profiles');
    Route::get('/groups', [DashboardController::class, 'membersGroups'])->name('groups');
    Route::get('/contributions', [DashboardController::class, 'membersContributions'])->name('contributions');
    Route::get('/reports', [DashboardController::class, 'membersReports'])->name('reports');
});

// Investment routes
Route::prefix('investment')->name('investment.')->group(function () {
    Route::get('/view', [DashboardController::class, 'investmentView'])->name('view');
    Route::get('/new', [DashboardController::class, 'investmentNew'])->name('new');
    Route::get('/plans', [DashboardController::class, 'investmentPlans'])->name('plans');
    Route::get('/returns', [DashboardController::class, 'investmentReturns'])->name('returns');
    Route::get('/history', [DashboardController::class, 'investmentHistory'])->name('history');
    Route::get('/reports', [DashboardController::class, 'investmentReports'])->name('reports');
});

// Savings routes
Route::prefix('savings')->name('savings.')->group(function () {
    Route::get('/deposit', [DashboardController::class, 'savingsDeposit'])->name('deposit');
    Route::get('/accounts', [DashboardController::class, 'savingsAccounts'])->name('accounts');
    Route::get('/history', [DashboardController::class, 'savingsHistory'])->name('history');
    Route::get('/withdrawal', [DashboardController::class, 'savingsWithdrawal'])->name('withdrawal');
    Route::get('/reports', [DashboardController::class, 'savingsReports'])->name('reports');
});

// Loans routes
Route::prefix('loans')->name('loans.')->group(function () {
    Route::get('/apply', [DashboardController::class, 'loansApply'])->name('apply');
    Route::get('/products', [DashboardController::class, 'loansProducts'])->name('products');
    Route::get('/my', [DashboardController::class, 'loansMy'])->name('my');
    Route::get('/repayments', [DashboardController::class, 'loansRepayments'])->name('repayments');
    Route::get('/schedule', [DashboardController::class, 'loansSchedule'])->name('schedule');
    Route::get('/reports', [DashboardController::class, 'loansReports'])->name('reports');
});

// Welfare routes
Route::prefix('welfare')->name('welfare.')->group(function () {
    Route::get('/contribute', [DashboardController::class, 'welfareContribute'])->name('contribute');
    Route::get('/balance', [DashboardController::class, 'welfareBalance'])->name('balance');
    Route::get('/support', [DashboardController::class, 'welfareSupport'])->name('support');
    Route::get('/history', [DashboardController::class, 'welfareHistory'])->name('history');
    Route::get('/reports', [DashboardController::class, 'welfareReports'])->name('reports');
});

// Shares routes
Route::prefix('shares')->name('shares.')->group(function () {
    Route::get('/buy', [DashboardController::class, 'sharesBuy'])->name('buy');
    Route::get('/my', [DashboardController::class, 'sharesMy'])->name('my');
    Route::get('/value', [DashboardController::class, 'sharesValue'])->name('value');
    Route::get('/dividends', [DashboardController::class, 'sharesDividends'])->name('dividends');
    Route::get('/transfers', [DashboardController::class, 'sharesTransfers'])->name('transfers');
    Route::get('/reports', [DashboardController::class, 'sharesReports'])->name('reports');
});

// System Settings Routes (Admin only)
Route::prefix('system-settings')->name('system-settings.')->middleware(['admin'])->group(function () {
    Route::get('/general', [DashboardController::class, 'systemGeneral'])->name('general');
    Route::post('/general', [DashboardController::class, 'storeGeneralSetting'])->name('general.store');
    Route::put('/general/{id}', [DashboardController::class, 'updateGeneralSetting'])->name('general.update');
    Route::delete('/general/{id}', [DashboardController::class, 'deleteGeneralSetting'])->name('general.delete');
    
    Route::get('/payment', [DashboardController::class, 'systemPayment'])->name('payment');
    Route::post('/payment', [DashboardController::class, 'storePaymentSetting'])->name('payment.store');
    Route::put('/payment/{id}', [DashboardController::class, 'updatePaymentSetting'])->name('payment.update');
    Route::delete('/payment/{id}', [DashboardController::class, 'deletePaymentSetting'])->name('payment.delete');
    Route::get('/security', [DashboardController::class, 'systemSecurity'])->name('security');
    Route::get('/notification', [DashboardController::class, 'systemNotification'])->name('notification');
    Route::get('/user', [DashboardController::class, 'systemUser'])->name('user');
    Route::get('/integration', [DashboardController::class, 'systemIntegration'])->name('integration');
    Route::get('/maintenance', [DashboardController::class, 'systemMaintenance'])->name('maintenance');
    
    // Admin user management
    Route::get('/create-admin', [AuthController::class, 'showCreateAdminForm'])->name('create-admin');
    Route::post('/create-admin', [AuthController::class, 'createAdmin']);
});

// API routes for settings
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/general-settings/{id}', [DashboardController::class, 'getGeneralSetting']);
    Route::delete('/general-settings/{id}', [DashboardController::class, 'deleteGeneralSetting']);
    Route::get('/payment-settings/{id}', [DashboardController::class, 'getPaymentSetting']);
    Route::delete('/payment-settings/{id}', [DashboardController::class, 'deletePaymentSetting']);
});

// Other routes
Route::get('/forgot-password', [DashboardController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
Route::get('/security', [DashboardController::class, 'security'])->name('security');

// API route for getting user role
Route::get('/api/user-role', [AuthController::class, 'getUserRole'])->middleware('auth');
});
