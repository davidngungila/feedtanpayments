<?php

namespace App\Services;

use App\Models\Website;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class WebsiteManagementService
{
    protected $serverCommandService;
    
    public function __construct(ServerCommandService $serverCommandService)
    {
        $this->serverCommandService = $serverCommandService;
    }
    
    /**
     * Create a new website
     */
    public function createWebsite(array $data): array
    {
        try {
            $domain = $data['domain'];
            $projectName = $data['project_name'] ?? $domain;
            $phpVersion = $data['php_version'] ?? '8.2';
            $sslEnabled = $data['ssl_enabled'] ?? false;
            $databaseEnabled = $data['database_enabled'] ?? false;
            
            // Define paths
            $repositoryPath = "/var/www/repositories/{$projectName}";
            $publicPath = "{$repositoryPath}/public";
            
            // 1. Create project directory
            $mkdirResult = $this->serverCommandService->execute("mkdir -p {$repositoryPath}");
            if (!$mkdirResult['success']) {
                return $this->error('Failed to create project directory', $mkdirResult['output']);
            }
            
            // 2. Create Linux user
            $username = $this->generateUsername($projectName);
            $userResult = $this->serverCommandService->createLinuxUser($username, $repositoryPath);
            if (!$userResult['success']) {
                return $this->error('Failed to create Linux user', $userResult['output']);
            }
            
            // 3. Upload/Deploy Laravel project
            if (isset($data['project_file'])) {
                $deployResult = $this->deployProject($repositoryPath, $data['project_file']);
                if (!$deployResult['success']) {
                    return $deployResult;
                }
            }
            
            // 4. Create database if enabled
            $databaseInfo = null;
            if ($databaseEnabled) {
                $dbName = $this->generateDatabaseName($projectName);
                $dbUsername = $this->generateDatabaseUsername($projectName);
                $dbPassword = $this->generateRandomPassword();
                
                $dbResult = $this->serverCommandService->createDatabase($dbName, $dbUsername, $dbPassword);
                if (!$dbResult['success']) {
                    return $this->error('Failed to create database', $dbResult['output']);
                }
                
                $databaseInfo = [
                    'name' => $dbName,
                    'username' => $dbUsername,
                    'password' => $dbPassword
                ];
                
                // Create .env file
                $envResult = $this->createEnvironmentFile($repositoryPath, $databaseInfo, $domain);
                if (!$envResult['success']) {
                    return $envResult;
                }
            }
            
            // 5. Create Nginx configuration
            $nginxResult = $this->serverCommandService->createNginxConfig($domain, $publicPath, [
                'ssl' => $sslEnabled,
                'php_version' => $phpVersion
            ]);
            
            if (!$nginxResult['success']) {
                return $this->error('Failed to create Nginx configuration', $nginxResult['output']);
            }
            
            // 6. Generate SSL if enabled
            if ($sslEnabled) {
                $sslResult = $this->serverCommandService->generateSSL($domain);
                if (!$sslResult['success']) {
                    Log::warning('SSL generation failed', ['domain' => $domain, 'error' => $sslResult['output']]);
                }
            }
            
            // 7. Set permissions
            $this->serverCommandService->execute("chmod -R 775 {$repositoryPath}/storage {$repositoryPath}/bootstrap/cache");
            $this->serverCommandService->execute("chown -R {$username}:www-data {$repositoryPath}");
            
            // 8. Save website record
            $website = Website::create([
                'domain' => $domain,
                'project_name' => $projectName,
                'path' => $repositoryPath,
                'php_version' => $phpVersion,
                'ssl_enabled' => $sslEnabled,
                'database_enabled' => $databaseEnabled,
                'database_name' => $databaseInfo['name'] ?? null,
                'database_username' => $databaseInfo['username'] ?? null,
                'linux_username' => $username,
                'status' => 'active',
                'created_by' => auth()->id()
            ]);
            
            return [
                'success' => true,
                'website' => $website,
                'database_info' => $databaseInfo,
                'nginx_config' => $nginxResult['config_path'],
                'message' => 'Website created successfully'
            ];
            
        } catch (Exception $e) {
            Log::error('Website creation failed', [
                'domain' => $data['domain'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            
            return $this->error('Website creation failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Deploy project from file or git
     */
    private function deployProject(string $path, $projectFile): array
    {
        try {
            // Handle file upload (zip file)
            if (is_uploaded_file($projectFile)) {
                $zipPath = $path . '/project.zip';
                move_uploaded_file($projectFile, $zipPath);
                
                // Extract zip
                $extractResult = $this->serverCommandService->execute("unzip -o {$zipPath} -d {$path}");
                if (!$extractResult['success']) {
                    return $this->error('Failed to extract project', $extractResult['output']);
                }
                
                // Remove zip file
                $this->serverCommandService->execute("rm {$zipPath}");
                
                // Install dependencies if composer.json exists
                if (file_exists($path . '/composer.json')) {
                    $composerResult = $this->serverCommandService->execute("cd {$path} && composer install --no-dev --optimize-autoloader");
                    if (!$composerResult['success']) {
                        Log::warning('Composer install failed', ['path' => $path, 'error' => $composerResult['output']]);
                    }
                }
                
                return ['success' => true, 'message' => 'Project deployed successfully'];
            }
            
            return $this->error('Invalid project file');
            
        } catch (Exception $e) {
            return $this->error('Project deployment failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Create environment file for Laravel project
     */
    private function createEnvironmentFile(string $path, array $database, string $domain): array
    {
        $envContent = $this->generateEnvContent($database, $domain);
        
        $result = $this->serverCommandService->execute("echo '{$envContent}' > {$path}/.env");
        
        if (!$result['success']) {
            return $this->error('Failed to create .env file', $result['output']);
        }
        
        // Generate app key
        $keyResult = $this->serverCommandService->execute("cd {$path} && php artisan key:generate --force");
        
        return [
            'success' => $keyResult['success'],
            'message' => $keyResult['success'] ? 'Environment file created successfully' : 'Environment file created but key generation failed'
        ];
    }
    
    /**
     * Generate .env file content
     */
    private function generateEnvContent(array $database, string $domain): string
    {
        $appKey = 'base64:' . base64_encode(random_bytes(32));
        $appUrl = 'https://' . $domain;
        
        return "APP_NAME=\"{$domain}\"\n" .
               "APP_ENV=production\n" .
               "APP_KEY={$appKey}\n" .
               "APP_DEBUG=false\n" .
               "APP_URL={$appUrl}\n\n" .
               "DB_CONNECTION=mysql\n" .
               "DB_HOST=127.0.0.1\n" .
               "DB_PORT=3306\n" .
               "DB_DATABASE={$database['name']}\n" .
               "DB_USERNAME={$database['username']}\n" .
               "DB_PASSWORD={$database['password']}\n\n" .
               "CACHE_DRIVER=redis\n" .
               "FILESYSTEM_DISK=local\n" .
               "QUEUE_CONNECTION=redis\n" .
               "SESSION_DRIVER=redis\n" .
               "SESSION_LIFETIME=120\n\n" .
               "REDIS_HOST=127.0.0.1\n" .
               "REDIS_PASSWORD=null\n" .
               "REDIS_PORT=6379\n\n" .
               "MAIL_MAILER=log\n" .
               "MAIL_HOST=127.0.0.1\n" .
               "MAIL_PORT=2525\n" .
               "MAIL_USERNAME=null\n" .
               "MAIL_PASSWORD=null\n" .
               "MAIL_ENCRYPTION=null\n" .
               "MAIL_FROM_ADDRESS=\"hello@{$domain}\"\n" .
               "MAIL_FROM_NAME=\"{$domain}\"\n";
    }
    
    /**
     * Delete website
     */
    public function deleteWebsite(Website $website): array
    {
        try {
            // 1. Remove Nginx config
            $configPath = "/etc/nginx/sites-available/{$website->domain}";
            $enabledPath = "/etc/nginx/sites-enabled/{$website->domain}";
            
            $this->serverCommandService->execute("rm -f {$configPath} {$enabledPath}");
            
            // 2. Reload Nginx
            $this->serverCommandService->execute('systemctl reload nginx');
            
            // 3. Remove SSL certificates if they exist
            if ($website->ssl_enabled) {
                $this->serverCommandService->execute("certbot delete --cert-name {$website->domain} --non-interactive");
            }
            
            // 4. Remove database if enabled
            if ($website->database_enabled && $website->database_name) {
                $this->serverCommandService->execute("mysql -u root -e \"DROP DATABASE IF EXISTS \`{$website->database_name}\`;\"");
                $this->serverCommandService->execute("mysql -u root -e \"DROP USER IF EXISTS '{$website->database_username}'@'localhost';\"");
            }
            
            // 5. Remove Linux user
            if ($website->linux_username) {
                $this->serverCommandService->execute("userdel -f {$website->linux_username}");
            }
            
            // 6. Remove project directory
            if ($website->path) {
                $this->serverCommandService->execute("rm -rf {$website->path}");
            }
            
            // 7. Delete website record
            $website->delete();
            
            return ['success' => true, 'message' => 'Website deleted successfully'];
            
        } catch (Exception $e) {
            Log::error('Website deletion failed', [
                'website_id' => $website->id,
                'error' => $e->getMessage()
            ]);
            
            return $this->error('Website deletion failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Get website status
     */
    public function getWebsiteStatus(Website $website): array
    {
        $status = [
            'nginx_running' => false,
            'ssl_valid' => false,
            'database_connected' => false,
            'disk_usage' => 'unknown'
        ];
        
        // Check Nginx configuration
        $configPath = "/etc/nginx/sites-available/{$website->domain}";
        $nginxCheck = $this->serverCommandService->execute("test -f {$configPath} && echo 'exists'");
        $status['nginx_running'] = $nginxCheck['success'] && strpos($nginxCheck['output'], 'exists') !== false;
        
        // Check SSL certificate
        if ($website->ssl_enabled) {
            $sslCheck = $this->serverCommandService->execute("openssl x509 -checkend 86400 -noout -in /etc/letsencrypt/live/{$website->domain}/cert.pem");
            $status['ssl_valid'] = $sslCheck['success'] && strpos($sslCheck['output'], 'not') === false;
        }
        
        // Check database connection
        if ($website->database_enabled && $website->database_name) {
            $dbCheck = $this->serverCommandService->execute("mysql -u {$website->database_username} -p{$website->database_password} {$website->database_name} -e 'SELECT 1'");
            $status['database_connected'] = $dbCheck['success'];
        }
        
        // Get disk usage
        if ($website->path) {
            $diskCheck = $this->serverCommandService->execute("du -sh {$website->path} | cut -f1");
            $status['disk_usage'] = $diskCheck['success'] ? trim($diskCheck['output']) : 'unknown';
        }
        
        return $status;
    }
    
    /**
     * Helper methods
     */
    private function generateUsername(string $projectName): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', strtolower($projectName)) . '_user';
    }
    
    private function generateDatabaseName(string $projectName): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', strtolower($projectName)) . '_db';
    }
    
    private function generateDatabaseUsername(string $projectName): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', strtolower($projectName)) . '_user';
    }
    
    private function generateRandomPassword(int $length = 16): string
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*'), 0, $length);
    }
    
    private function error(string $message, string $details = ''): array
    {
        return [
            'success' => false,
            'message' => $message,
            'details' => $details
        ];
    }
}
