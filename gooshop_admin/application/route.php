<?php
use think\Route;

// 后台管理中心路由
//登录
Route::POST('login','admin/Login/login');
//生成登录验证码
Route::GET('code','admin/Login/createverifycode');

Route::POST('test','admin/Login/test');
// 区域
Route::resource('region', 'admin/region');
// 商品类别
Route::resource('goods_cate', 'admin/goods_cate');
