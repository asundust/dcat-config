Dcat-Admin 系统配置 / Dcat-Admin System Config
======

![StyleCI build status](https://github.styleci.io/repos/728451913/shield)

Dcat-Admin 系统配置

![image](https://github.com/asundust/NAS-Nav-iCloud/assets/6573979/0b8b08bc-cdf2-4897-86ea-3f0c3d0a8b18)

### 安装

```
composer require asundust/dcat-config
```

### 主要功能

- 自定义系统配置，配置方便
- 调用缓存，减少每次使用的数据库压力
- 带配置开关，方便开启关闭
- 简单分类，方便寻找
- 可配置参数缓存的时长
- 可配置自动备份配置信息（考虑到Dcat-Admin卸载扩展时会删除对应表）

### 本地化

- 在`resources/lang/zh_CN`目录(可能是`zh-CN`)下`menu.php`文件里添加下述代码

``` php
'system_configs' => '系统参数',
```

### 支持

如果觉得这个项目帮你节约了时间，不妨支持一下呗！

![alipay](https://user-images.githubusercontent.com/6573979/91679916-2c4df500-eb7c-11ea-98a7-ab740ddda77d.png)
![wechat](https://user-images.githubusercontent.com/6573979/91679913-2b1cc800-eb7c-11ea-8915-eb0eced94aee.png)

### License

[The MIT License (MIT)](https://opensource.org/licenses/MIT)