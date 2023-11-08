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



Route::group('', function () {

    Route::post('/admin/login', 'admin/login');

    Route::post('/admin/register', 'admin/register');

    Route::post('/user/login', 'user/login');

    Route::post('/user/register', 'user/register');
});


Route::group('/api/admin', function () {

    Route::get('/getall', 'admin/getAll');

    Route::get('/getbyid/:id', 'admin/getById');

    Route::post('/reset_pwd', 'admin/resetPwd');

})->middleware(JwtMiddleware::class);



Route::group('/api/user', function () {

    Route::post('/file', 'upload/upload');

    Route::get('/getall', 'user/getAll');

    Route::get('/getbyid/:id', 'user/getById');

    Route::post('/reset_pwd', 'user/resetPwd');

    Route::post('/balance', 'user/setBalance');

    Route::post("/freeze", 'user/freeze');

})->middleware(JwtMiddleware::class);



Route::group('/api/position', function () {

    Route::get('/getall', 'position/getList');

    Route::post('/insert','position/insertPosition');

    Route::get('/delete/:id','position/deleteById');

});

Route::group('/api/address',function(){

    Route::get('/getadd','address/getAddress');

    Route::post('/setadd','address/setAddress');

});