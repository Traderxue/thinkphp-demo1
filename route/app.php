<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;
use app\middleware\JwtMiddleware;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::get('hello1/:name', 'index/hello1');

Route::get('user/get', 'user/index');



Route::group('/user', function () {

    Route::post('/login', 'user/login');

    Route::post('/register', 'user/register');
});


Route::group('/api', function () {

    Route::get('/getusers', 'user/getAll');

    Route::get('/getbyid/:id', 'user/getById');

    Route::post('/reset_pwd','user/resetPwd');
    
})->middleware(JwtMiddleware::class);
