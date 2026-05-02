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
                    'status' => $status,
                    'port' => $this->getServicePort($serviceName),
                    'cpu' => rand(0, 20) + (rand(0, 10) / 10),
                    'memory' => rand(0, 30) + (rand(0, 10) / 10),
                    'uptime' => $server->isOnline() ? '45 days' : '0 days',
                    'server' => $server->name
                ];
            }
        }

        return view('servers.services', compact('allServices'));
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
        $db_config = [
            'type' => 'MySQL',
            'version' => '8.0.35',
            'status' => 'running',
            'port' => 3306,
            'uptime' => '45 days',
            'connections' => ['active' => 12, 'max' => 100, 'total' => 1247],
            'queries' => ['per_second' => 45.2, 'slow_queries' => 3, 'total_queries' => 567890],
            'databases' => [
                ['name' => 'example_main', 'size' => '45.2 MB', 'tables' => 12],
                ['name' => 'example_logs', 'size' => '234.5 MB', 'tables' => 8],
                ['name' => 'example_cache', 'size' => '8.9 MB', 'tables' => 3]
            ],
            'performance' => [
                'buffer_pool_size' => '128MB',
                'key_buffer_size' => '32MB',
                'innodb_buffer_pool' => '256MB',
                'query_cache_size' => '64MB'
            ]
        ];

        return view('servers.database', compact('db_config'));
    }

    public function phpfpm()
    {
        $phpfpm_config = [
            'version' => '8.2.12',
            'status' => 'running',
            'process_manager' => 'ondemand',
            'max_children' => 50,
            'active_processes' => 8,
            'idle_processes' => 12,
            'requests_per_second' => 156,
            'memory_usage' => '45.6 MB',
            'pools' => [
                ['name' => 'www', 'processes' => 8, 'max_children' => 20, 'status' => 'active'],
                ['name' => 'api', 'processes' => 4, 'max_children' => 10, 'status' => 'active'],
                ['name' => 'admin', 'processes' => 2, 'max_children' => 5, 'status' => 'active']
            ],
            'extensions' => ['curl', 'gd', 'json', 'mbstring', 'openssl', 'pdo', 'pdo_mysql', 'redis', 'xml'],
            'opcache' => [
                'enabled' => true,
                'memory_usage' => '64MB',
                'hit_rate' => '89.5%',
                'cached_scripts' => 1247,
                'misses' => 145
            ]
        ];

        return view('servers.phpfpm', compact('phpfpm_config'));
    }

    public function ssh()
    {
        $ssh_config = [
            'status' => 'running',
            'port' => 22,
            'protocol' => 'SSH-2.0',
            'active_connections' => 3,
            'max_connections' => 10,
            'auth_methods' => ['password', 'publickey'],
            'allowed_users' => ['root', 'admin', 'deploy'],
            'recent_logins' => [
                ['user' => 'admin', 'ip' => '192.168.1.100', 'time' => '2024-12-22 14:30:00', 'status' => 'success'],
                ['user' => 'root', 'ip' => '192.168.1.101', 'time' => '2024-12-22 13:45:00', 'status' => 'success'],
                ['user' => 'unknown', 'ip' => '192.168.1.200', 'time' => '2024-12-22 12:30:00', 'status' => 'failed']
            ],
            'keys' => [
                ['user' => 'admin', 'key' => 'ssh-rsa AAAAB3...', 'added' => '2024-01-15'],
                ['user' => 'deploy', 'key' => 'ssh-ed25519 AAAAC3...', 'added' => '2024-03-20']
            ]
        ];

        return view('servers.ssh', compact('ssh_config'));
    }

    public function firewall()
    {
        $firewall_config = [
            'status' => 'active',
            'type' => 'UFW',
            'version' => '0.36.1',
            'default_policy' => ['incoming' => 'deny', 'outgoing' => 'allow', 'routed' => 'deny'],
            'rules' => [
                ['action' => 'ALLOW', 'protocol' => 'TCP', 'port' => 22, 'source' => 'Any', 'description' => 'SSH'],
                ['action' => 'ALLOW', 'protocol' => 'TCP', 'port' => 80, 'source' => 'Any', 'description' => 'HTTP'],
                ['action' => 'ALLOW', 'protocol' => 'TCP', 'port' => 443, 'source' => 'Any', 'description' => 'HTTPS'],
                ['action' => 'ALLOW', 'protocol' => 'TCP', 'port' => 3306, 'source' => '192.168.1.0/24', 'description' => 'MySQL (Internal)'],
                ['action' => 'DENY', 'protocol' => 'TCP', 'port' => 23, 'source' => 'Any', 'description' => 'Telnet Blocked']
            ],
            'logging' => ['enabled' => true, 'level' => 'medium'],
            'recent_blocks' => [
                ['ip' => '192.168.1.200', 'port' => 22, 'time' => '2024-12-22 12:30:00', 'reason' => 'Too many connections'],
                ['ip' => '10.0.0.50', 'port' => 80, 'time' => '2024-12-22 11:45:00', 'reason' => 'Suspicious activity']
            ]
        ];

        return view('servers.firewall', compact('firewall_config'));
    }

    public function fail2ban()
    {
        $fail2ban_config = [
            'status' => 'running',
            'version' => '1.0.2',
            'jails' => [
                ['name' => 'sshd', 'enabled' => true, 'banned' => 5, 'max_retry' => 3, 'find_time' => '10m', 'bantime' => '1h'],
                ['name' => 'apache', 'enabled' => true, 'banned' => 12, 'max_retry' => 5, 'find_time' => '10m', 'bantime' => '1h'],
                ['name' => 'nginx', 'enabled' => false, 'banned' => 0, 'max_retry' => 5, 'find_time' => '10m', 'bantime' => '1h'],
                ['name' => 'mysql', 'enabled' => true, 'banned' => 2, 'max_retry' => 3, 'find_time' => '10m', 'bantime' => '1h']
            ],
            'banned_ips' => [
                ['ip' => '192.168.1.200', 'jail' => 'sshd', 'time' => '2024-12-22 12:30:00', 'unban_time' => '2024-12-22 13:30:00'],
                ['ip' => '10.0.0.50', 'jail' => 'apache', 'time' => '2024-12-22 11:45:00', 'unban_time' => '2024-12-22 12:45:00'],
                ['ip' => '172.16.0.100', 'jail' => 'sshd', 'time' => '2024-12-22 10:15:00', 'unban_time' => '2024-12-22 11:15:00']
            ],
            'log_files' => [
                ['name' => '/var/log/fail2ban.log', 'size' => '2.4 MB', 'last_modified' => '2024-12-22 14:30:00']
            ]
        ];

        return view('servers.fail2ban', compact('fail2ban_config'));
    }
}
