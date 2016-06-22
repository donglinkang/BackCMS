<?php

\DB::enableQueryLog();
//Cache::flush();
if ( env( 'APP_ENV' ) === 'local' ) {
    Artisan::call( 'view:clear' );
}

Route::group( [
    'prefix'    => Config()->get( 'route.admin.prefix' ),
    'namespace' => Config()->get( 'route.admin.namespace' ),
], function () {
    Route::controller( 'login', 'LoginController' );
    Route::controller( 'dashboard', 'DashboardController' );
    Route::controller( 'page', 'PageController' );
    Route::controller( 'archive', 'ArchiveController' );
    Route::controller( 'setting', 'SettingController' );
    Route::controller( 'manager', 'ManagerController' );
    Route::controller( 'template', 'TemplateController' );
    Route::controller( 'form', 'FormController' );
} );

Route::group( [
    'prefix'    => Config()->get( 'route.web.prefix' ),
    'namespace' => Config()->get( 'route.web.namespace' )
], function () {
    Route::controller( 'page', 'PageController' );
    Route::controller( 'archive', 'ArchiveController' );
    Route::controller( 'login', 'LoginController' );
    Route::controller( 'install', 'InstallController' );
    Route::controller( 'form', 'FormController' );
    Route::controller( 'git', 'GitController' );
    Route::controller( '/', 'HomeController' );
} );

/*
 * 301 跳转使用
 * */

//Route::get('/', function(){
//    return Redirect::to(Config()->get( 'route.web.prefix' ), 301);
//});
