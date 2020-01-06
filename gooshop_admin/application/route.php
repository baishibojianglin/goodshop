<?php
use think\Route;

//登录
Route::POST('login','index/Login/login');
//生成登录验证码
Route::GET('code','index/Login/createverifycode');

