<template>
  <div class="home">
<!--    <img alt="Vue logo" src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/> -->
		<el-container>
		  <el-header>
			  <el-row>
			    <el-col :span="5">后台管理系统</el-col>
			  </el-row>
		  </el-header>
		  <el-container>
			<el-aside width="200px">Aside</el-aside>
			<el-container>
			  <el-main>Main</el-main>
			  <el-footer>Footer</el-footer>
		    </el-container>
		  </el-container>
		</el-container>		
  </div>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'home',
  components: {
   // HelloWorld
  }
}
</script>
<style>
	.el-header{
		background-color: #181C31;
		color:#FFFFFF;
	}
</style>
