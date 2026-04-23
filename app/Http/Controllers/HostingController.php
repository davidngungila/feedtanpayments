<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index()
    {
        $websites = [
            [
                'id' => 1,
                'domain' => 'example.com',
                'status' => 'active',
                'server' => 'web-server-01',
                'disk_usage' => 2.4,
                'bandwidth' => 45.6,
                'visitors' => 1250,
                'ssl_status' => 'active',
                'backup_status' => 'enabled',
                'created_at' => '2022-03-15'
            ],
            [
                'id' => 2,
                'domain' => 'myapp.net',
                'status' => 'active',
                'server' => 'app-server-02',
                'disk_usage' => 5.8,
                'bandwidth' => 78.2,
                'visitors' => 3420,
                'ssl_status' => 'active',
                'backup_status' => 'enabled',
                'created_at' => '2021-12-31'
            ],
            [
                'id' => 3,
                'domain' => 'techblog.org',
                'status' => 'suspended',
                'server' => 'web-server-01',
                'disk_usage' => 1.2,
                'bandwidth' => 12.4,
                'visitors' => 890,
                'ssl_status' => 'expired',
                'backup_status' => 'disabled',
                'created_at' => '2023-06-20'
            ],
            [
                'id' => 4,
                'domain' => 'business-site.io',
                'status' => 'active',
                'server' => 'web-server-01',
                'disk_usage' => 8.9,
                'bandwidth' => 156.3,
                'visitors' => 5670,
                'ssl_status' => 'active',
                'backup_status' => 'enabled',
                'created_at' => '2020-10-10'
            ],
            [
                'id' => 5,
                'domain' => 'portfolio.dev',
                'status' => 'active',
                'server' => 'test-server-06',
                'disk_usage' => 0.8,
                'bandwidth' => 8.7,
                'visitors' => 234,
                'ssl_status' => 'none',
                'backup_status' => 'disabled',
                'created_at' => '2023-08-05'
            ]
        ];

        return view('hosting.index', compact('websites'));
    }

    public function create()
    {
        return view('hosting.create');
    }

    public function show($id)
    {
        $website = [
            'id' => $id,
            'domain' => 'example.com',
            'status' => 'active',
            'server' => 'web-server-01',
            'disk_usage' => 2.4,
            'disk_limit' => 10,
            'bandwidth' => 45.6,
            'bandwidth_limit' => 100,
            'visitors' => 1250,
            'ssl_status' => 'active',
            'ssl_expiry' => '2025-01-20',
            'backup_status' => 'enabled',
            'php_version' => '8.2',
            'database' => 'example_db',
            'email_accounts' => 5,
            'subdomains' => 3,
            'created_at' => '2022-03-15',
            'analytics' => [
                'visitors_today' => 45,
                'pageviews_today' => 234,
                'bounce_rate' => 32.5,
                'avg_session_duration' => '2:45',
                'top_pages' => [
                    ['page' => '/', 'views' => 89],
                    ['page' => '/about', 'views' => 45],
                    ['page' => '/services', 'views' => 38],
                    ['page' => '/contact', 'views' => 28],
                    ['page' => '/blog', 'views' => 23]
                ]
            ],
            'recent_visitors' => [
                ['ip' => '192.168.1.100', 'page' => '/', 'time' => '14:30:00', 'country' => 'US'],
                ['ip' => '192.168.1.101', 'page' => '/about', 'time' => '14:25:00', 'country' => 'UK'],
                ['ip' => '192.168.1.102', 'page' => '/services', 'time' => '14:20:00', 'country' => 'CA'],
                ['ip' => '192.168.1.103', 'page' => '/contact', 'time' => '14:15:00', 'country' => 'AU'],
                ['ip' => '192.168.1.104', 'page' => '/blog', 'time' => '14:10:00', 'country' => 'DE']
            ]
        ];

        return view('hosting.show', compact('website'));
    }

    public function edit($id)
    {
        $website = [
            'id' => $id,
            'domain' => 'example.com',
            'status' => 'active',
            'server' => 'web-server-01',
            'php_version' => '8.2',
            'disk_limit' => 10,
            'bandwidth_limit' => 100,
            'ssl_enabled' => true,
            'backup_enabled' => true,
            'auto_renew_ssl' => true,
            'email_forwarding' => true,
            'error_pages' => true,
            'hotlink_protection' => false
        ];

        return view('hosting.edit', compact('website'));
    }

    public function analytics($id)
    {
        $analytics = [
            'daily_visitors' => [45, 52, 48, 61, 58, 72, 65, 78, 82, 75, 69, 63, 58, 72, 68, 75, 82, 88, 92, 85, 78, 71, 65, 58, 62, 68, 74, 79, 85, 89],
            'pageviews' => [234, 267, 245, 298, 287, 342, 312, 367, 389, 365, 334, 298, 278, 345, 323, 345, 378, 401, 423, 398, 367, 334, 298, 267, 289, 312, 334, 356, 378, 398],
            'bounce_rate' => [32.5, 30.2, 34.8, 28.9, 31.2, 26.7, 29.8, 25.3, 23.4, 26.8, 29.2, 32.1, 35.6, 30.2, 28.7, 26.3, 24.8, 22.1, 20.5, 23.2, 26.7, 29.8, 32.4, 35.1, 31.2, 28.9, 26.5, 24.1, 21.8, 19.5],
            'avg_session_duration' => [165, 178, 152, 189, 175, 198, 182, 205, 218, 195, 178, 162, 145, 168, 182, 195, 208, 225, 238, 215, 198, 182, 165, 148, 162, 175, 188, 202, 215, 228]
        ];

        return view('hosting.analytics', compact('analytics'));
    }

    public function files($id)
    {
        $files = [
            ['name' => 'index.html', 'size' => '12.4 KB', 'modified' => '2024-12-22 14:30:00', 'type' => 'file'],
            ['name' => 'about.html', 'size' => '8.7 KB', 'modified' => '2024-12-22 13:45:00', 'type' => 'file'],
            ['name' => 'css', 'size' => '-', 'modified' => '2024-12-22 12:30:00', 'type' => 'directory'],
            ['name' => 'js', 'size' => '-', 'modified' => '2024-12-22 12:15:00', 'type' => 'directory'],
            ['name' => 'images', 'size' => '-', 'modified' => '2024-12-22 11:45:00', 'type' => 'directory'],
            ['name' => 'uploads', 'size' => '-', 'modified' => '2024-12-22 10:30:00', 'type' => 'directory'],
            ['name' => 'config.php', 'size' => '2.1 KB', 'modified' => '2024-12-22 09:15:00', 'type' => 'file'],
            ['name' => 'database.sql', 'size' => '156.8 KB', 'modified' => '2024-12-21 18:30:00', 'type' => 'file']
        ];

        return view('hosting.files', compact('files'));
    }

    public function databases($id)
    {
        $databases = [
            ['name' => 'example_main', 'size' => '45.2 MB', 'tables' => 12, 'collation' => 'utf8mb4_unicode_ci'],
            ['name' => 'example_users', 'size' => '12.8 MB', 'tables' => 5, 'collation' => 'utf8mb4_unicode_ci'],
            ['name' => 'example_logs', 'size' => '234.5 MB', 'tables' => 8, 'collation' => 'utf8mb4_unicode_ci'],
            ['name' => 'example_cache', 'size' => '8.9 MB', 'tables' => 3, 'collation' => 'utf8mb4_unicode_ci']
        ];

        return view('hosting.databases', compact('databases'));
    }

    public function emails($id)
    {
        $emails = [
            ['address' => 'info@example.com', 'status' => 'active', 'quota_used' => '2.4 GB', 'quota_limit' => '5 GB'],
            ['address' => 'support@example.com', 'status' => 'active', 'quota_used' => '1.8 GB', 'quota_limit' => '5 GB'],
            ['address' => 'admin@example.com', 'status' => 'active', 'quota_used' => '4.2 GB', 'quota_limit' => '10 GB'],
            ['address' => 'sales@example.com', 'status' => 'forwarded', 'quota_used' => '0 GB', 'quota_limit' => '5 GB'],
            ['address' => 'billing@example.com', 'status' => 'disabled', 'quota_used' => '0 GB', 'quota_limit' => '5 GB']
        ];

        return view('hosting.emails', compact('emails'));
    }
}
