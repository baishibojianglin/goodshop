<template>
	<div class="login loginbg">
		<el-row>
		  <el-col :span="24" class="title font2">后台管理系统</el-col>
		  <el-col :span="24">
		  	  <div class="content">
				  <div class="count">
					 <el-input v-model="account" type="text" placeholder="请输入账号"></el-input>
				  </div>
				  <div class="count">
				  	 <el-input v-model="password" type="password" placeholder="请输入密码"></el-input>
				  </div>
				  <div class="checkcode">
				  	 <el-input style="width: 188px;" v-model="verifycode" type="text"  placeholder="输入验证码"></el-input>
					 <el-button @click='getverifycode()' style="width:112px; margin: 20px 0;" type="success" plain>{{tips}}</el-button>
				  </div>
				  <div class="count">
				  	 <el-button style="width: 300px;" type="success" @click="login()">登录</el-button>
				  </div>
			  </div>
		  </el-col>
		</el-row>
	</div>
</template>

<script>
	  import aes from '@/assets/js/aes.js'  
	  export default {
	    data(){
	      return {
	        account:'admin',  //登录账号
			password:'111111',  //登录密码
			verifycode:'', //验证码
			tips:'获取验证码'  //验证码框提示信息
	      }
	    },
        methods:{
			/**
			 * 获取验证码
			 */
			getverifycode(){
				self=this;
				this.$axios.get(this.$url+'code').then(function(res){
					if(res.data['status']==1){   //成功获取验证码
					   self.tips=res.data['one']+'+'+res.data['two']+'=?';	
					}else{   //获取验证码失败
					   self.$message({
						 message: '网络忙，请重试',
						 type: 'warning'
					   });
					}					
				})
			},
			/**
			 * 提交登录
			 */
			login(){
				let self=this;			
				//前台验证账号
				if(self.account==''){
				   self.$message({
					 message:'请填写账号',
					 type: 'warning'
				   });
				   return false;
				}
				//前台验证密码
				if(self.password==''){
				   self.$message({
					 message:'请填写密码',
					 type: 'warning'
				   });
				   return false;
				}
				//前台验证验证码
				if(self.verifycode==''){
				   self.$message({
					 message:'请填写验证码',
					 type: 'warning'
				   });
				   return false;
				}
				//数据加密
			  	let str=aes.Encrypt('account='+this.account+'&password='+this.password+'&verifycode='+this.verifycode);
				let sign=aes.Encrypt(this.$sign);
				//数据提交
				this.$axios.post(this.$url+'login',{
					str:str,
					sign:sign
				}).then(function(res){
					if(res.data['status']==0){ //验证未通过
					   self.$message({
						 message:res.data['message'],
						 type: 'warning'
					   });						
					}else{  //登录成功
					   //前端存储token、分公司（供应商）id、分公司（供应商）名字等存入缓存
					    localStorage.setItem("company",JSON.stringify(res.data.value));
					   //跳转首页
					    self.$router.replace({path:'/home'});		
					}					
				})
			}
		}	
		
	  }
</script>

<style>
	.login{
		position: fixed;
		top:0;
		bottom: 0;
		left: 0;
		right: 0;		
	}
	.title{
		margin-top:10%;
		text-align: center;
	}
	.content{
        width:30%;
		margin:30px auto;
	}
	.count{
		width: 300px;
		margin:0 auto;
	}
	.count input{
		width:300px;
		margin-top:20px;
	}
	.checkcode{
		width: 300px;
		margin:0 auto;
	}
	.checkcode input{
		width: 200px;
		margin:20px 0;		
	}

</style>
