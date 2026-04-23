<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
          
            <span class="app-brand-text demo menu-text fw-bold ms-2">Server Panel</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Core Section -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Core</span></li>
        
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <!-- Client Management -->
        <li class="menu-item {{ request()->routeIs('clients*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div class="text-truncate">Client Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('clients.index') ? 'active' : '' }}">
                    <a href="{{ route('clients.index') }}" class="menu-link">
                        <div class="text-truncate">All Clients</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.create') ? 'active' : '' }}">
                    <a href="{{ route('clients.create') }}" class="menu-link">
                        <div class="text-truncate">Add Client</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.packages') ? 'active' : '' }}">
                    <a href="{{ route('clients.packages') }}" class="menu-link">
                        <div class="text-truncate">Client Packages</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.resource-limits') ? 'active' : '' }}">
                    <a href="{{ route('clients.resource-limits') }}" class="menu-link">
                        <div class="text-truncate">Resource Limits</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.disk-space') ? 'active' : '' }}">
                    <a href="{{ route('clients.disk-space') }}" class="menu-link">
                        <div class="text-truncate">Disk Space</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.bandwidth') ? 'active' : '' }}">
                    <a href="{{ route('clients.bandwidth') }}" class="menu-link">
                        <div class="text-truncate">Bandwidth</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.domains-limit') ? 'active' : '' }}">
                    <a href="{{ route('clients.domains-limit') }}" class="menu-link">
                        <div class="text-truncate">Domains Limit</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('clients.login-access') ? 'active' : '' }}">
                    <a href="{{ route('clients.login-access') }}" class="menu-link">
                        <div class="text-truncate">Client Login Access</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Server Management -->
        <li class="menu-item {{ request()->routeIs('servers*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-server"></i>
                <div class="text-truncate">Server Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('servers.index') ? 'active' : '' }}">
                    <a href="{{ route('servers.index') }}" class="menu-link">
                        <div class="text-truncate">All Servers</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.create') ? 'active' : '' }}">
                    <a href="{{ route('servers.create') }}" class="menu-link">
                        <div class="text-truncate">Add New Server</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.monitoring') ? 'active' : '' }}">
                    <a href="{{ route('servers.monitoring') }}" class="menu-link">
                        <div class="text-truncate">Server Monitoring</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.services') ? 'active' : '' }}">
                    <a href="{{ route('servers.services') }}" class="menu-link">
                        <div class="text-truncate">Services Management</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.webserver') ? 'active' : '' }}">
                    <a href="{{ route('servers.webserver') }}" class="menu-link">
                        <div class="text-truncate">Nginx / Apache</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.database') ? 'active' : '' }}">
                    <a href="{{ route('servers.database') }}" class="menu-link">
                        <div class="text-truncate">MySQL / MariaDB</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.phpfpm') ? 'active' : '' }}">
                    <a href="{{ route('servers.phpfpm') }}" class="menu-link">
                        <div class="text-truncate">PHP-FPM</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.ssh') ? 'active' : '' }}">
                    <a href="{{ route('servers.ssh') }}" class="menu-link">
                        <div class="text-truncate">SSH Access</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.firewall') ? 'active' : '' }}">
                    <a href="{{ route('servers.firewall') }}" class="menu-link">
                        <div class="text-truncate">Firewall (UFW)</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('servers.fail2ban') ? 'active' : '' }}">
                    <a href="{{ route('servers.fail2ban') }}" class="menu-link">
                        <div class="text-truncate">Fail2Ban Security</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Domain & DNS -->
        <li class="menu-item {{ request()->routeIs('domains*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-globe"></i>
                <div class="text-truncate">Domain & DNS</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('domains.index') ? 'active' : '' }}">
                    <a href="{{ route('domains.index') }}" class="menu-link">
                        <div class="text-truncate">All Domains</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.create') ? 'active' : '' }}">
                    <a href="{{ route('domains.create') }}" class="menu-link">
                        <div class="text-truncate">Add Domain</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.dns-management') ? 'active' : '' }}">
                    <a href="{{ route('domains.dns-management') }}" class="menu-link">
                        <div class="text-truncate">DNS Management</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.a-records') ? 'active' : '' }}">
                    <a href="{{ route('domains.a-records') }}" class="menu-link">
                        <div class="text-truncate">A Records</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.cname-records') ? 'active' : '' }}">
                    <a href="{{ route('domains.cname-records') }}" class="menu-link">
                        <div class="text-truncate">CNAME Records</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.mx-records') ? 'active' : '' }}">
                    <a href="{{ route('domains.mx-records') }}" class="menu-link">
                        <div class="text-truncate">MX Records</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.nameservers') ? 'active' : '' }}">
                    <a href="{{ route('domains.nameservers') }}" class="menu-link">
                        <div class="text-truncate">Nameservers</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('domains.ssl-certificates') ? 'active' : '' }}">
                    <a href="{{ route('domains.ssl-certificates') }}" class="menu-link">
                        <div class="text-truncate">SSL Certificates</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- File Manager -->
        <li class="menu-item {{ request()->routeIs('filemanager*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div class="text-truncate">File Manager</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('filemanager.index') ? 'active' : '' }}">
                    <a href="{{ route('filemanager.index') }}" class="menu-link">
                        <div class="text-truncate">File Manager</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('filemanager.git-deployment') ? 'active' : '' }}">
                    <a href="{{ route('filemanager.git-deployment') }}" class="menu-link">
                        <div class="text-truncate">Git Deployment</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('filemanager.environment-settings') ? 'active' : '' }}">
                    <a href="{{ route('filemanager.environment-settings') }}" class="menu-link">
                        <div class="text-truncate">Environment Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('filemanager.php-versions') ? 'active' : '' }}">
                    <a href="{{ route('filemanager.php-versions') }}" class="menu-link">
                        <div class="text-truncate">PHP Versions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('filemanager.staging-environment') ? 'active' : '' }}">
                    <a href="{{ route('filemanager.staging-environment') }}" class="menu-link">
                        <div class="text-truncate">Staging Environment</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Website Hosting -->
        <li class="menu-item {{ request()->routeIs('hosting*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cloud"></i>
                <div class="text-truncate">Website Hosting</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('hosting.index') ? 'active' : '' }}">
                    <a href="{{ route('hosting.index') }}" class="menu-link">
                        <div class="text-truncate">All Websites</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('hosting.create') ? 'active' : '' }}">
                    <a href="{{ route('hosting.create') }}" class="menu-link">
                        <div class="text-truncate">Create Website</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('hosting.file-manager') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">File Manager</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('hosting.git') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Git Deployment</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('hosting.environment') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Environment Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('hosting.php-versions') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">PHP Versions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('hosting.staging') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Staging Environment</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Email Management -->
        <li class="menu-item {{ request()->routeIs('email*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div class="text-truncate">Email Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('email.index') ? 'active' : '' }}">
                    <a href="{{ route('email.index') }}" class="menu-link">
                        <div class="text-truncate">Email Accounts</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('email.create') ? 'active' : '' }}">
                    <a href="{{ route('email.create') }}" class="menu-link">
                        <div class="text-truncate">Create Email</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('email.forwarders') ? 'active' : '' }}">
                    <a href="{{ route('email.forwarders') }}" class="menu-link">
                        <div class="text-truncate">Forwarders</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('email.auto-responders') ? 'active' : '' }}">
                    <a href="{{ route('email.auto-responders') }}" class="menu-link">
                        <div class="text-truncate">Auto Responders</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('email.spam-filter') ? 'active' : '' }}">
                    <a href="{{ route('email.spam-filter') }}" class="menu-link">
                        <div class="text-truncate">Spam Filter</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('email.webmail-access') ? 'active' : '' }}">
                    <a href="{{ route('email.webmail-access') }}" class="menu-link">
                        <div class="text-truncate">Webmail Access</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Database Management -->
        <li class="menu-item {{ request()->routeIs('database*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div class="text-truncate">Database Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('database.index') ? 'active' : '' }}">
                    <a href="{{ route('database.index') }}" class="menu-link">
                        <div class="text-truncate">All Databases</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('database.create') ? 'active' : '' }}">
                    <a href="{{ route('database.create') }}" class="menu-link">
                        <div class="text-truncate">Create Database</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('database.users') ? 'active' : '' }}">
                    <a href="{{ route('database.users') }}" class="menu-link">
                        <div class="text-truncate">Database Users</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('database.remote-access') ? 'active' : '' }}">
                    <a href="{{ route('database.remote-access') }}" class="menu-link">
                        <div class="text-truncate">Remote Access</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('database.phpmyadmin') ? 'active' : '' }}">
                    <a href="{{ route('database.phpmyadmin') }}" class="menu-link">
                        <div class="text-truncate">phpMyAdmin</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Plans & Billing -->
        <li class="menu-item {{ request()->routeIs('billing*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div class="text-truncate">Plans & Billing</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('billing.plans') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Hosting Plans</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('billing.subscriptions') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Subscriptions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('billing.invoices') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Invoices</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('billing.transactions') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Transactions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('billing.payments') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate">Payment Methods</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('billing.payments.mpesa') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">M-Pesa</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('billing.payments.bank') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">Bank Transfer</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- System Section -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">System</span></li>
        
        <!-- Monitoring & Logs -->
        <li class="menu-item {{ request()->routeIs('monitoring*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                <div class="text-truncate">Monitoring & Logs</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('monitoring.logs') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate">Server Logs</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('monitoring.logs.website') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">Website Logs</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('monitoring.logs.error') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">Error Logs</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('monitoring.logs.access') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">Access Logs</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ request()->routeIs('monitoring.traffic') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Live Traffic Monitor</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('monitoring.alerts') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Alerts & Notifications</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Security Center -->
        <li class="menu-item {{ request()->routeIs('security*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield"></i>
                <div class="text-truncate">Security Center</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('security.firewall') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Firewall Rules</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('security.ip') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate">IP Management</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('security.ip.whitelist') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">IP Whitelist</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('security.ip.blacklist') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">IP Blacklist</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ request()->routeIs('security.ssl') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">SSL Status</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('security.malware') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Malware Scanner</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('security.backup') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Backup Security</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('security.activity') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Login Activity</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Backup & Restore -->
        <li class="menu-item {{ request()->routeIs('backup*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cloud-download"></i>
                <div class="text-truncate">Backup & Restore</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('backup.settings') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Backup Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('backup.manual') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Manual Backup</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('backup.scheduled') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Scheduled Backups</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('backup.restore') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Restore Backup</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('backup.storage') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Backup Storage</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Automation & Tools -->
        <li class="menu-item {{ request()->routeIs('automation*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-bot"></i>
                <div class="text-truncate">Automation & Tools</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('automation.cron') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Cron Jobs</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('automation.queue') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Queue Jobs</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('automation.scheduler') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Task Scheduler</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('automation.installer') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div class="text-truncate">One-Click Installer</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('automation.installer.wordpress') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">WordPress</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('automation.installer.laravel') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">Laravel</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('automation.installer.nodejs') ? 'active' : '' }}">
                            <a href="#" class="menu-link">
                                <div class="text-truncate">Node.js App</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- API & Integrations -->
        <li class="menu-item {{ request()->routeIs('api*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-plug"></i>
                <div class="text-truncate">API & Integrations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('api.keys') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">API Keys</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('api.webhooks') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Webhooks</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('api.cloudflare') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Cloudflare Integration</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('api.github') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">GitHub Integration</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('api.smtp') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">SMTP Settings</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- System Health -->
        <li class="menu-item {{ request()->routeIs('health*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-heart"></i>
                <div class="text-truncate">System Health</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('health.status') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">System Status</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('health.trends') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Resource Usage Trends</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('health.services') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Service Health Check</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('health.uptime') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Uptime Monitoring</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('health.optimization') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Performance Optimization</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Settings Section -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Settings</span></li>
        
        <!-- System Settings -->
        <li class="menu-item {{ request()->routeIs('system-settings*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div class="text-truncate">System Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('system-settings.general') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">General Settings</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.company') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Company Info</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.timezone') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Timezone & Locale</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.email') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Email Configuration</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.branding') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Branding</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('system-settings.updates') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">System Updates</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- User & Role Management -->
        <li class="menu-item {{ request()->routeIs('users*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate">User & Role Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('users.all') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Users</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('users.roles') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Roles & Permissions</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('users.activity') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Activity Logs</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('users.2fa') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Two-Factor Authentication</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Support & Helpdesk -->
        <li class="menu-item {{ request()->routeIs('support*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div class="text-truncate">Support & Helpdesk</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('support.tickets') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Support Tickets</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('support.open') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Open Ticket</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('support.knowledge') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">Knowledge Base</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('support.faq') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div class="text-truncate">FAQs</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Logout -->
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div class="text-truncate">Logout</div>
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        </ul>
</aside>
<!-- / Menu -->
