<?php

namespace app\admin\controller;

use think\Cache;
use think\Controller;

//阿里云oss对象存储
if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}
use OSS\OssClient;
use OSS\Core\OssException;


/**
 * admin模块公共控制器类
 * Class Common
 * @package app\admin\controller
 */
class Common extends Controller
{
    /**
     * headers信息
     * @var string
     */
    public $headers = '';

    /**
     * page 当前页
     * @var string
     */
    public $page = '';

    /**
     * size 每页条数
     * @var string
     */
    public $size = '';

    /**
     * 每页从第几条开始
     * @var int
     */
    public $from = 0;

    /**
     * 初始化
     */
    public function _initialize()
    {
        //$this->checkRequestAuth(); // TODO：生产环境必须检查数据的合法性
    }

    /**
     * 获取分页page、size、from
     * @param $params
     */
    public function getPageAndSize($params)
    {
        $this->page = !empty($params['page']) ? $params['page'] : 1;
        $this->size = !empty($params['size']) ? $params['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size; // 'limit from,size'
    }

  /**
  *上传图片
  *$name string file表单name属性
  */
    public function uploadimg()
    {
        //上传
        $file = request()->file('image');
        $info=$file->getInfo();
        // 阿里云RAM账号AccessKey
        $accessKeyId = "LTAI4FkCSGwQHirzGvdvWqiG";
        $accessKeySecret = "ACpMHxZXPkkl23ont4mQfzjCZKtL3L";
        // Endpoint以成都为例，其它Region请按实际情况填写。
        $endpoint = "http://oss-cn-chengdu.aliyuncs.com";
        // 存储空间名称
        $bucket = "goodshopimages";
        // 文件名称
        $object = $info['name'];
        // <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt
        $filePath = $info['tmp_name'];

        try{
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->uploadFile($bucket, $object, $filePath);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
        //print(__FUNCTION__ . ": OK" . "\n");

        //回调
        // callbackUrl为回调服务器地址，如http://oss-demo.aliyuncs.com:23450或http://127.0.0.1:9090。
        // callbackHost为回调请求消息头中Host的值，如oss-cn-hangzhou.aliyuncs.com。
        $url =
            '{
                "callbackUrl":"http://127.0.0.1",
                "callbackHost":"oss-cn-chengdu.aliyuncs.com",
                "callbackBody":"bucket=${bucket}&object=${object}&etag=${etag}&size=${size}&mimeType=${mimeType}&imageInfo.height=${imageInfo.height}&imageInfo.width=${imageInfo.width}&imageInfo.format=${imageInfo.format}&my_var1=${x:var1}&my_var2=${x:var2}",
                "callbackBodyType":"application/x-www-form-urlencoded"
            }';

        // 设置发起回调请求的自定义参数，由Key和Value组成，Key必须以x:开始。
$var =
    '{
        "x:var1":"value1",
        "x:var2":"值2"
    }';
        $options = array(
            OssClient::OSS_CALLBACK => $url,
            OssClient::OSS_CALLBACK_VAR => $var
        );
        $result = $ossClient->putObject($bucket, $object, file_get_contents(__FILE__), $options);
        print_r($result['body']);
print_r($result['info']['http_code']);


      }






}
