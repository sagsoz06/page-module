<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'v1/page', 'middleware' => 'api.token'], function (Router $router) {
    $router->post('/update', [
        'as'         => 'api.page.update',
        'uses'       => 'PageController@update',
        'middleware' => 'token-can:api.page.update',
    ]);
    $router->post('/delete', [
        'as'         => 'api.page.delete',
        'uses'       => 'PageController@destroy',
        'middleware' => 'token-can:api.page.destroy',
    ]);
});

$router->group(['prefix'=>'v1/page'], function (Router $router) {
    $router->get('/get', [
        'as'         => 'api.page.get',
        'uses'       => 'PublicController@get'
    ]);
});
