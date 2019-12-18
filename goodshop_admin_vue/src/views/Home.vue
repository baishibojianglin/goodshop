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
			  
			<el-aside>
				<el-row class="tac">
				  <el-col :span="12">
				    <el-menu default-active="2" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose">
				      <el-submenu index="1">
				        <template slot="title">
				          <i class="el-icon-location"></i>
				          <span>导航一</span>
				        </template>
				        <el-menu-item-group>
				          <template slot="title">分组一</template>
				          <el-menu-item index="1-1">选项1</el-menu-item>
				          <el-menu-item index="1-2">选项2</el-menu-item>
				        </el-menu-item-group>
				        <el-menu-item-group title="分组2">
				          <el-menu-item index="1-3">选项3</el-menu-item>
				        </el-menu-item-group>
				        <el-submenu index="1-4">
				          <template slot="title">选项4</template>
				          <el-menu-item index="1-4-1">选项1</el-menu-item>
				        </el-submenu>
				      </el-submenu>
				      <el-menu-item index="2">
				        <i class="el-icon-menu"></i>
				        <span slot="title">导航二</span>
				      </el-menu-item>
				      <el-menu-item index="3">
				        <i class="el-icon-setting"></i>
				        <span slot="title">导航三</span>
				      </el-menu-item>
				    </el-menu>
				  </el-col>
				</el-row>
			</el-aside>
			
			<el-container>
			  <el-main>Main</el-main>
			  <el-footer>Footer</el-footer>
		    </el-container>
		  </el-container>
		</el-container>		
		
  </div>
 
</template>

<script>


export default {
  name: 'home',
  data(){
	return {
		name:'', //机构名字
	}  
  },
  components: {
 
  },
  mounted(){
	  //显示机构名字
	  this.name=localStorage.getItem("goodshopname");

  },
  methods: {
	handleOpen(key, keyPath) {
	  console.log(key, keyPath);
	},
	handleClose(key, keyPath) {
	  console.log(key, keyPath);
	}
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
