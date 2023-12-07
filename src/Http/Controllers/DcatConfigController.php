<?php

namespace Asundust\DcatConfig\Http\Controllers;

use Asundust\DcatConfig\DcatConfigServiceProvider;
use Asundust\DcatConfig\Http\Actions\AdminConfig\ConfigReCacheAbstractTool;
use Asundust\DcatConfig\Models\AdminConfig;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class DcatConfigController extends AdminController
{
    public function title()
    {
        return DcatConfigServiceProvider::trans('dcat-config.system_configs');
    }

    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->breadcrumb(['text' => $this->title(), 'url' => 'configs', 'icon' => 'fa-cogs'], ['text' => trans('admin.list')])
            ->body($this->grid());
    }

    protected function grid()
    {
        return Grid::make(new AdminConfig(), function (Grid $grid) {
            $grid->column('config_category', $this->trans('config_category'))->sortable();
            $grid->column('config_name', $this->trans('config_name'))->sortable();
            $grid->column('config_value', $this->trans('config_value'))->editable();
            $grid->column('cache_value', $this->trans('cache_value'))->display(function () {
                return config($this['config_name']);
            });
            $grid->column('desc', $this->trans('desc'));
            $grid->column('status', $this->trans('status'))->switch()->sortable();
            $grid->column('sort_id', $this->trans('sort_id'))->sortable();
            $grid->quickSearch(['config_category', 'config_name', 'config_value', 'desc']);
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->showColumnSelector();
            $grid->disableEditButton();
            $grid->tools([
                new ConfigReCacheAbstractTool(),
            ]);
            $grid->model()->orderBy('sort_id');
        });
    }

    protected function detail($id)
    {
        return Show::make($id, new AdminConfig(), function (Show $show) {
            $show->field('config_category', $this->trans('config_category'));
            $show->field('config_name', $this->trans('config_name'));
            $show->field('config_value', $this->trans('config_value'));
            $show->field('desc', $this->trans('desc'));
            $show->field('status', $this->trans('status'))->using(AdminConfig::STATES);
            $show->field('sort_id', $this->trans('sort_id'));
        });
    }

    public function form()
    {
        $config = new AdminConfig();
        return Form::make($config, function (Form $form) use ($config) {
            $connection = $config->getConnectionName();
            $configTable = $config->getTable();
            $id = $form->getKey();

            $form->display('id', 'ID');
            $form->text('config_category', $this->trans('config_category'));
            $form->text('config_name', $this->trans('config_name'))
                ->required()
                ->creationRules(['required', "unique:{$connection}.{$configTable}"])
                ->updateRules(['required', "unique:{$connection}.{$configTable},config_name,$id"]);
            $form->text('config_value', $this->trans('config_value'));
            $form->switch('status', $this->trans('status'))->default(AdminConfig::STATES_TRUE);
            $form->text('desc', $this->trans('desc'));
            $form->number('sort_id', $this->trans('sort_id'));
        });
    }

    public function trans($key)
    {
        return DcatConfigServiceProvider::trans("dcat-config.columns.$key");
    }
}