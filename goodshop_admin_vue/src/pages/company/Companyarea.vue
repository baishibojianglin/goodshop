<template>
	<div class="area">
		<el-row>
		  <el-col :span="15">
			 <el-steps :active="active" finish-status="success" style="margin-left: 50px;margin-bottom: 50px;">
			   <el-step title="填写基本信息"></el-step>
			   <el-step title="配置销售地区"></el-step>
			   <el-step title="创建成功"></el-step>
			 </el-steps>			  
		  </el-col>
		 </el-row>


		<el-tree
		  :props="props"
		  :load="loadNode"
		  lazy
		  show-checkbox>
		</el-tree>
		
	
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
			   props: {
				 label: 'region_name',
				 children: 'zones',
				 isLeaf: 'leaf'
			   },
			   province:[], //省级
			   active: 1,  //步骤条
		   }
     },

     methods: {

		  /**
		   * 步骤条
		   */
		  next(){
			if (this.active++ > 2) this.active = 0;
		  },
		  /**
		   * 展示tree数据结构
		   * @param {Object} node
		   * @param {Object} resolve
		   */
		  loadNode(node, resolve) {
			//向后台请求地区数据
			let self=this;
			let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
			this.$axios.post(this.$url+'companyarea',{
				 companyid:company.company_id  //获取登录账号所属的供应商id
			}).then(function(res){
				//向一级tree赋值
				res.data.data.forEach((value,index)=>{
					self.province.push({region_name:value.region_name});
				})
				//插件默认方法
				if (node.level === 0) {
				  return resolve(self.province);
				}
				if (node.level > 1) return resolve([]);

				setTimeout(() => {
				  const data = [{
					name: 'leaf',
					leaf: true
				  }, {
					name: 'zone'
				  }];

				  resolve(data);
				}, 500);					
							
			})			  
			  
		   }
		  
     }
   }
 </script>  

<style>
	.area{
		padding:20px 0 50px 0;
	}
</style>
