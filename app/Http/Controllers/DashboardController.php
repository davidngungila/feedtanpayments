<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    
    // Account Settings
    public function accountSettings()
    {
        return view('account-settings');
    }
    
    public function notifications()
    {
        return view('account-settings.notifications');
    }
    
    public function connections()
    {
        return view('account-settings.connections');
    }
    
    // Payments
    public function initiatePayment()
    {
        return view('payments.initiate');
    }
    
    public function paymentHistory()
    {
        return view('payments.history');
    }
    
    // Payouts
    public function initiatePayout()
    {
        return view('payouts.initiate');
    }
    
    public function payoutHistory()
    {
        return view('payouts.history');
    }
    
    // BillPay
    public function allBills()
    {
        return view('billpay.all');
    }
    
    public function createBill()
    {
        return view('billpay.create');
    }
    
    // Reports
    public function reportOverview()
    {
        return view('report.overview');
    }
    
    public function reportBalance()
    {
        return view('report.balance');
    }
    
    public function reportStatement()
    {
        return view('report.statement');
    }
    
    // Authentication
    public function login()
    {
        return view('auth.login');
    }
    
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }
    
    public function profile()
    {
        return view('auth.profile');
    }
    
    public function security()
    {
        return view('auth.security');
    }

    // System Settings Methods
    /**
     * Show the system general settings page.
     */
    public function systemGeneral()
    {
        return view('system-settings.general');
    }

    /**
     * Show the system payment settings page.
     */
    public function systemPayment()
    {
        return view('system-settings.payment');
    }

    /**
     * Show the system security settings page.
     */
    public function systemSecurity()
    {
        return view('system-settings.security');
    }

    /**
     * Show the system notification settings page.
     */
    public function systemNotification()
    {
        return view('system-settings.notification');
    }

    /**
     * Show the system user settings page.
     */
    public function systemUser()
    {
        return view('system-settings.user');
    }

    /**
     * Show the system integration settings page.
     */
    public function systemIntegration()
    {
        return view('system-settings.integration');
    }

    /**
     * Show the system maintenance page.
     */
    public function systemMaintenance()
    {
        return view('system-settings.maintenance');
    }
}
