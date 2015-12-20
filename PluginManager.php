<?php

namespace Plugin\FreeeLight;

use Eccube\Plugin\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{

    public function install($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code']);
    }
    public function uninstall($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Resource/doctrine/migration', $config['code'], 0);
    }
    public function enable($config, $app)
    {
    }
    public function disable($config, $app)
    {
    }
    public function update($config, $app)
    {
    }
}
