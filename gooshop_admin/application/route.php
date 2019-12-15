<?php
use think\Route;

//登录
Route::POST('login','index/Login/login');
//登录
Route::GET('code','index/Login/createverifycode');
