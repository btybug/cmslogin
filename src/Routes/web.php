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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



//Routes
    Route::get('/', 'IndexController@getIndex',true)->name('cms_login_index');
    Route::get('/settings', 'IndexController@getSettings',true)->name('cms_loginr_settings');
    Route::post('/settings', 'IndexController@postSettings')->name('cms_login_settings_post');
