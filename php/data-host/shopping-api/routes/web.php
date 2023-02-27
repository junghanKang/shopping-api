<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/member/register', [
    'as' => 'register', 'uses' => 'AuthController@registerUser'
]);

$router->post('/member/login', [
    'as' => 'login', 'uses' => 'AuthController@login'
]);

$router->group(['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->get('/user/inquiry', [
            'as' => 'user', 'uses' => 'inquiryController@getUser'
        ]);

        $router->get('/user/orders/{userId}', [
            'as' => 'user', 'uses' => 'inquiryController@getOrder'
        ]);

        $router->get('/users/search', [
            'as' => 'user', 'uses' => 'inquiryController@getUsersWithConditions'
        ]);

        $router->post('/member/logout', [
            'as' => 'logout', 'uses' => 'AuthController@logout'
        ]);
    }
);
