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
    // return $router->app->version();
    dd(DB::getPdo());
});

$router->post('/member/register', [
    'as' => 'register', 'uses' => 'RegisterController@registerUser'
]);

$router->get('/member/login', function () use ($router) {

});

$router->get('/member/logout', function () use ($router) {

});

