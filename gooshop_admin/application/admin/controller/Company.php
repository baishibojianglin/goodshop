<?php
namespace app\admin\controller;
use think\Request;


class Company 
{
   /**
   *创建供应商
   */
	public function submitCompany(){
		$form=input();
		$data=model('Company')->inCompany($form['data']);
		//return json($data);
	}


}
