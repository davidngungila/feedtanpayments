<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servers = [
            [
                'name' => 'web-server-01',
                'hostname' => 'web01.example.com',
                'ip_address' => '192.168.1.10',
                'status' => 'online',
                'os_type' => 'ubuntu',
                'os_version' => '22.04 LTS',
                'cpu_cores' => '8',
                'memory' => '32 GB',
                'disk_space' => '1 TB SSD',
                'location' => 'Data Center 1',
                'cpu_usage' => 45.2,
                'memory_usage' => 68.5,
                'disk_usage' => 72.1,
                'last_checked' => now(),
                'services' => [
                    'nginx' => 'active',
                    'apache' => 'inactive',
                    'mysql' => 'active',
                    'mariadb' => 'inactive',
                    'php-fpm' => 'active',
                    'ssh' => 'active',
                    'ufw' => 'active',
                    'fail2ban' => 'active'
                ],
                'notes' => 'Primary web server for production websites'
            ],
            [
                'name' => 'app-server-02',
                'hostname' => 'app02.example.com',
                'ip_address' => '192.168.1.11',
                'status' => 'online',
                'os_type' => 'centos',
                'os_version' => '8',
                'cpu_cores' => '4',
                'memory' => '16 GB',
                'disk_space' => '500 GB SSD',
                'location' => 'Data Center 1',
                'cpu_usage' => 32.8,
                'memory_usage' => 54.3,
                'disk_usage' => 45.7,
                'last_checked' => now(),
                'services' => [
                    'nginx' => 'inactive',
                    'apache' => 'active',
                    'mysql' => 'inactive',
                    'mariadb' => 'active',
                    'php-fpm' => 'active',
                    'ssh' => 'active',
                    'ufw' => 'active',
                    'fail2ban' => 'active'
                ],
                'notes' => 'Application server for backend services'
            ],
            [
                'name' => 'db-server-03',
                'hostname' => 'db03.example.com',
                'ip_address' => '192.168.1.12',
                'status' => 'online',
                'os_type' => 'ubuntu',
                'os_version' => '22.04 LTS',
                'cpu_cores' => '16',
                'memory' => '64 GB',
                'disk_space' => '2 TB SSD',
                'location' => 'Data Center 2',
                'cpu_usage' => 58.9,
                'memory_usage' => 76.2,
                'disk_usage' => 82.4,
                'last_checked' => now(),
                'services' => [
                    'nginx' => 'inactive',
                    'apache' => 'inactive',
                    'mysql' => 'active',
                    'mariadb' => 'inactive',
                    'php-fpm' => 'inactive',
                    'ssh' => 'active',
                    'ufw' => 'active',
                    'fail2ban' => 'active'
                ],
                'notes' => 'Primary database server'
            ],
            [
                'name' => 'mail-server-04',
                'hostname' => 'mail04.example.com',
                'ip_address' => '192.168.1.13',
                'status' => 'online',
                'os_type' => 'debian',
                'os_version' => '11',
                'cpu_cores' => '4',
                'memory' => '8 GB',
                'disk_space' => '250 GB SSD',
                'location' => 'Data Center 2',
                'cpu_usage' => 28.4,
                'memory_usage' => 41.7,
                'disk_usage' => 35.2,
                'last_checked' => now(),
                'services' => [
                    'nginx' => 'inactive',
                    'apache' => 'active',
                    'mysql' => 'inactive',
                    'mariadb' => 'inactive',
                    'php-fpm' => 'inactive',
                    'ssh' => 'active',
                    'ufw' => 'active',
                    'fail2ban' => 'active'
                ],
                'notes' => 'Mail server for email services'
            ],
            [
                'name' => 'backup-server-05',
                'hostname' => 'backup05.example.com',
                'ip_address' => '192.168.1.14',
                'status' => 'online',
                'os_type' => 'ubuntu',
                'os_version' => '20.04 LTS',
                'cpu_cores' => '8',
                'memory' => '16 GB',
                'disk_space' => '4 TB HDD',
                'location' => 'Data Center 3',
                'cpu_usage' => 15.3,
                'memory_usage' => 28.9,
                'disk_usage' => 91.8,
                'last_checked' => now(),
                'services' => [
                    'nginx' => 'inactive',
                    'apache' => 'inactive',
                    'mysql' => 'active',
                    'mariadb' => 'inactive',
                    'php-fpm' => 'inactive',
                    'ssh' => 'active',
                    'ufw' => 'active',
                    'fail2ban' => 'active'
                ],
                'notes' => 'Backup and storage server'
            ],
            [
                'name' => 'test-server-06',
                'hostname' => 'test06.example.com',
                'ip_address' => '192.168.1.15',
                'status' => 'offline',
                'os_type' => 'ubuntu',
                'os_version' => '22.04 LTS',
                'cpu_cores' => '2',
                'memory' => '4 GB',
                'disk_space' => '100 GB SSD',
                'location' => 'Data Center 1',
                'cpu_usage' => 0,
                'memory_usage' => 0,
                'disk_usage' => 0,
                'last_checked' => now()->subHour(),
                'services' => [
                    'nginx' => 'inactive',
                    'apache' => 'inactive',
                    'mysql' => 'inactive',
                    'mariadb' => 'inactive',
                    'php-fpm' => 'inactive',
                    'ssh' => 'inactive',
                    'ufw' => 'inactive',
                    'fail2ban' => 'inactive'
                ],
                'notes' => 'Test server for development and testing'
            ]
        ];

        foreach ($servers as $serverData) {
            Server::create($serverData);
        }
    }
}
