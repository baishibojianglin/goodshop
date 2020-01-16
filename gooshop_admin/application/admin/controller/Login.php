<?php
namespace app\admin\controller;
use app\admin\model\Companyuser;
use app\common\lib\Aes;

//阿里云oss对象存储
if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}
use OSS\OssClient;
use OSS\Core\OssException;


class Login
{

	/**
	*后台登录
	*/
    public function login()
    {
      $value=input();

      //解密类实例化
      $aes=new Aes();
      //解密sign
      $sign=$aes->decrypt($value['sign']);
      if($sign!='jl_goodshop'){
        $result['status']=0;
        $result['message']='验签不正确';
        return json($result);
      }
      //解密账号和密码
      $str=$aes->decrypt($value['str']);
      //字符串分解成变量
      parse_str($str,$data);
      //账号是否为空
      if(empty($data['account'])){
        $result['status']=0;
        $result['message']='请填写账号';
        return json($result);     	
      }
      //密码是否为空
      if(empty($data['password'])){
        $result['status']=0;
        $result['message']='请填写密码';
        return json($result);     	
      }
      //验证码是否为空
      if(empty($data['verifycode'])){
        $result['status']=0;
        $result['message']='请填写验证码';
        return json($result);     	
      }
      //验证码是否正确
      if($data['verifycode']!=session('code')){
        $result['status']=0;
        $result['message']='验证码不正确';
        return json($result);         
      }
      //密码md5加密
      $data['password']=md5($data['password']);
	    //查询数据表模型类
	    $list=model('Companyuser')->checklogin($data['account'],$data['password']);
      if(empty($list)){
        $result['status']=0;
        $result['message']='账号或密码不正确';
        return json($result);         
      }
      //通过验证,生成token
      $token=md5(uniqid(mt_rand(), true)).mt_rand();
      //将token存入分公司用户表
      $lsittoken=model('Companyuser')->savetoken($list['id'],$token);
      //用aes加密token
      $token=$aes->encrypt($token);
      $list['token']=$token;
      //成功放行登录
      if(!empty($lsittoken)){
        $result['value']=$list;
        $result['status']=1;
        $result['message']='登录成功';
        return json($result);
      }
    }

  /**
  *生成登录验证码
  */
    public function createverifycode()
    {
      $result['one']=mt_rand(1,50);
      $result['two']=mt_rand(1,50);
      $result['status']=1;
      session('code', $result['one']+$result['two']);
      return json($result);     
    }


  /**
  *上传图片
  */
    public function test()
    {
        $file = request()->file('image');
       var_dump($file->getInfo());
        // // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        // $accessKeyId = "LTAI4FkCSGwQHirzGvdvWqiG";
        // $accessKeySecret = "ACpMHxZXPkkl23ont4mQfzjCZKtL3L";
        // // Endpoint以杭州为例，其它Region请按实际情况填写。
        // $endpoint = "http://oss-cn-chengdu.aliyuncs.com";
        // // 存储空间名称
        // $bucket = "goodshopimages";

        // $object = 'test.jpg';
        // $content = $file;

        // try {
        //     $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        //     $ossClient->putObject($bucket, $object, $content);
        // } catch (OssException $e) {
        //     print $e->getMessage();
        // }

      }



}
