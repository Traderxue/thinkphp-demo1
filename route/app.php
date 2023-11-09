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

    Route::get('/getpage','user/getPaginateData');

})->middleware(JwtMiddleware::class);



Route::group('/api/position', function () {

    Route::get('/getall', 'position/getList');

    Route::post('/insert','position/insertPosition');

    Route::get('/delete/:id','position/deleteById');

    Route::get('/getpage','position/getPaginateData');

});

Route::group('/api/address',function(){

    Route::get('/getadd','address/getAddress');

    Route::post('/setadd','address/setAddress');

    Route::get('/geterc','address/geterc');

    Route::get('/gettrc','address/gettrc');

    Route::get('/getbsc','address/getbsc');
});

Route::group('/api/type',function(){

    Route::get('/gettype','type/getList');

    Route::post("/add",'type/addList');

    Route::get("/delete/:id",'type/deleteById');

    Route::get("/getpage","type/getPaginateData");
});

Route::group("/api/card",function(){

    Route::get('/getall',"card/getAll");

    Route::get('/getbyid/:id',"card/getById");

    Route::post('/add',"card/add");

    Route::get('/delete/:id',"card/deleteById");

    Route::get('/getpage',"card/getPaginateData");

});