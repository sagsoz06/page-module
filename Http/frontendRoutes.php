<?php

use Illuminate\Routing\Router;

/** @var Router $router */
//if (! App::runningInConsole()) {
    $router->get(LaravelLocalization::transRoute('page::routes.homepage'), [
        'uses' => 'PublicController@homepage',
        'as' => 'homepage',
        'middleware' => config('asgard.page.config.middleware'),
    ]);
    $router->get(LaravelLocalization::transRoute('page::routes.page.tag'), [
        'uses' => 'PublicController@tag',
        'as' => 'page.tag',
        'middleware' => config('asgard.page.config.middleware'),
    ]);
    $router->any(LaravelLocalization::transRoute('page::routes.page.slug'), [
        'uses' => 'PublicController@uri',
        'as' => 'page',
        'middleware' => config('asgard.page.config.middleware'),
    ])->where('uri', '.*');
//}
