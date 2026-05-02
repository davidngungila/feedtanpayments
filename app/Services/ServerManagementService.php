<?php

namespace App\Services;

use App\Models\Server;
use App\Services\ServerCommandService;
use Illuminate\Support\Facades\Log;

class ServerManagementService
{
    protected $commandService;

    public function __construct(ServerCommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    /**
     * Get all servers with their status
     */
    public function getAllServers()
    {
        return Server::orderBy('name')->get();
    }

    /**
     * Get server by ID
     */
    public function getServer($id)
    {
        return Server::findOrFail($id);
    }

    /**
     * Create a new server
     */
    public function createServer(array $data)
    {
        $server = Server::create([
            'name' => $data['name'],
            'hostname' => $data['hostname'],
            'ip_address' => $data['ip_address'],
            'status' => 'offline',
            'os_type' => $data['os_type'] ?? null,
            'os_version' => $data['os_version'] ?? null,
            'cpu_cores' => $data['cpu_cores'] ?? null,
            'memory' => $data['memory'] ?? null,
            'disk_space' => $data['disk_space'] ?? null,
            'location' => $data['location'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        // Initialize services array
        $server->services = [
            'nginx' => 'unknown',
            'apache' => 'unknown',
            'mysql' => 'unknown',
            'mariadb' => 'unknown',
            'php-fpm' => 'unknown',
            'ssh' => 'unknown',
            'ufw' => 'unknown',
            'fail2ban' => 'unknown'
        ];
        $server->save();

        return $server;
    }

    /**
     * Update server information
     */
    public function updateServer($id, array $data)
    {
        $server = Server::findOrFail($id);
        $server->update($data);
        return $server;
    }

    /**
     * Delete a server
     */
    public function deleteServer($id)
    {
        $server = Server::findOrFail($id);
        $server->delete();
        return $server;
    }

    /**
     * Check server status and update metrics
     */
    public function checkServerStatus($serverId)
    {
        $server = Server::findOrFail($serverId);
        
        try {
            // Check if server is reachable (ping test)
            $pingResult = $this->commandService->executeCommand("ping -c 1 {$server->ip_address}");
            
            if ($pingResult['success']) {
                $server->status = 'online';
                
                // Get system metrics
                $this->updateServerMetrics($server);
                $this->updateServiceStatus($server);
            } else {
                $server->status = 'offline';
            }
            
            $server->last_checked = now();
            $server->save();
            
        } catch (\Exception $e) {
            Log::error("Failed to check server status for {$server->name}: " . $e->getMessage());
            $server->status = 'offline';
            $server->last_checked = now();
            $server->save();
        }
        
        return $server;
    }

    /**
     * Update server metrics (CPU, Memory, Disk usage)
     */
    private function updateServerMetrics(Server $server)
    {
        try {
            // Get CPU usage
            $cpuResult = $this->commandService->executeCommand("top -bn1 | grep 'Cpu(s)' | awk '{print $2}' | cut -d'%' -f1");
            if ($cpuResult['success']) {
                $server->cpu_usage = (float) $cpuResult['output'];
            }

            // Get memory usage
            $memoryResult = $this->commandService->executeCommand("free | grep Mem | awk '{print ($3/$2) * 100.0}'");
            if ($memoryResult['success']) {
                $server->memory_usage = (float) $memoryResult['output'];
            }

            // Get disk usage
            $diskResult = $this->commandService->executeCommand("df -h / | awk 'NR==2 {print $5}' | cut -d'%' -f1");
            if ($diskResult['success']) {
                $server->disk_usage = (float) $diskResult['output'];
            }

        } catch (\Exception $e) {
            Log::error("Failed to update metrics for {$server->name}: " . $e->getMessage());
        }
    }

    /**
     * Update service status
     */
    private function updateServiceStatus(Server $server)
    {
        $services = $server->services ?? [];
        
        // Check each service
        $serviceCommands = [
            'nginx' => 'systemctl is-active nginx',
            'apache' => 'systemctl is-active apache2',
            'mysql' => 'systemctl is-active mysql',
            'mariadb' => 'systemctl is-active mariadb',
            'php-fpm' => 'systemctl is-active php8.1-fpm',
            'ssh' => 'systemctl is-active ssh',
            'ufw' => 'systemctl is-active ufw',
            'fail2ban' => 'systemctl is-active fail2ban'
        ];

        foreach ($serviceCommands as $service => $command) {
            try {
                $result = $this->commandService->executeCommand($command);
                $services[$service] = $result['success'] ? trim($result['output']) : 'inactive';
            } catch (\Exception $e) {
                $services[$service] = 'unknown';
            }
        }

        $server->services = $services;
    }

    /**
     * Get server monitoring data
     */
    public function getServerMonitoringData($serverId)
    {
        $server = $this->getServer($serverId);
        
        return [
            'server' => $server,
            'cpu_usage' => $server->getCpuUsagePercentage(),
            'memory_usage' => $server->getMemoryUsagePercentage(),
            'disk_usage' => $server->getDiskUsagePercentage(),
            'services' => $server->services ?? [],
            'last_checked' => $server->last_checked,
            'uptime' => $this->getServerUptime($server),
            'load_average' => $this->getLoadAverage($server),
            'network_connections' => $this->getNetworkConnections($server)
        ];
    }

    /**
     * Get server uptime
     */
    private function getServerUptime(Server $server)
    {
        try {
            $result = $this->commandService->executeCommand('uptime -p');
            return $result['success'] ? trim($result['output']) : 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get load average
     */
    private function getLoadAverage(Server $server)
    {
        try {
            $result = $this->commandService->executeCommand('uptime | grep "load average"');
            return $result['success'] ? trim($result['output']) : 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get network connections
     */
    private function getNetworkConnections(Server $server)
    {
        try {
            $result = $this->commandService->executeCommand('netstat -an | grep ESTABLISHED | wc -l');
            return $result['success'] ? (int) trim($result['output']) : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Restart a service on the server
     */
    public function restartService($serverId, $service)
    {
        $server = $this->getServer($serverId);
        
        try {
            $command = "sudo systemctl restart {$service}";
            $result = $this->commandService->executeCommand($command);
            
            if ($result['success']) {
                // Update service status
                $this->checkServerStatus($serverId);
                return ['success' => true, 'message' => "Service {$service} restarted successfully"];
            } else {
                return ['success' => false, 'message' => "Failed to restart {$service}: " . $result['error']];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => "Error restarting {$service}: " . $e->getMessage()];
        }
    }

    /**
     * Get service logs
     */
    public function getServiceLogs($serverId, $service, $lines = 50)
    {
        $server = $this->getServer($serverId);
        
        try {
            $command = "sudo journalctl -u {$service} -n {$lines} --no-pager";
            $result = $this->commandService->executeCommand($command);
            
            return [
                'success' => $result['success'],
                'logs' => $result['success'] ? $result['output'] : $result['error']
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'logs' => 'Error retrieving logs: ' . $e->getMessage()
            ];
        }
    }
}
