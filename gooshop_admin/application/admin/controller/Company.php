<?php
namespace app\admin\controller;
use think\Request;


class Company
{


	public function test(){
		$header=request()->header();
		return json($header);
	}


}
