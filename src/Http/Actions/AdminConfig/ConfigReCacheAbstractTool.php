<?php

namespace Asundust\DcatConfig\Http\Actions\AdminConfig;

use Asundust\DcatConfig\DcatConfigServiceProvider;
use Asundust\DcatConfig\Models\AdminConfig;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;

class ConfigReCacheAbstractTool extends AbstractTool
{
    protected $style = 'btn btn-outline-primary waves-effect';

    public function title()
    {
        return '<i class="feather icon-refresh-cw"></i> &nbsp;' . DcatConfigServiceProvider::trans('dcat-config.config_cache_update');
    }

    /**
     * @param Request $request
     * @return \Dcat\Admin\Actions\Response
     */
    public function handle(Request $request)
    {
        AdminConfig::cacheConfigs(true);
        return $this->response()->success(DcatConfigServiceProvider::trans('dcat-config.config_cache_success'))->refresh();
    }
}
