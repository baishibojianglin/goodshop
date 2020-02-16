<?php
use think\Route;

/*-----后台管理中心路由-----*/
//登录
Route::POST('login','admin/Login/login');
//登录验证码
Route::GET('code','admin/Login/createverifycode');
//上传图片
Route::POST('upload','admin/Common/uploadimg');
//删除图片
Route::POST('deleteimages','admin/Common/deleteimg');
//获取供应商销售区域数据
Route::POST('companyarea','admin/Company/getarea');
// 区域
Route::resource('region', 'admin/region');
// 商品类别
Route::resource('goods_cate', 'admin/goods_cate');
Route::get('goods_cate_tree', 'admin/goods_cate/goodsCateTree'); // 商品类别列表树
// 商品品牌
Route::resource('goods_brand', 'admin/goods_brand');
// Auth用户组
Route::resource('auth_group', 'admin/auth_group');
Route::get('auth_group_tree', 'admin/auth_group/authGroupTree'); // Auth用户组列表树
// Auth权限规则
Route::resource('auth_rule', 'admin/auth_rule');
Route::get('auth_rule_tree', 'admin/auth_rule/authRuleTree'); // Auth权限规则列表树
// 供应商账户
Route::resource('company_user', 'admin/company_user');
// 供应商
Route::get('company_tree', 'admin/company/companyTree'); // 供应商列表树
Route::POST('createCompany','admin/Company/submitCompany'); // 创建供应商
