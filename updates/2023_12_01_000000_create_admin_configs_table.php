<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminConfigTable extends Migration
{
    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string|null
     */
    public function getConnection()
    {
        return config('admin.database.connection') ?: config('database.default');
    }

    public function getTableName()
    {
        return config('admin.database.configs_table') ?: 'admin_configs';
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('config_category')->nullable()->comment('配置分类');
            $table->string('config_name')->unique()->comment('配置名称');
            $table->string('config_value')->nullable()->comment('配置值');
            $table->string('desc')->nullable()->comment('描述');
            $table->boolean('status')->index()->comment('状态(0禁用1启用)');
            $table->integer('sort_id')->index()->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName());
    }
}
