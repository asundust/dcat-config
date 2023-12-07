<?php

namespace Asundust\DcatConfig;

use Asundust\DcatConfig\Models\AdminConfig;
use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->number('cache_ttl', $this->trans('dcat-config.cache_ttl'))->help(vsprintf($this->trans('dcat-config.cache_ttl_help'), [AdminConfig::DEFAULT_TTL]))->default(AdminConfig::DEFAULT_TTL);
        $this->switch('auto_backup', $this->trans('dcat-config.auto_backup'))->help($this->trans('dcat-config.auto_backup_help'))->default(1);
    }

    public function title()
    {
        return $this->trans('dcat-config.system_configs_setting');
    }
}
