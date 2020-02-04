<?php
use think\Route;

/*-----后台管理中心路由-----*/
//登录
Route::POST('login','admin/Login/login');
//登录验证码
Route::GET('code','admin/Login/createverifycode');
//上传图片
Route::POST('upload','admin/Common/uploadimg');
// 区域
Route::resource('region', 'admin/region');
// 商品类别
Route::resource('goods_cate', 'admin/goods_cate');
Route::get('goods_cate_tree', 'admin/goods_cate/goodsCateTree');
// 商品品牌
Route::resource('goods_brand', 'admin/goods_brand');


