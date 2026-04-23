<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index()
    {
        $domains = [
            [
                'id' => 1,
                'domain' => 'example.com',
                'status' => 'active',
                'expiry_date' => '2025-03-15',
                'registrar' => 'GoDaddy',
                'nameservers' => ['ns1.example.com', 'ns2.example.com'],
                'ssl_status' => 'active',
                'ssl_expiry' => '2025-01-20',
                'dns_records' => 12,
                'auto_renew' => true,
                'created_at' => '2022-03-15'
            ],
            [
                'id' => 2,
                'domain' => 'myapp.net',
                'status' => 'active',
                'expiry_date' => '2024-12-31',
                'registrar' => 'Namecheap',
                'nameservers' => ['ns1.myapp.net', 'ns2.myapp.net'],
                'ssl_status' => 'expired',
                'ssl_expiry' => '2024-11-15',
                'dns_records' => 8,
                'auto_renew' => false,
                'created_at' => '2021-12-31'
            ],
            [
                'id' => 3,
                'domain' => 'techblog.org',
                'status' => 'pending',
                'expiry_date' => '2025-06-20',
                'registrar' => 'Cloudflare',
                'nameservers' => ['ns1.cloudflare.com', 'ns2.cloudflare.com'],
                'ssl_status' => 'none',
                'ssl_expiry' => null,
                'dns_records' => 6,
                'auto_renew' => true,
                'created_at' => '2023-06-20'
            ],
            [
                'id' => 4,
                'domain' => 'business-site.io',
                'status' => 'active',
                'expiry_date' => '2024-10-10',
                'registrar' => 'Google Domains',
                'nameservers' => ['ns1.google.com', 'ns2.google.com'],
                'ssl_status' => 'active',
                'ssl_expiry' => '2025-02-10',
                'dns_records' => 15,
                'auto_renew' => true,
                'created_at' => '2020-10-10'
            ],
            [
                'id' => 5,
                'domain' => 'portfolio.dev',
                'status' => 'expired',
                'expiry_date' => '2024-08-05',
                'registrar' => 'Porkbun',
                'nameservers' => ['ns1.porkbun.com', 'ns2.porkbun.com'],
                'ssl_status' => 'none',
                'ssl_expiry' => null,
                'dns_records' => 4,
                'auto_renew' => false,
                'created_at' => '2023-08-05'
            ]
        ];

        return view('domains.index', compact('domains'));
    }

    public function create()
    {
        return view('domains.create');
    }

    public function show($id)
    {
        $domain = [
            'id' => $id,
            'domain' => 'example.com',
            'status' => 'active',
            'expiry_date' => '2025-03-15',
            'registrar' => 'GoDaddy',
            'nameservers' => ['ns1.example.com', 'ns2.example.com'],
            'ssl_status' => 'active',
            'ssl_expiry' => '2025-01-20',
            'dns_records' => 12,
            'auto_renew' => true,
            'created_at' => '2022-03-15',
            'whois' => [
                'registrant' => 'John Doe',
                'email' => 'admin@example.com',
                'phone' => '+1-555-0123',
                'address' => '123 Main St, City, State 12345',
                'country' => 'United States'
            ],
            'dns_entries' => [
                ['type' => 'A', 'name' => '@', 'value' => '192.168.1.10', 'ttl' => 3600],
                ['type' => 'A', 'name' => 'www', 'value' => '192.168.1.10', 'ttl' => 3600],
                ['type' => 'CNAME', 'name' => 'mail', 'value' => 'mail.example.com', 'ttl' => 3600],
                ['type' => 'MX', 'name' => '@', 'value' => 'mail.example.com', 'priority' => 10, 'ttl' => 3600],
                ['type' => 'TXT', 'name' => '@', 'value' => 'v=spf1 include:_spf.google.com ~all', 'ttl' => 3600],
                ['type' => 'TXT', 'name' => '_dmarc', 'value' => 'v=DMARC1; p=quarantine; rua=mailto:dmarc@example.com', 'ttl' => 3600]
            ]
        ];

        return view('domains.show', compact('domain'));
    }

    public function edit($id)
    {
        $domain = [
            'id' => $id,
            'domain' => 'example.com',
            'status' => 'active',
            'expiry_date' => '2025-03-15',
            'registrar' => 'GoDaddy',
            'nameservers' => ['ns1.example.com', 'ns2.example.com'],
            'auto_renew' => true,
            'dnssec_enabled' => true,
            'privacy_protection' => true,
            'transfer_lock' => true
        ];

        return view('domains.edit', compact('domain'));
    }

    public function dns($id)
    {
        $dnsEntries = [
            ['id' => 1, 'type' => 'A', 'name' => '@', 'value' => '192.168.1.10', 'ttl' => 3600, 'status' => 'active'],
            ['id' => 2, 'type' => 'A', 'name' => 'www', 'value' => '192.168.1.10', 'ttl' => 3600, 'status' => 'active'],
            ['id' => 3, 'type' => 'CNAME', 'name' => 'mail', 'value' => 'mail.example.com', 'ttl' => 3600, 'status' => 'active'],
            ['id' => 4, 'type' => 'MX', 'name' => '@', 'value' => 'mail.example.com', 'priority' => 10, 'ttl' => 3600, 'status' => 'active'],
            ['id' => 5, 'type' => 'TXT', 'name' => '@', 'value' => 'v=spf1 include:_spf.google.com ~all', 'ttl' => 3600, 'status' => 'active'],
            ['id' => 6, 'type' => 'TXT', 'name' => '_dmarc', 'value' => 'v=DMARC1; p=quarantine; rua=mailto:dmarc@example.com', 'ttl' => 3600, 'status' => 'active'],
            ['id' => 7, 'type' => 'NS', 'name' => '@', 'value' => 'ns1.example.com', 'ttl' => 86400, 'status' => 'active'],
            ['id' => 8, 'type' => 'NS', 'name' => '@', 'value' => 'ns2.example.com', 'ttl' => 86400, 'status' => 'active'],
            ['id' => 9, 'type' => 'SRV', 'name' => '_sip._tcp', 'value' => 'sip.example.com 5060', 'priority' => 10, 'weight' => 5, 'ttl' => 3600, 'status' => 'active'],
            ['id' => 10, 'type' => 'CAA', 'name' => '@', 'value' => 'letsencrypt.org', 'flags' => 0, 'tag' => 'issue', 'ttl' => 3600, 'status' => 'active']
        ];

        return view('domains.dns', compact('dnsEntries'));
    }

    public function ssl($id)
    {
        $sslCertificates = [
            [
                'id' => 1,
                'domain' => 'example.com',
                'status' => 'active',
                'issuer' => 'Let\'s Encrypt',
                'issued_date' => '2024-01-20',
                'expiry_date' => '2025-01-20',
                'days_until_expiry' => 30,
                'auto_renew' => true
            ]
        ];

        return view('domains.ssl', compact('ssl'));
    }

    public function dnsManagement()
    {
        $domains = [
            ['name' => 'example.com', 'records' => 12, 'status' => 'active'],
            ['name' => 'mydomain.net', 'records' => 8, 'status' => 'active'],
            ['name' => 'test.org', 'records' => 6, 'status' => 'pending'],
            ['name' => 'site.co', 'records' => 10, 'status' => 'active'],
            ['name' => 'app.io', 'records' => 9, 'status' => 'active']
        ];

        return view('domains.dns-management', compact('domains'));
    }

    public function aRecords()
    {
        $records = [
            ['domain' => 'example.com', 'name' => '@', 'ip' => '192.168.1.100', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'example.com', 'name' => 'www', 'ip' => '192.168.1.100', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'example.com', 'name' => 'api', 'ip' => '192.168.1.101', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'mydomain.net', 'name' => '@', 'ip' => '192.168.1.102', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'mydomain.net', 'name' => 'mail', 'ip' => '192.168.1.103', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'test.org', 'name' => '@', 'ip' => '192.168.1.104', 'ttl' => '3600', 'status' => 'pending'],
            ['domain' => 'site.co', 'name' => '@', 'ip' => '192.168.1.105', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'site.co', 'name' => 'cdn', 'ip' => '192.168.1.106', 'ttl' => '3600', 'status' => 'active']
        ];

        return view('domains.a-records', compact('records'));
    }

    public function cnameRecords()
    {
        $records = [
            ['domain' => 'example.com', 'name' => 'blog', 'target' => 'wordpress.example.com', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'example.com', 'name' => 'shop', 'target' => 'store.example.com', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'mydomain.net', 'name' => 'mail', 'target' => 'google.com', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'test.org', 'name' => 'www', 'target' => 'test.org', 'ttl' => '3600', 'status' => 'pending'],
            ['domain' => 'site.co', 'name' => 'support', 'target' => 'helpdesk.site.co', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'app.io', 'name' => 'api', 'target' => 'backend.app.io', 'ttl' => '3600', 'status' => 'active']
        ];

        return view('domains.cname-records', compact('records'));
    }

    public function mxRecords()
    {
        $records = [
            ['domain' => 'example.com', 'name' => '@', 'mail_server' => 'mail.example.com', 'priority' => '10', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'example.com', 'name' => '@', 'mail_server' => 'backup.example.com', 'priority' => '20', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'mydomain.net', 'name' => '@', 'mail_server' => 'mail.mydomain.net', 'priority' => '10', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'test.org', 'name' => '@', 'mail_server' => 'test.org', 'priority' => '10', 'ttl' => '3600', 'status' => 'pending'],
            ['domain' => 'site.co', 'name' => '@', 'mail_server' => 'mail.site.co', 'priority' => '10', 'ttl' => '3600', 'status' => 'active'],
            ['domain' => 'app.io', 'name' => '@', 'mail_server' => 'mail.app.io', 'priority' => '10', 'ttl' => '3600', 'status' => 'active']
        ];

        return view('domains.mx-records', compact('records'));
    }

    public function nameservers()
    {
        $domains = [
            [
                'name' => 'example.com',
                'nameservers' => [
                    ['server' => 'ns1.example.com', 'ip' => '192.168.1.100', 'status' => 'active'],
                    ['server' => 'ns2.example.com', 'ip' => '192.168.1.101', 'status' => 'active']
                ],
                'status' => 'active'
            ],
            [
                'name' => 'mydomain.net',
                'nameservers' => [
                    ['server' => 'ns1.mydomain.net', 'ip' => '192.168.1.102', 'status' => 'active'],
                    ['server' => 'ns2.mydomain.net', 'ip' => '192.168.1.103', 'status' => 'active']
                ],
                'status' => 'active'
            ],
            [
                'name' => 'test.org',
                'nameservers' => [
                    ['server' => 'ns1.test.org', 'ip' => '192.168.1.104', 'status' => 'pending'],
                    ['server' => 'ns2.test.org', 'ip' => '192.168.1.105', 'status' => 'pending']
                ],
                'status' => 'pending'
            ],
            [
                'name' => 'site.co',
                'nameservers' => [
                    ['server' => 'ns1.site.co', 'ip' => '192.168.1.106', 'status' => 'active'],
                    ['server' => 'ns2.site.co', 'ip' => '192.168.1.107', 'status' => 'active']
                ],
                'status' => 'active'
            ],
            [
                'name' => 'app.io',
                'nameservers' => [
                    ['server' => 'ns1.app.io', 'ip' => '192.168.1.108', 'status' => 'active'],
                    ['server' => 'ns2.app.io', 'ip' => '192.168.1.109', 'status' => 'active']
                ],
                'status' => 'active'
            ]
        ];

        return view('domains.nameservers', compact('domains'));
    }

    public function sslCertificates()
    {
        $certificates = [
            [
                'domain' => 'example.com',
                'status' => 'active',
                'issuer' => 'Let\'s Encrypt',
                'valid_from' => '2024-11-22',
                'valid_until' => '2025-02-20',
                'days_remaining' => 60,
                'auto_renew' => true,
                'protocol' => 'TLSv1.3'
            ],
            [
                'domain' => 'mydomain.net',
                'status' => 'active',
                'issuer' => 'Let\'s Encrypt',
                'valid_from' => '2024-12-01',
                'valid_until' => '2025-03-01',
                'days_remaining' => 69,
                'auto_renew' => true,
                'protocol' => 'TLSv1.3'
            ],
            [
                'domain' => 'test.org',
                'status' => 'pending',
                'issuer' => 'Let\'s Encrypt',
                'valid_from' => '2024-12-20',
                'valid_until' => '2025-03-20',
                'days_remaining' => 88,
                'auto_renew' => false,
                'protocol' => 'TLSv1.2'
            ],
            [
                'domain' => 'site.co',
                'status' => 'active',
                'issuer' => 'DigiCert',
                'valid_from' => '2024-10-15',
                'valid_until' => '2025-10-15',
                'days_remaining' => 298,
                'auto_renew' => true,
                'protocol' => 'TLSv1.3'
            ],
            [
                'domain' => 'app.io',
                'status' => 'expired',
                'issuer' => 'Let\'s Encrypt',
                'valid_from' => '2024-09-20',
                'valid_until' => '2024-12-20',
                'days_remaining' => -3,
                'auto_renew' => false,
                'protocol' => 'TLSv1.2'
            ]
        ];

        return view('domains.ssl-certificates', compact('certificates'));
    }
}
