<?php
/**
 * Created by PhpStorm.
 * User: Yan
 * Date: 2019/7/18
 * Time: 15:22
 */

return [
    'password_pre_salt' => '#sustock_goodshop', // 密码加密盐
    'aeskey' => '285925c6ac8ff54205461a3226c24b70', // aes密钥，服务端和客户端必须保持一致 MD5('#sustock_goodshop')
    'apptypes' => ['android', 'ios', 'devtools'],
    'app_sign_time' => 10, // sign失效时间
    'app_sign_cache_time' => 20, // sign缓存失效时间
    'login_time_out_day' => 7, // 登录token的失效时间

    'I_SERVER_NAME' => 'http://' . $_SERVER['SERVER_NAME'] . '/index.php/', // 当前域名

    // session设置
    'session_admin' => 'sustock_goodshop_admin', // 管理员session名称
    'session_admin_scope' => 'sustock_goodshop_admin_scope', // 作用域
];