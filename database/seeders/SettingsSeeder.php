<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralSetting;
use App\Models\PaymentSetting;
use App\Models\SecuritySetting;
use App\Models\NotificationSetting;
use App\Models\UserSetting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General Settings
        GeneralSetting::setValue('site_name', 'FeedTan Pay', 'text', 'general', 'Application name', true);
        GeneralSetting::setValue('site_description', 'Professional Payment Management System', 'text', 'general', 'Application description', true);
        GeneralSetting::setValue('timezone', 'America/New_York', 'text', 'general', 'Default timezone');
        GeneralSetting::setValue('date_format', 'm/d/Y', 'text', 'general', 'Date format');
        GeneralSetting::setValue('time_format', '12-hour', 'text', 'general', 'Time format (12-hour or 24-hour)');
        GeneralSetting::setValue('language', 'en', 'text', 'general', 'Default language');
        GeneralSetting::setValue('maintenance_mode', 'false', 'boolean', 'general', 'Enable maintenance mode');
        GeneralSetting::setValue('max_file_size', '10240', 'number', 'general', 'Maximum file upload size in KB');

        // Payment Settings
        PaymentSetting::setValue('default_currency', 'USD', 'text', 'payment', 'Default currency');
        PaymentSetting::setValue('supported_currencies', '["USD","EUR","GBP","TZS"]', 'json', 'payment', 'Supported currencies');
        PaymentSetting::setValue('payment_gateway', 'stripe', 'text', 'payment', 'Default payment gateway');
        PaymentSetting::setValue('stripe_public_key', '', 'text', 'payment', 'Stripe public key');
        PaymentSetting::setValue('stripe_secret_key', '', 'text', 'payment', 'Stripe secret key');
        PaymentSetting::setValue('transaction_fee_percentage', '2.9', 'number', 'payment', 'Transaction fee percentage');
        PaymentSetting::setValue('transaction_fee_fixed', '0.30', 'number', 'payment', 'Fixed transaction fee');
        PaymentSetting::setValue('auto_confirm_payments', 'true', 'boolean', 'payment', 'Auto-confirm payments under threshold');
        PaymentSetting::setValue('payment_threshold', '100', 'number', 'payment', 'Auto-confirm threshold amount');

        // Security Settings
        SecuritySetting::setValue('password_min_length', '8', 'number', 'security', 'Minimum password length');
        SecuritySetting::setValue('require_special_chars', 'true', 'boolean', 'security', 'Require special characters in password');
        SecuritySetting::setValue('require_numbers', 'true', 'boolean', 'security', 'Require numbers in password');
        SecuritySetting::setValue('require_uppercase', 'true', 'boolean', 'security', 'Require uppercase letters in password');
        SecuritySetting::setValue('session_timeout', '120', 'number', 'security', 'Session timeout in minutes');
        SecuritySetting::setValue('max_login_attempts', '5', 'number', 'security', 'Maximum login attempts');
        SecuritySetting::setValue('lockout_duration', '15', 'number', 'security', 'Account lockout duration in minutes');
        SecuritySetting::setValue('enable_2fa', 'false', 'boolean', 'security', 'Enable two-factor authentication');
        SecuritySetting::setValue('allowed_ip_addresses', '[]', 'json', 'security', 'Allowed IP addresses (whitelist)');
        SecuritySetting::setValue('blocked_ip_addresses', '[]', 'json', 'security', 'Blocked IP addresses (blacklist)');
        SecuritySetting::setValue('enable_geo_blocking', 'false', 'boolean', 'security', 'Enable geographic blocking');

        // Notification Settings
        NotificationSetting::setValue('email_notifications', 'true', 'boolean', 'notification', 'Enable email notifications');
        NotificationSetting::setValue('sms_notifications', 'false', 'boolean', 'notification', 'Enable SMS notifications');
        NotificationSetting::setValue('push_notifications', 'true', 'boolean', 'notification', 'Enable push notifications');
        NotificationSetting::setValue('payment_success_emails', 'true', 'boolean', 'notification', 'Send payment success emails');
        NotificationSetting::setValue('payment_failure_emails', 'true', 'boolean', 'notification', 'Send payment failure emails');
        NotificationSetting::setValue('security_alert_emails', 'true', 'boolean', 'notification', 'Send security alert emails');
        NotificationSetting::setValue('marketing_emails', 'false', 'boolean', 'notification', 'Send marketing emails');
        NotificationSetting::setValue('email_from_address', 'noreply@feedtanpay.com', 'text', 'notification', 'From email address');
        NotificationSetting::setValue('email_from_name', 'FeedTan Pay', 'text', 'notification', 'From email name');
        NotificationSetting::setValue('smtp_host', '', 'text', 'notification', 'SMTP host');
        NotificationSetting::setValue('smtp_port', '587', 'number', 'notification', 'SMTP port');
        NotificationSetting::setValue('smtp_username', '', 'text', 'notification', 'SMTP username');
        NotificationSetting::setValue('smtp_password', '', 'text', 'notification', 'SMTP password');

        // User Settings
        UserSetting::setValue('default_user_role', 'staff', 'text', 'user', 'Default role for new users');
        UserSetting::setValue('require_email_verification', 'true', 'boolean', 'user', 'Require email verification for new users');
        UserSetting::setValue('allow_user_registration', 'false', 'boolean', 'user', 'Allow public user registration');
        UserSetting::setValue('user_session_duration', '24', 'number', 'user', 'User session duration in hours');
        UserSetting::setValue('max_concurrent_sessions', '3', 'number', 'user', 'Maximum concurrent sessions per user');
        UserSetting::setValue('enable_user_profiles', 'true', 'boolean', 'user', 'Enable user profile editing');
        UserSetting::setValue('enable_user_deletion', 'false', 'boolean', 'user', 'Allow users to delete their accounts');
        UserSetting::setValue('data_retention_days', '365', 'number', 'user', 'Data retention period in days');
        UserSetting::setValue('user_dashboard_layout', 'default', 'text', 'user', 'Default dashboard layout');

        $this->command->info('Settings tables seeded successfully!');
    }
}
