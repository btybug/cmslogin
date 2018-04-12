<?php
/**
 * Copyright (c) 2017.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace BtyBugHook\CmsLogin\Providers;

use Btybug\btybug\Models\Routes;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class ModuleServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../views', 'cmslogin');
        $this->loadViewsFrom(__DIR__ . '/../views', 'cmslogin');

        \Eventy::action('admin.menus', [
            "title" => "FB",
            "custom-link" => "#",
            "icon" => "fa fa-anchor",
            "is_core" => "yes",
            "children" => [
                [
                    "title" => "Index",
                    "custom-link" => "/admin/bty-login",
                    "icon" => "fa fa-angle-right",
                    "is_core" => "yes"
                ]
            ]]);
        
        \Config::set('painter.PAINTERSPATHS', array_merge(\Config::get('painter.PAINTERSPATHS'), ['app' . DS . 'Plugins' . DS . 'vendor' . DS . 'btybug.hook' . DS . 'cmslogin' . DS . 'src' . DS . 'units']));

        Routes::registerPages('btybug.hook/cmslogin');
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

    }

}

