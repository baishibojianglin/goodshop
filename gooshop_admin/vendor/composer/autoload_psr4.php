<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'think\\composer\\' => array($vendorDir . '/topthink/think-installer/src'),
<<<<<<< HEAD
    'think\\' => array($baseDir . '/thinkphp/library/think'),
=======
    'think\\' => array($baseDir . '/thinkphp/library/think', $vendorDir . '/topthink/think-image/src'),
>>>>>>> 94a850b49ad81c9e7278a2ffaaba919f19313f90
    'app\\' => array($baseDir . '/application'),
    'OSS\\' => array($vendorDir . '/aliyuncs/oss-sdk-php/src/OSS'),
);
