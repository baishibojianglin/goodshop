<template>
  <div class="home">
		<el-container>
		  <el-header>
			  <el-row>
			    <el-col :span="5">
					<div class="header_title">{{name}}后台管理系统</div>
				</el-col>
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
  data(){
	return {
		name:'', //机构名字
	}  
  },
  components: {
   // HelloWorld
  },
  mounted(){
	  //显示机构名字
	  this.name=this.$route.params['name'];
  }
}
</script>
<style>
	.el-header{
		background-color: #181C31;
		color:#FFFFFF;
	}
	.header_title{
         line-height:50px;
		 text-align: left;
	}
</style>
