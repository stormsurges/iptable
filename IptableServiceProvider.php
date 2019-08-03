<?php

namespace Surges\Iptable;

use Illuminate\Support\ServiceProvider;

class IptableServiceProvider extends ServiceProvider
{

    protected $config;

    public function register()
    {
        $this->mergeConfigs();
        $this->registerIptable();
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('iptable.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }

    protected function registerIptable()
    {
        $this->app->singleton('Iptable', function ($app) {
            return $this->getDriver();
        });
    }

    protected function mergeConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'iptable');

        $this->config = $this->app->make('config')->get('iptable');
    }

    protected function getDriver()
    {
        $driver = $this->config['driver'] ?: 'taobao';
        switch ($driver) {
            case 'database':
                return new DatabaseRepository($this->config['table'] ?: 'iptables');
                break;

            case 'taobao':
            default:
                return new TaobaoRepository();
                break;
        }
    }
}
