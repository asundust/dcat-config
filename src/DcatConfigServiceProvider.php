<?php

namespace Asundust\DcatConfig;

use Asundust\DcatConfig\Models\AdminConfig;
use Dcat\Admin\Extend\ServiceProvider;

class DcatConfigServiceProvider extends ServiceProvider
{
    protected $menu = [
        [
            'title' => 'System Configs',
            'uri' => 'configs',
            'icon' => 'fa-cogs',
        ]
    ];

    public function register()
    {
        //
    }

    public function init()
    {
        AdminConfig::loadConfigs();
        parent::init();
    }

    public function settingForm()
    {
        return new Setting($this);
    }
}
