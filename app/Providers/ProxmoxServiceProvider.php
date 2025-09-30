<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Proxmox\Proxmox;

class ProxmoxServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Proxmox::class, function ($app) {
            $config = config('services.proxmox');
            return new Proxmox([
                'hostname'   => $config['host'],
                'port'       => $config['port'],
                'username'   => $config['user'],
                'password'   => $config['password'],
                'realm'      => $config['realm'],
                'verify_ssl' => filter_var($config['verify_ssl'], FILTER_VALIDATE_BOOLEAN),
            ]);
        });
    }

    public function boot()
    {
        //
    }
}
