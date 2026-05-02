<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\ProfileController;

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

    // Profile and Settings routes
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/account-settings', [DashboardController::class, 'accountSettings'])->name('account-settings');
    Route::get('/security', [DashboardController::class, 'security'])->name('security');

    // Server Management routes
    Route::prefix('servers')->name('servers.')->group(function () {
        Route::get('/', [ServerController::class, 'index'])->name('index');
        Route::get('/create', [ServerController::class, 'create'])->name('create');
        Route::post('/store', [ServerController::class, 'store'])->name('store');
        Route::get('/{id}', [ServerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ServerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ServerController::class, 'update'])->name('update');
        Route::get('/{id}/performance', [ServerController::class, 'performance'])->name('performance');
        Route::get('/{id}/logs', [ServerController::class, 'logs'])->name('logs');
        Route::delete('/{id}', [ServerController::class, 'destroy'])->name('destroy');
        
        // Server Management Sub-pages
        Route::get('/monitoring', [ServerController::class, 'monitoring'])->name('monitoring');
        Route::get('/services', [ServerController::class, 'services'])->name('services');
        Route::get('/webserver', [ServerController::class, 'webserver'])->name('webserver');
        Route::get('/database', [ServerController::class, 'database'])->name('database');
        Route::get('/phpfpm', [ServerController::class, 'phpfpm'])->name('phpfpm');
        Route::get('/ssh', [ServerController::class, 'ssh'])->name('ssh');
        Route::get('/firewall', [ServerController::class, 'firewall'])->name('firewall');
        Route::get('/fail2ban', [ServerController::class, 'fail2ban'])->name('fail2ban');
    });

    // File Manager routes
    Route::prefix('filemanager')->name('filemanager.')->group(function () {
        Route::get('/', [FileManagerController::class, 'index'])->name('index');
        Route::get('/git-deployment', [FileManagerController::class, 'gitDeployment'])->name('git-deployment');
        Route::get('/environment-settings', [FileManagerController::class, 'environmentSettings'])->name('environment-settings');
        Route::get('/php-versions', [FileManagerController::class, 'phpVersions'])->name('php-versions');
        Route::get('/staging-environment', [FileManagerController::class, 'stagingEnvironment'])->name('staging-environment');
    });

    // Domain & DNS Management routes
    Route::prefix('domains')->name('domains.')->group(function () {
        Route::get('/', [DomainController::class, 'index'])->name('index');
        Route::get('/create', [DomainController::class, 'create'])->name('create');
        Route::post('/store', [DomainController::class, 'store'])->name('store');
        Route::get('/{id}', [DomainController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DomainController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DomainController::class, 'update'])->name('update');
        Route::get('/{id}/dns', [DomainController::class, 'dns'])->name('dns');
        Route::get('/{id}/ssl', [DomainController::class, 'ssl'])->name('ssl');
        Route::delete('/{id}', [DomainController::class, 'destroy'])->name('destroy');
        
        // DNS Management Sub-pages
        Route::get('/dns-management', [DomainController::class, 'dnsManagement'])->name('dns-management');
        Route::get('/a-records', [DomainController::class, 'aRecords'])->name('a-records');
        Route::get('/cname-records', [DomainController::class, 'cnameRecords'])->name('cname-records');
        Route::get('/mx-records', [DomainController::class, 'mxRecords'])->name('mx-records');
        Route::get('/nameservers', [DomainController::class, 'nameservers'])->name('nameservers');
        Route::get('/ssl-certificates', [DomainController::class, 'sslCertificates'])->name('ssl-certificates');
    });

    // Website Hosting routes
    Route::prefix('hosting')->name('hosting.')->group(function () {
        Route::get('/', [HostingController::class, 'index'])->name('index');
        Route::get('/create', [HostingController::class, 'create'])->name('create');
        Route::post('/store', [HostingController::class, 'store'])->name('store');
        Route::get('/{id}', [HostingController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [HostingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HostingController::class, 'update'])->name('update');
        Route::get('/{id}/analytics', [HostingController::class, 'analytics'])->name('analytics');
        Route::get('/{id}/files', [HostingController::class, 'files'])->name('files');
        Route::get('/{id}/databases', [HostingController::class, 'databases'])->name('databases');
        Route::get('/{id}/emails', [HostingController::class, 'emails'])->name('emails');
        Route::delete('/{id}', [HostingController::class, 'destroy'])->name('destroy');
    });

    // Email Management routes
    Route::prefix('email')->name('email.')->group(function () {
        Route::get('/', [EmailController::class, 'index'])->name('index');
        Route::get('/create', [EmailController::class, 'createEmail'])->name('create');
        Route::post('/store', [EmailController::class, 'store'])->name('store');
        Route::get('/{id}', [EmailController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [EmailController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EmailController::class, 'update'])->name('update');
        Route::get('/{id}/webmail', [EmailController::class, 'webmail'])->name('webmail');
        Route::get('/{id}/forwarding', [EmailController::class, 'forwarding'])->name('forwarding');
        Route::get('/{id}/auto-responder', [EmailController::class, 'autoResponder'])->name('auto-responder');
        Route::get('/spam-filter', [EmailController::class, 'spamFilter'])->name('spam-filter');
        Route::get('/forwarders', [EmailController::class, 'forwarders'])->name('forwarders');
        Route::get('/auto-responders', [EmailController::class, 'autoResponders'])->name('auto-responders');
        Route::get('/webmail-access', [EmailController::class, 'webmailAccess'])->name('webmail-access');
        Route::delete('/{id}', [EmailController::class, 'destroy'])->name('destroy');
    });

    // Database Management routes
    Route::prefix('database')->name('database.')->group(function () {
        Route::get('/', [DatabaseController::class, 'index'])->name('index');
        Route::get('/create', [DatabaseController::class, 'createDatabase'])->name('create');
        Route::post('/store', [DatabaseController::class, 'store'])->name('store');
        Route::get('/{id}', [DatabaseController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DatabaseController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DatabaseController::class, 'update'])->name('update');
        Route::delete('/{id}', [DatabaseController::class, 'destroy'])->name('destroy');
        Route::get('/users', [DatabaseController::class, 'databaseUsers'])->name('users');
        Route::get('/remote-access', [DatabaseController::class, 'remoteAccess'])->name('remote-access');
        Route::get('/phpmyadmin', [DatabaseController::class, 'phpMyAdmin'])->name('phpmyadmin');
        Route::get('/{id}/query', [DatabaseController::class, 'query'])->name('query');
        Route::get('/{id}/backup', [DatabaseController::class, 'backup'])->name('backup');
        Route::get('/{id}/performance', [DatabaseController::class, 'performance'])->name('performance');
    });

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

// Client Management routes
Route::prefix('clients')->name('clients.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/create', [ClientController::class, 'create'])->name('create');
    Route::post('/store', [ClientController::class, 'store'])->name('store');
    Route::get('/packages', [ClientController::class, 'clientPackages'])->name('packages');
    Route::get('/resource-limits', [ClientController::class, 'resourceLimits'])->name('resource-limits');
    Route::get('/disk-space', [ClientController::class, 'diskSpace'])->name('disk-space');
    Route::get('/bandwidth', [ClientController::class, 'bandwidth'])->name('bandwidth');
    Route::get('/domains-limit', [ClientController::class, 'domainsLimit'])->name('domains-limit');
    Route::get('/login-access', [ClientController::class, 'clientLoginAccess'])->name('login-access');
    Route::get('/{client}', [ClientController::class, 'show'])->name('show');
    Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit');
    Route::put('/{client}', [ClientController::class, 'update'])->name('update');
    Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
});

// Client switching API routes
Route::get('/api/clients/dropdown', [ClientController::class, 'getClientsForDropdown'])->name('api.clients.dropdown');
Route::post('/api/clients/switch', [ClientController::class, 'switchClient'])->name('api.clients.switch');
Route::get('/api/clients/current', [ClientController::class, 'getCurrentClient'])->name('api.clients.current');
Route::post('/api/clients/clear', [ClientController::class, 'clearClient'])->name('api.clients.clear');
Route::get('/api/clients/search', [ClientController::class, 'searchClients'])->name('api.clients.search');


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
    Route::get('/security-logs', [DashboardController::class, 'systemSecurityLogs'])->name('security-logs');
    Route::get('/notification', [DashboardController::class, 'systemNotification'])->name('notification');
    Route::get('/user', [DashboardController::class, 'systemUser'])->name('user');
    Route::get('/integration', [DashboardController::class, 'systemIntegration'])->name('integration');
    Route::get('/integration/create', [DashboardController::class, 'createIntegration'])->name('integration.create');
    Route::get('/integration/edit/{id}', [DashboardController::class, 'editIntegration'])->name('integration.edit');
    Route::get('/integration/sms-api', [DashboardController::class, 'integrationSmsApi'])->name('integration.sms-api');
    Route::get('/integration/email-api', [DashboardController::class, 'integrationEmailApi'])->name('integration.email-api');
    Route::get('/integration/payment-api', [DashboardController::class, 'integrationPaymentApi'])->name('integration.payment-api');
    Route::get('/maintenance', [DashboardController::class, 'systemMaintenance'])->name('maintenance');
    Route::get('/health', [DashboardController::class, 'systemHealth'])->name('health');
    Route::get('/audit', [DashboardController::class, 'systemAudit'])->name('audit');
    
    // Security Center Routes
    Route::prefix('security')->name('security.')->group(function () {
        Route::get('/authentication', [DashboardController::class, 'securityAuthentication'])->name('authentication');
        Route::get('/fraud', [DashboardController::class, 'securityFraud'])->name('fraud');
        Route::get('/access', [DashboardController::class, 'securityAccess'])->name('access');
        Route::get('/device', [DashboardController::class, 'securityDevice'])->name('device');
        Route::get('/session', [DashboardController::class, 'securitySession'])->name('session');
        Route::get('/protection', [DashboardController::class, 'securityProtection'])->name('protection');
        Route::get('/alerts', [DashboardController::class, 'securityAlerts'])->name('alerts');
        Route::get('/tracking', [DashboardController::class, 'securityTracking'])->name('tracking');
    });
    
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

// Test route to verify Laravel routing works
Route::get('/test-messaging-simple', function() {
    return response()->json(['message' => 'Laravel routing works!', 'timestamp' => now()]);
});

// Messaging System Routes
Route::prefix('messaging')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [MessagingController::class, 'dashboard'])->name('messaging.dashboard');
    
    // SMS Routes
    Route::get('/sms', [MessagingController::class, 'smsIndex'])->name('messaging.sms');
    Route::get('/sms/logs', [MessagingController::class, 'smsLogsPage'])->name('messaging.sms.logs');
    Route::post('/sms/send', [MessagingController::class, 'sendSms'])->name('messaging.sms.send');
    
    // Email Routes
    Route::get('/email', [MessagingController::class, 'emailIndex'])->name('messaging.email');
    Route::post('/email/send', [MessagingController::class, 'sendEmail'])->name('messaging.email.send');
    
    // Services Management Routes
    Route::get('/services', [MessagingController::class, 'servicesIndex'])->name('messaging.services');
    Route::get('/services/{serviceId}', [MessagingController::class, 'getService'])->name('messaging.services.show');
    Route::post('/services', [MessagingController::class, 'storeService'])->name('messaging.services.store');
    Route::put('/services/{service}', [MessagingController::class, 'updateService'])->name('messaging.services.update');
    Route::delete('/services/{service}', [MessagingController::class, 'deleteService'])->name('messaging.services.delete');
    Route::post('/services/{serviceId}/test', [MessagingController::class, 'testService'])->name('messaging.services.test');
    Route::post('/services/{serviceId}/toggle/{activate}', [MessagingController::class, 'toggleServiceStatus'])->name('messaging.services.toggle');
});

// Other routes
Route::get('/forgot-password', [DashboardController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
Route::get('/security', [DashboardController::class, 'security'])->name('security');

// Profile API routes
Route::get('/api/profile', [ProfileController::class, 'getProfile'])->name('api.profile.get');
Route::post('/api/profile/update', [ProfileController::class, 'update'])->name('api.profile.update');
Route::post('/api/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('api.profile.upload-avatar');
Route::delete('/api/profile/delete-avatar', [ProfileController::class, 'deleteAvatar'])->name('api.profile.delete-avatar');
Route::post('/api/change-password', [ProfileController::class, 'changePassword'])->name('api.change-password');
Route::get('/api/download-user-data', [ProfileController::class, 'downloadUserData'])->name('api.download-user-data');

// API route for getting user role
Route::get('/api/user-role', [AuthController::class, 'getUserRole'])->middleware('auth');

// API route for SMS message details
Route::get('/api/sms-messages/{messageId}', [MessagingController::class, 'getSmsMessage']);

// API route for SMS message export
Route::get('/api/sms-messages/{messageId}/export', [MessagingController::class, 'exportSmsMessage'])->middleware('auth');

// API routes for SMS logs and balance
Route::get('/api/sms-logs', [MessagingController::class, 'getSmsLogs'])->middleware('auth');
Route::get('/api/sms-logs/export', [MessagingController::class, 'exportSmsLogs'])->middleware('auth');
Route::get('/api/sms-balance', [MessagingController::class, 'getSmsBalance'])->middleware('auth');

// API routes for email templates
Route::post('/api/email-template/preview', [MessagingController::class, 'previewEmailTemplate'])->middleware('auth');
Route::get('/api/email-template/{id}', [MessagingController::class, 'getEmailTemplate'])->middleware('auth');

// API routes for email messages
Route::get('/api/email-messages/{messageId}', [MessagingController::class, 'getEmailMessage'])->middleware('auth');
Route::get('/api/email-messages/{messageId}/content', [MessagingController::class, 'getEmailMessageContent'])->middleware('auth');
Route::get('/api/email-messages/{messageId}/export', [MessagingController::class, 'exportEmailMessage'])->middleware('auth');
});
