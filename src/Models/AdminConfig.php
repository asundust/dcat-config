<?php

namespace Asundust\DcatConfig\Models;

use Asundust\DcatConfig\DcatConfigServiceProvider;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Asundust\DcatConfig\Models\AdminConfig.
 *
 * @property int $id
 * @property string $config_category 配置分类
 * @property string $config_name 配置名称
 * @property string $config_value 配置值
 * @property string $desc 描述
 * @property int $status 状态(0禁用1启用)
 * @property int $sort_id 排序
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class AdminConfig extends Model
{
    protected $fillable = ['config_category', 'config_name', 'config_value', 'desc', 'status', 'sort_id'];

    const DEFAULT_TTL = 86400;
    const STATES_TRUE = 1;
    const STATES = [
        0 => '禁用',
        1 => '启用',
    ];

    /**
     * AdminConfig constructor.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(config('admin.database.connection') ?: config('database.default'));
        $this->setTable(self::getTableName());
    }

    public static function getTableName()
    {
        return config('admin.database.configs_table') ?: 'admin_configs';
    }

    public static function cacheConfigs($reCache = false)
    {
        $cacheKey = 'Cache-' . DcatConfigServiceProvider::instance()->getName() . '-' . self::getTableName();
        if (!$reCache && $configs = Cache::get($cacheKey, [])) {
            return $configs;
        }

        if (DcatConfigServiceProvider::setting('auto_backup')) {
            Storage::disk('local')->put('dcat-config-backup/' . date('Y-m-d-H-i-s') . '.json', self::get()->toJson(JSON_UNESCAPED_UNICODE));
        }

        $configs = self::where('status', self::STATES_TRUE)->get(['config_name', 'config_value'])->toArray();
        Cache::put($cacheKey, $configs, DcatConfigServiceProvider::setting('cache_ttl') ?: null);

        return $configs;
    }

    public static function loadConfigs()
    {
        $configs = self::cacheConfigs();
        foreach ($configs as $config) {
            config([$config['config_name'] => $config['config_value']]);
        }
    }
}
