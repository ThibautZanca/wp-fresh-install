<?php

namespace App\Providers;

use Rareloop\Lumberjack\Config;
use Rareloop\Lumberjack\Providers\ServiceProvider;


class StageServiceProvider extends ServiceProvider
{
    /**
     * Register all hooks listed into the config file
     * @param Config $config
     */
    public function boot(Config $config)
    {
        $stages = $config->get('stages');
        if (is_array($stages)) {
            define('ENVIRONMENTS', serialize($stages));
        }
    }
}
