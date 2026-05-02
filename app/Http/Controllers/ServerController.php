<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Services\ServerManagementService;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    protected $serverService;

    public function __construct(ServerManagementService $serverService)
    {
        $this->serverService = $serverService;
    }

    public function index()
    {
        $servers = $this->serverService->getAllServers();
        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'os_type' => 'nullable|string|max:50',
            'os_version' => 'nullable|string|max:50',
            'cpu_cores' => 'nullable|string|max:50',
            'memory' => 'nullable|string|max:50',
            'disk_space' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $server = $this->serverService->createServer($validated);
        return redirect()->route('servers.index')->with('success', 'Server created successfully!');
    }

    public function show($id)
    {
        $server = $this->serverService->getServer($id);
        $monitoringData = $this->serverService->getServerMonitoringData($id);
        
        return view('servers.show', compact('server', 'monitoringData'));
    }

    public function edit($id)
    {
        $server = $this->serverService->getServer($id);
        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hostname' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'os_type' => 'nullable|string|max:50',
            'os_version' => 'nullable|string|max:50',
            'cpu_cores' => 'nullable|string|max:50',
            'memory' => 'nullable|string|max:50',
            'disk_space' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $server = $this->serverService->updateServer($id, $validated);
        return redirect()->route('servers.index')->with('success', 'Server updated successfully!');
    }

    public function destroy($id)
    {
        $this->serverService->deleteServer($id);
        return redirect()->route('servers.index')->with('success', 'Server deleted successfully!');
    }

    public function performance($id)
    {
        $server = $this->serverService->getServer($id);
        $monitoringData = $this->serverService->getServerMonitoringData($id);
        
        // Generate mock historical data for charts
        $performanceData = [
            'cpu_history' => [45, 48, 42, 50, 47, 45, 43, 46, 44, 45],
            'memory_history' => [68, 70, 65, 72, 69, 68, 66, 67, 68, 68],
            'disk_history' => [72, 72, 73, 72, 72, 71, 72, 72, 72, 72],
            'network_history' => [120, 150, 180, 140, 160, 130, 170, 145, 155, 142]
        ];

        return view('servers.performance', compact('server', 'monitoringData', 'performanceData'));
    }

    public function logs($id)
    {
        $server = $this->serverService->getServer($id);
        
        // Get system logs (mock for now, can be enhanced with real log retrieval)
        $logs = [
            ['timestamp' => now()->subMinutes(30)->format('Y-m-d H:i:s'), 'level' => 'info', 'message' => 'System backup completed successfully', 'source' => 'backup'],
            ['timestamp' => now()->subMinutes(45)->format('Y-m-d H:i:s'), 'level' => 'warning', 'message' => 'High memory usage detected: 85%', 'source' => 'monitor'],
            ['timestamp' => now()->subHour()->format('Y-m-d H:i:s'), 'level' => 'info', 'message' => 'Apache service restarted', 'source' => 'system'],
            ['timestamp' => now()->subHours(2)->format('Y-m-d H:i:s'), 'level' => 'error', 'message' => 'Failed to connect to database', 'source' => 'application'],
            ['timestamp' => now()->subHours(3)->format('Y-m-d H:i:s'), 'level' => 'info', 'message' => 'Security scan completed', 'source' => 'security']
        ];

        return view('servers.logs', compact('server', 'logs'));
    }

    public function monitoring()
    {
        $servers = $this->serverService->getAllServers();
        
        // Generate alerts based on server status
        $alerts = [];
        foreach ($servers as $server) {
            if ($server->status === 'offline') {
                $alerts[] = [
                    'server' => $server->name,
                    'type' => 'error',
                    'message' => 'Server is offline',
                    'time' => $server->last_checked ? $server->last_checked->format('H:i:s') : 'Unknown'
                ];
            } elseif ($server->disk_usage > 90) {
                $alerts[] = [
                    'server' => $server->name,
                    'type' => 'warning',
                    'message' => 'Disk usage above 90%',
                    'time' => $server->last_checked ? $server->last_checked->format('H:i:s') : 'Unknown'
                ];
            } elseif ($server->cpu_usage > 80) {
                $alerts[] = [
                    'server' => $server->name,
                    'type' => 'info',
                    'message' => 'High CPU usage detected',
                    'time' => $server->last_checked ? $server->last_checked->format('H:i:s') : 'Unknown'
                ];
            }
        }
        
        return view('servers.monitoring', compact('servers', 'alerts'));
    }

    public function services()
    {
        $servers = $this->serverService->getAllServers();
        
        // Collect all services from all servers
        $allServices = [];
        foreach ($servers as $server) {
            $services = $server->services ?? [];
            foreach ($services as $serviceName => $status) {
                $allServices[] = [
                    'name' => ucfirst($serviceName),
                    'type' => $this->getServiceType($serviceName),
                    'status' => $status,
                    'port' => $this->getServicePort($serviceName),
                    'cpu_usage' => $server->cpu_usage ? ($server->cpu_usage * 0.1) : rand(0, 20) + (rand(0, 10) / 10),
                    'memory_usage' => $server->memory_usage ? ($server->memory_usage * 0.1) : rand(0, 30) + (rand(0, 10) / 10),
                    'uptime' => $server->status === 'online' ? '45 days' : '0 days',
                    'server_id' => $server->id,
                    'server_name' => $server->name
                ];
            }
        }

        return view('servers.services', compact('servers', 'allServices'));
    }

    private function getServiceType($service)
    {
        $types = [
            'nginx' => 'web',
            'apache' => 'web',
            'mysql' => 'database',
            'mariadb' => 'database',
            'php-fpm' => 'php',
            'ssh' => 'system',
            'ufw' => 'security',
            'fail2ban' => 'security'
        ];
        
        return $types[$service] ?? 'system';
    }

    private function getServicePort($service)
    {
        $ports = [
            'nginx' => 80,
            'apache' => 80,
            'mysql' => 3306,
            'mariadb' => 3306,
            'php-fpm' => 9000,
            'ssh' => 22,
            'ufw' => null,
            'fail2ban' => null
        ];
        
        return $ports[strtolower($service)] ?? null;
    }

    public function webserver()
    {
        $webserver_config = [
            'type' => 'Apache',
            'version' => '2.4.58',
            'status' => 'running',
            'port' => 80,
            'ssl_port' => 443,
            'workers' => 4,
            'max_connections' => 150,
            'active_connections' => 45,
            'requests_per_second' => 234,
            'virtual_hosts' => 12,
            'modules_enabled' => ['rewrite', 'ssl', 'deflate', 'headers', 'expires'],
            'log_files' => [
                ['name' => 'access.log', 'size' => '245.6 MB', 'last_modified' => '2024-12-22 14:30:00'],
                ['name' => 'error.log', 'size' => '12.4 MB', 'last_modified' => '2024-12-22 14:15:00'],
                ['name' => 'ssl_access.log', 'size' => '89.7 MB', 'last_modified' => '2024-12-22 14:00:00']
            ]
        ];

        return view('servers.webserver', compact('webserver_config'));
    }

    public function database()
    {
        $servers = $this->serverService->getAllServers();
        
        // Filter servers that have database services (mysql/mariadb)
        $databaseServers = $servers->filter(function($server) {
            $services = $server->services ?? [];
            return isset($services['mysql']) || isset($services['mariadb']);
        });
        
        // Collect all databases from all database servers
        $allDatabases = [];
        foreach ($databaseServers as $server) {
            $dbCount = $server->database_count ?? rand(3, 15);
            for ($i = 0; $i < $dbCount; $i++) {
                $allDatabases[] = [
                    'name' => $this->generateDatabaseName($server->name, $i),
                    'server_id' => $server->id,
                    'server_name' => $server->name,
                    'size' => $this->generateDatabaseSize(),
                    'tables' => rand(1, 50),
                    'engine' => 'InnoDB',
                    'collation' => 'utf8mb4_unicode_ci'
                ];
            }
        }
        
        // Calculate statistics
        $totalDatabases = count($allDatabases);
        $totalConnections = $databaseServers->sum(function($server) {
            return $server->active_connections ?? rand(5, 25);
        });
        $avgQueriesPerSecond = $databaseServers->avg(function($server) {
            return $server->queries_per_second ?? (rand(10, 100) / 10);
        });

        return view('servers.database', compact('servers', 'databaseServers', 'allDatabases', 'totalDatabases', 'totalConnections', 'avgQueriesPerSecond'));
    }

    private function generateDatabaseName($serverName, $index)
    {
        $prefixes = ['app', 'user', 'log', 'cache', 'session', 'config', 'data', 'temp', 'backup', 'test'];
        $prefix = $prefixes[$index % count($prefixes)];
        $suffix = $index > 0 ? '_' . ($index + 1) : '';
        return strtolower($serverName) . '_' . $prefix . $suffix;
    }

    private function generateDatabaseSize()
    {
        $sizes = ['12.3 MB', '45.7 MB', '128.9 MB', '234.5 MB', '512.1 MB', '1.2 GB', '2.8 GB'];
        return $sizes[array_rand($sizes)];
    }

    public function phpfpm()
    {
        $servers = $this->serverService->getAllServers();
        
        // Filter servers that have PHP-FPM services
        $phpfpmservers = $servers->filter(function($server) {
            $services = $server->services ?? [];
            return isset($services['php-fpm']);
        });
        
        // Collect all PHP-FPM pools from all servers
        $allPools = [];
        foreach ($phpfpmservers as $server) {
            $poolCount = $server->phpfpm_pools ?? rand(1, 3);
            for ($i = 0; $i < $poolCount; $i++) {
                $allPools[] = [
                    'name' => $this->generatePoolName($server->name, $i),
                    'server_id' => $server->id,
                    'server_name' => $server->name,
                    'status' => $server->status === 'online' ? 'active' : 'inactive',
                    'processes' => rand(5, 15),
                    'max_children' => $server->max_children ?? 50,
                    'version' => $server->php_version ?? '8.2.12',
                    'owner' => 'www-data'
                ];
            }
        }
        
        // Calculate statistics
        $totalActiveProcesses = $phpfpmservers->sum(function($server) {
            return $server->active_processes ?? rand(5, 15);
        });
        $avgRequestsPerSecond = $phpfpmservers->avg(function($server) {
            return $server->requests_per_second ?? (rand(50, 200) / 10);
        });
        $avgMemoryUsage = $phpfpmservers->avg(function($server) {
            return $server->memory_usage ?? rand(20, 60);
        });

        return view('servers.phpfpm', compact('servers', 'phpfpmservers', 'allPools', 'totalActiveProcesses', 'avgRequestsPerSecond', 'avgMemoryUsage'));
    }

    private function generatePoolName($serverName, $index)
    {
        $poolNames = ['www', 'api', 'admin', 'cli', 'backend', 'frontend'];
        return $poolNames[$index % count($poolNames)];
    }

    public function ssh()
    {
        $servers = $this->serverService->getAllServers();
        
        // Filter servers that have SSH services
        $sshServers = $servers->filter(function($server) {
            $services = $server->services ?? [];
            return isset($services['ssh']);
        });
        
        // Collect all SSH keys from all servers
        $allSSHKeys = [];
        foreach ($sshServers as $server) {
            $keyCount = $server->ssh_keys ?? rand(2, 5);
            for ($i = 0; $i < $keyCount; $i++) {
                $allSSHKeys[] = [
                    'id' => 'key_' . $server->id . '_' . $i,
                    'name' => $this->generateSSHKeyName($server->name, $i),
                    'user' => $this->generateSSHUser(),
                    'fingerprint' => $this->generateSSHKeyFingerprint(),
                    'type' => $this->generateSSHKeyType(),
                    'size' => $this->generateSSHKeySize(),
                    'created' => $this->generateSSHKeyDate(),
                    'last_used' => $this->generateSSHKeyDate(),
                    'status' => 'active',
                    'server_id' => $server->id,
                    'server_name' => $server->name
                ];
            }
        }
        
        // Calculate statistics
        $totalActiveConnections = $sshServers->sum(function($server) {
            return $server->active_connections ?? rand(1, 5);
        });
        $totalSSHKeys = count($allSSHKeys);
        $avgSecurityScore = $sshServers->avg(function($server) {
            return $server->security_score ?? rand(70, 95);
        });

        return view('servers.ssh', compact('servers', 'sshServers', 'allSSHKeys', 'totalActiveConnections', 'totalSSHKeys', 'avgSecurityScore'));
    }

    private function generateSSHKeyName($serverName, $index)
    {
        $keyNames = ['admin_key', 'deploy_key', 'backup_key', 'user_key', 'service_key'];
        return $keyNames[$index % count($keyNames)];
    }

    private function generateSSHUser()
    {
        $users = ['root', 'admin', 'deploy', 'user', 'service'];
        return $users[array_rand($users)];
    }

    private function generateSSHKeyFingerprint()
    {
        return 'SHA256:' . substr(str_shuffle('0123456789abcdef'), 0, 16) . '...';
    }

    private function generateSSHKeyType()
    {
        $types = ['RSA', 'ED25519', 'ECDSA'];
        return $types[array_rand($types)];
    }

    private function generateSSHKeySize()
    {
        $sizes = ['2048', '4096', '256', '384', '521'];
        return $sizes[array_rand($sizes)];
    }

    private function generateSSHKeyDate()
    {
        $days = rand(1, 365);
        return date('Y-m-d H:i:s', strtotime("-{$days} days"));
    }

    public function firewall()
    {
        $servers = $this->serverService->getAllServers();
        
        // Filter servers that have firewall services
        $firewallServers = $servers->filter(function($server) {
            $services = $server->services ?? [];
            return isset($services['firewall']);
        });
        
        // Collect all firewall rules from all servers
        $allFirewallRules = [];
        foreach ($firewallServers as $server) {
            $ruleCount = $server->firewall_rules ?? rand(5, 15);
            for ($i = 0; $i < $ruleCount; $i++) {
                $allFirewallRules[] = [
                    'id' => 'rule_' . $server->id . '_' . $i,
                    'name' => $this->generateFirewallRuleName($server->name, $i),
                    'description' => $this->generateFirewallRuleDescription($i),
                    'action' => $this->generateFirewallRuleAction(),
                    'protocol' => $this->generateFirewallRuleProtocol(),
                    'source' => $this->generateFirewallRuleSource(),
                    'destination' => $this->generateFirewallRuleDestination(),
                    'port' => $this->generateFirewallRulePort(),
                    'interface' => $this->generateFirewallRuleInterface(),
                    'status' => 'active',
                    'server_id' => $server->id,
                    'server_name' => $server->name
                ];
            }
        }
        
        // Calculate statistics
        $activeFirewalls = $firewallServers->filter(function($server) {
            return ($server->firewall_status ?? 'active') === 'active';
        })->count();
        $totalRules = count($allFirewallRules);
        $totalBlockedConnections = $firewallServers->sum(function($server) {
            return $server->blocked_connections ?? rand(10, 100);
        });

        return view('servers.firewall', compact('servers', 'firewallServers', 'allFirewallRules', 'activeFirewalls', 'totalRules', 'totalBlockedConnections'));
    }

    private function generateFirewallRuleName($serverName, $index)
    {
        $ruleNames = ['SSH Access', 'HTTP/HTTPS', 'Database Access', 'Email Services', 'FTP Access', 'Custom Rule'];
        return $ruleNames[$index % count($ruleNames)];
    }

    private function generateFirewallRuleDescription($index)
    {
        $descriptions = [
            'Allow SSH access from anywhere',
            'Allow HTTP and HTTPS traffic',
            'Allow database connections',
            'Allow email server traffic',
            'Allow FTP file transfers',
            'Custom firewall rule'
        ];
        return $descriptions[$index % count($descriptions)];
    }

    private function generateFirewallRuleAction()
    {
        $actions = ['allow', 'deny', 'reject', 'limit'];
        return $actions[array_rand($actions)];
    }

    private function generateFirewallRuleProtocol()
    {
        $protocols = ['tcp', 'udp', 'icmp', 'any'];
        return $protocols[array_rand($protocols)];
    }

    private function generateFirewallRuleSource()
    {
        $sources = ['any', '0.0.0.0/0', '192.168.1.0/24', '10.0.0.0/8', '172.16.0.0/12'];
        return $sources[array_rand($sources)];
    }

    private function generateFirewallRuleDestination()
    {
        $destinations = ['any', '0.0.0.0/0', '192.168.1.1', '10.0.0.1', '127.0.0.1'];
        return $destinations[array_rand($destinations)];
    }

    private function generateFirewallRulePort()
    {
        $ports = ['22', '80', '443', '3306', '25,587', '21', 'any', '8080-8090'];
        return $ports[array_rand($ports)];
    }

    private function generateFirewallRuleInterface()
    {
        $interfaces = ['eth0', 'wlan0', 'any', 'lo', 'docker0'];
        return $interfaces[array_rand($interfaces)];
    }

    public function fail2ban()
    {
        $servers = $this->serverService->getAllServers();
        
        // Filter servers that have Fail2Ban services
        $fail2banServers = $servers->filter(function($server) {
            $services = $server->services ?? [];
            return isset($services['fail2ban']);
        });
        
        // Collect all Fail2Ban jails from all servers
        $allJails = [];
        foreach ($fail2banServers as $server) {
            $jailCount = $server->active_jails ?? rand(3, 8);
            for ($i = 0; $i < $jailCount; $i++) {
                $allJails[] = [
                    'id' => 'jail_' . $server->id . '_' . $i,
                    'name' => $this->generateJailName($server->name, $i),
                    'description' => $this->generateJailDescription($i),
                    'enabled' => (bool)rand(0, 1),
                    'banned' => rand(0, 20),
                    'max_retry' => rand(3, 6),
                    'find_time' => $this->generateJailTime(),
                    'bantime' => $this->generateJailTime(),
                    'server_id' => $server->id,
                    'server_name' => $server->name
                ];
            }
        }
        
        // Calculate statistics
        $activeServices = $fail2banServers->filter(function($server) {
            return ($server->fail2ban_status ?? 'running') === 'running';
        })->count();
        $totalJails = count($allJails);
        $totalBanned = array_sum(array_column($allJails, 'banned'));

        return view('servers.fail2ban', compact('servers', 'fail2banServers', 'allJails', 'activeServices', 'totalJails', 'totalBanned'));
    }

    private function generateJailName($serverName, $index)
    {
        $jailNames = ['sshd', 'apache', 'nginx', 'mysql', 'postfix', 'vsftpd', 'pure-ftpd', 'recidive'];
        return $jailNames[$index % count($jailNames)];
    }

    private function generateJailDescription($index)
    {
        $descriptions = [
            'SSH authentication failure protection',
            'Apache web server protection',
            'Nginx web server protection',
            'MySQL database protection',
            'Postfix mail server protection',
            'FTP server protection',
            'Pure-FTPd server protection',
            'Recidive jail for repeat offenders'
        ];
        return $descriptions[$index % count($descriptions)];
    }

    private function generateJailTime()
    {
        $times = ['10m', '1h', '6h', '1d', '1w'];
        return $times[array_rand($times)];
    }
}
