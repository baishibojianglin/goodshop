<template>
	<div class="login loginbg">
		<el-row>
		  <el-col :span="24" style="background-image: ;">
			  <div class="title font2">后台管理系统</div>
		  </el-col>
		  <el-col :span="24">
		  	  <div class="content">
				  <div class="count">
					 <el-input v-model="count" type="text" placeholder="请输入账号"></el-input>
				  </div>
				  <div class="count">
				  	 <el-input v-model="password" type="password" placeholder="请输入密码"></el-input>
				  </div>
				  <div class="checkcode">
				  	 <el-input style="width: 188px;" v-model="verifycode" type="text"  placeholder="输入验证码"></el-input>
					 <el-button style="width:112px; margin: 20px 0;" type="success" plain>{{tips}}</el-button>
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
	    data() {
	      return {
	        count: '',
			password:'',
			verifycode:'',
			tips:'获取验证码'
	      }
	    },
        methods:{
			login(){
				//数据加密
			  	let str=aes.Encrypt('count='+this.count+'&password='+this.password+'&verifycode='+this.verifycode);
				let sign=aes.Encrypt(this.$sign);
				//数据提交
				this.$axios.post(this.$url+'login',{
					str:str,
					sign:sign
				}).then(function(res){
					console.log(res.data)
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
	}
	.content{
        width:30%;
		margin: 30px auto;
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
