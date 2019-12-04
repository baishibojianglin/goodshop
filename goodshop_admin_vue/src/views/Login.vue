<template>
	<div class="login loginbg">
		<el-row>
		  <el-col :span="24" style="background-image: ;">
			  <div class="title font2">供销联盟后台管理系统</div>
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
				  	 <el-input v-model="password" type="number" placeholder="输入验证码"></el-input>
					 <el-button type="success" plain>成功按钮</el-button>
				  </div>
			  </div>
		  </el-col>
		</el-row>
	</div>
</template>

<script>
	  export default {
	    data() {
	      return {
	        count: '',
			password:''
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
		width:30%;
		margin: 20px auto;
	}
	.checkcode input{
		width: 180px;
	}
</style>
