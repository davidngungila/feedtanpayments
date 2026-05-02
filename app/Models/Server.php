<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Server extends Model
{
    protected $fillable = [
        'name',
        'hostname',
        'ip_address',
        'status',
        'os_type',
        'os_version',
        'cpu_cores',
        'memory',
        'disk_space',
        'location',
        'services',
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'last_checked',
        'notes'
    ];

    protected $casts = [
        'services' => 'array',
        'cpu_usage' => 'decimal:2',
        'memory_usage' => 'decimal:2',
        'disk_usage' => 'decimal:2',
        'last_checked' => 'datetime',
    ];

    public function isOnline()
    {
        return $this->status === 'online';
    }

    public function getServiceStatus($service)
    {
        $services = $this->services ?? [];
        return $services[$service] ?? 'unknown';
    }

    public function getTotalCpuCores()
    {
        return $this->cpu_cores ? (int) $this->cpu_cores : 0;
    }

    public function getTotalMemory()
    {
        return $this->memory ? $this->memory : '0 GB';
    }

    public function getTotalDiskSpace()
    {
        return $this->disk_space ? $this->disk_space : '0 GB';
    }

    public function getCpuUsagePercentage()
    {
        return (float) $this->cpu_usage;
    }

    public function getMemoryUsagePercentage()
    {
        return (float) $this->memory_usage;
    }

    public function getDiskUsagePercentage()
    {
        return (float) $this->disk_usage;
    }
}
