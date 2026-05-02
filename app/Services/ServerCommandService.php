<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class ServerCommandService
{
    /**
     * Execute a server command with security validation
     */
    public function execute(string $command, array $options = []): array
    {
        // Validate command against allowed commands
        if (!$this->isCommandAllowed($command)) {
            return [
                'success' => false,
                'error' => 'Command not allowed for security reasons',
                'output' => '',
                'exit_code' => 1
            ];
        }

        try {
            // Set default options
            $timeout = $options['timeout'] ?? 60;
            $workingDirectory = $options['working_directory'] ?? null;
            
            // Build the full command
            $fullCommand = $command;
            if ($workingDirectory) {
                $fullCommand = "cd {$workingDirectory} && {$command}";
            }
            
            // Execute command with timeout
            $output = [];
            $exitCode = 0;
            
            // Add timeout wrapper
            $timeoutCommand = "timeout {$timeout} {$fullCommand} 2>&1";
            
            // Execute the command
            exec($timeoutCommand, $output, $exitCode);
            
            $outputString = implode("\n", $output);
            
            Log::info('Server command executed', [
                'command' => $command,
                'exit_code' => $exitCode,
                'output_length' => strlen($outputString)
            ]);
            
            return [
                'success' => $exitCode === 0,
                'output' => $outputString,
                'exit_code' => $exitCode,
                'command' => $command
            ];
            
        } catch (Exception $e) {
            Log::error('Server command execution failed', [
                'command' => $command,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'output' => '',
                'exit_code' => 1
            ];
        }
    }
    
    /**
     * Check if command is allowed for security
     */
    private function isCommandAllowed(string $command): bool
    {
        $allowedCommands = [
            // Nginx commands
            'nginx -t',
            'nginx -s reload',
            'nginx -s restart',
            'systemctl reload nginx',
            'systemctl restart nginx',
            'systemctl status nginx',
            
            // File system commands
            'mkdir',
            'cp',
            'mv',
            'rm',
            'chmod',
            'chown',
            'ls',
            'find',
            'du',
            'df',
            
            // User management
            'adduser',
            'useradd',
            'userdel',
            'usermod',
            'groupadd',
            
            // Database commands
            'mysql',
            'mysqldump',
            
            // SSL commands
            'certbot',
            
            // PHP commands
            'php',
            'composer',
            'php-fpm',
            'systemctl reload php',
            'systemctl restart php',
            
            // System monitoring
            'top',
            'ps',
            'free',
            'uptime',
            'who',
            'w',
            
            // Network commands
            'netstat',
            'ss',
            'ping',
            'curl',
            'wget',
            
            // Firewall commands
            'ufw',
            'iptables',
            
            // Compression
            'tar',
            'zip',
            'unzip',
            
            // Version checks
            '--version',
            '-v'
        ];
        
        // Check if command contains any allowed commands
        foreach ($allowedCommands as $allowed) {
            if (strpos($command, $allowed) !== false) {
                return true;
            }
        }
        
        // Allow specific safe patterns
        $safePatterns = [
            '/^ls\s/',
            '/^cd\s/',
            '/^pwd/',
            '/^cat\s/',
            '/^grep\s/',
            '/^tail\s/',
            '/^head\s/',
            '/^wc\s/',
            '/^echo\s/',
            '/^date/',
            '/^whoami/',
            '/^id/'
        ];
        
        foreach ($safePatterns as $pattern) {
            if (preg_match($pattern, $command)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Create Nginx configuration file
     */
    public function createNginxConfig(string $domain, string $rootPath, array $options = []): array
    {
        $configPath = "/etc/nginx/sites-available/{$domain}";
        
        $sslEnabled = $options['ssl'] ?? false;
        $phpVersion = $options['php_version'] ?? '8.2';
        
        $config = $this->generateNginxConfig($domain, $rootPath, $sslEnabled, $phpVersion);
        
        // Create config file
        $result = $this->execute("echo '{$config}' > {$configPath}");
        
        if (!$result['success']) {
            return $result;
        }
        
        // Test Nginx configuration
        $testResult = $this->execute('nginx -t');
        
        if (!$testResult['success']) {
            // Remove invalid config
            $this->execute("rm {$configPath}");
            return [
                'success' => false,
                'error' => 'Invalid Nginx configuration: ' . $testResult['output'],
                'output' => $testResult['output']
            ];
        }
        
        // Enable site
        $enableResult = $this->execute("ln -s {$configPath} /etc/nginx/sites-enabled/");
        
        if (!$enableResult['success']) {
            return $enableResult;
        }
        
        // Reload Nginx
        $reloadResult = $this->execute('systemctl reload nginx');
        
        return [
            'success' => $reloadResult['success'],
            'config_path' => $configPath,
            'output' => $reloadResult['output'],
            'error' => $reloadResult['success'] ? null : $reloadResult['output']
        ];
    }
    
    /**
     * Generate Nginx configuration content
     */
    private function generateNginxConfig(string $domain, string $rootPath, bool $ssl, string $phpVersion): string
    {
        $config = "server {\n";
        $config .= "    listen 80;\n";
        $config .= "    server_name {$domain};\n\n";
        
        if ($ssl) {
            $config .= "    listen 443 ssl http2;\n";
            $config .= "    ssl_certificate /etc/letsencrypt/live/{$domain}/fullchain.pem;\n";
            $config .= "    ssl_certificate_key /etc/letsencrypt/live/{$domain}/privkey.pem;\n";
            $config .= "    include /etc/letsencrypt/options-ssl-nginx.conf;\n";
            $config .= "    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;\n\n";
        }
        
        $config .= "    root {$rootPath};\n";
        $config .= "    index index.php index.html index.htm;\n\n";
        
        $config .= "    location / {\n";
        $config .= "        try_files \$uri \$uri/ /index.php?\$query_string;\n";
        $config .= "    }\n\n";
        
        $config .= "    location ~ \.php$ {\n";
        $config .= "        fastcgi_pass unix:/run/php/php{$phpVersion}-fpm.sock;\n";
        $config .= "        fastcgi_index index.php;\n";
        $config .= "        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;\n";
        $config .= "        include fastcgi_params;\n";
        $config .= "    }\n\n";
        
        $config .= "    location ~ /\.ht {\n";
        $config .= "        deny all;\n";
        $config .= "    }\n";
        
        $config .= "}\n";
        
        return $config;
    }
    
    /**
     * Create MySQL database and user
     */
    public function createDatabase(string $dbName, string $username, string $password): array
    {
        $commands = [
            "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;",
            "CREATE USER IF NOT EXISTS '{$username}'@'localhost' IDENTIFIED BY '{$password}';",
            "GRANT ALL PRIVILEGES ON `{$dbName}`.* TO '{$username}'@'localhost';",
            "FLUSH PRIVILEGES;"
        ];
        
        $results = [];
        
        foreach ($commands as $command) {
            $result = $this->execute("mysql -u root -e \"{$command}\"");
            $results[] = $result;
            
            if (!$result['success']) {
                return [
                    'success' => false,
                    'error' => 'Database creation failed: ' . $result['output'],
                    'output' => $result['output']
                ];
            }
        }
        
        return [
            'success' => true,
            'database' => $dbName,
            'username' => $username,
            'output' => 'Database and user created successfully'
        ];
    }
    
    /**
     * Get server system information
     */
    public function getSystemInfo(): array
    {
        $info = [];
        
        // CPU info
        $cpuResult = $this->execute("grep -c '^processor' /proc/cpuinfo");
        $info['cpu_cores'] = $cpuResult['success'] ? trim($cpuResult['output']) : 'Unknown';
        
        // Memory info
        $memResult = $this->execute("free -m | grep '^Mem:' | awk '{print $2,$3,$4}'");
        if ($memResult['success']) {
            $memParts = explode(' ', trim($memResult['output']));
            $info['memory'] = [
                'total' => $memParts[0] ?? 'Unknown',
                'used' => $memParts[1] ?? 'Unknown',
                'free' => $memParts[2] ?? 'Unknown'
            ];
        }
        
        // Disk usage
        $diskResult = $this->execute("df -h / | tail -1 | awk '{print $2,$3,$4,$5}'");
        if ($diskResult['success']) {
            $diskParts = explode(' ', trim($diskResult['output']));
            $info['disk'] = [
                'total' => $diskParts[0] ?? 'Unknown',
                'used' => $diskParts[1] ?? 'Unknown',
                'free' => $diskParts[2] ?? 'Unknown',
                'percentage' => $diskParts[3] ?? 'Unknown'
            ];
        }
        
        // Uptime
        $uptimeResult = $this->execute("uptime -p");
        $info['uptime'] = $uptimeResult['success'] ? trim($uptimeResult['output']) : 'Unknown';
        
        // Load average
        $loadResult = $this->execute("uptime | awk -F'load average:' '{print \$2}'");
        $info['load_average'] = $loadResult['success'] ? trim($loadResult['output']) : 'Unknown';
        
        return $info;
    }
    
    /**
     * Create Linux user for website
     */
    public function createLinuxUser(string $username, string $homeDirectory): array
    {
        // Create user with home directory
        $result = $this->execute("adduser --system --group --home {$homeDirectory} --shell /bin/bash {$username}");
        
        if ($result['success']) {
            // Set ownership
            $this->execute("chown -R {$username}:www-data {$homeDirectory}");
            $this->execute("chmod -R 775 {$homeDirectory}/storage {$homeDirectory}/bootstrap/cache");
        }
        
        return $result;
    }
    
    /**
     * Generate SSL certificate with Let's Encrypt
     */
    public function generateSSL(string $domain): array
    {
        $result = $this->execute("certbot --nginx -d {$domain} --non-interactive --agree-tos --email admin@{$domain}");
        
        return [
            'success' => $result['success'],
            'output' => $result['output'],
            'error' => $result['success'] ? null : $result['output']
        ];
    }
}
