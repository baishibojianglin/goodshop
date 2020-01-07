<?php
use think\Route;

//登录
Route::POST('login','admin/Login/login');
//生成登录验证码
Route::GET('code','admin/Login/createverifycode');

Route::GET('test','admin/Company/test');