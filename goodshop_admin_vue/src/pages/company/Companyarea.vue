<template>
	<div class="area">
		<el-row>
		  <el-col :span="15">
			 <el-steps :active="active" finish-status="success" style="margin-left: 50px;margin-bottom: 20px;">
			   <el-step title="填写基本信息"></el-step>
			   <el-step title="配置销售地区"></el-step>
			   <el-step title="创建成功"></el-step>
			 </el-steps>			  
		  </el-col>
		 </el-row>
		 
	     <el-row>
			  <el-col :span="15" style="margin-left: 50px;">
					<el-form  ref="ruleForm" :model="ruleForm" :rules="rules"  label-width="0px">
						
				       <p>勾选可销售地区：</p>
					   <el-tree :props="props" :load="loadNode" empty-text='' lazy show-checkbox></el-tree> 
                      
					   <p v-show="loadfinish" >上传销售凭证：</p>
					   <el-form-item v-if="loadfinish"   label="" prop="url_sale">
						   <el-input v-show='false'  v-model="ruleForm.url_sale"></el-input>
						   <el-upload  list-type="picture-card" :action="this.$url+'upload?name=image'"  :on-preview="handlePictureCardPreview"  name='image'>
								 <i class="el-icon-circle-plus-outline" style="font-size: 14px;"> 上传凭证</i>
						   </el-upload>
						   <el-dialog :visible.sync="dialogVisible">
							 <img width="100%" :src="dialogImageUrl" alt="">
						   </el-dialog>
					   </el-form-item>	
															  
					   <el-form-item v-show="loadfinish">
						 <el-button type="primary" @click="submitForm('ruleForm')">下一步</el-button>
						 <el-button @click="resetForm('ruleForm')">重置</el-button>
					   </el-form-item>																															
															  
					</el-form>    
			  </el-col>
		 </el-row>		 
	 


		
	
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
			    active: 1,  //步骤条
			    companyid:'', //登录账号所属供应商
				parent_id:'', //地区父级id
				level:'', //层级
				loadfinish:false, //地区是否加载完成
				props: {
				  label: 'region_name',
				  isLeaf: 'leaf'
				},
				ruleForm: {
				   url_sale: '', //凭证图片地址
				},
				rules: {
				  url_sale: [
					{ required:true, message: '请上传凭证图片', trigger: 'blur' }
				  ],											  
				},
				dialogImageUrl: '',
				dialogVisible: false, //放大预览图片


		    }
     },
	 mounted(){
		 let self=this;
		 let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
		 this.companyid=company.company_id; //获取登录账号所属的供应商id
		 	     
	 },

     methods: {
		  /**
		  * 提交表单
		  * @param {Object} formName
		  */
		  submitForm(formName) {
			let self=this;
			console.log(this.ruleForm)
			// this.$refs[formName].validate((valid) => {
			//   if (valid) {
			// 	this.$axios.post(this.$url+'createCompany',{
			// 	   data:this.ruleForm
			// 	}).then(function(res){
   //                 if(res.data.status==1){
			// 		 self.$message({
			// 			 message:'基本信息添加成功',
			// 			 type: 'warning'
			// 		  });
			// 		  self.$router.push({path: "companyarea", query: {companyid:res.data.companyid}});
			// 		  self.next(); 
			// 	   }
			// 	})                
			//   }else {
			// 	return false;
			//   }
			// });
		  },
		  /**
		   * 重置表单
		   * @param {Object} formName
		   */
		  resetForm(formName) {
			this.$refs[formName].resetFields();
		  },
		  /**
		   * 步骤条
		   */
		  next(){
			if (this.active++ > 2) this.active = 0;
		  },
         /**
		  * 获取tree形数据
		  * @param {Object} node
		  * @param {Object} resolve
		  */
		  loadNode(node, resolve) {	
			let self=this;
			let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
			this.companyid=company.company_id; //获取登录账号所属的供应商id
			if(node.data){
				this.parent_id=node.data.region_id;
				this.level=node.data.level+1;
			}else{
				this.parent_id=0;
				this.level=1;
			}
			//平台账号
			if(this.companyid==1){ 
				this.$axios.post(this.$url+'platformarea',{
					 parent_id:this.parent_id,
					 level:this.level
				}).then(function(res){
					    self.loadfinish=true; //地区加载显示完成
					    if(self.level==4){ //第四级时不再显示三角形
							res.data.data.forEach((value,index)=>{
								value.leaf=true;
							})
						}
						if (node.level === 0) {
						  return resolve(res.data.data);
						}
						if (node.level > 1) return resolve(res.data.data);

						setTimeout(() => {
						  const data = res.data.data;		
						  resolve(data);
						}, 500);							
									
				})		
				
			}		  		
		  },
		  /**
			* 放大图片
			* @param {Object} file
		  */
		  handlePictureCardPreview(file) {
		  			  this.dialogImageUrl = file.url;
		  			  this.dialogVisible = true;
		  }

		  
     }
   }
 </script>  

<style>
	.area{
		padding:20px 0 50px 0;
	}

</style>
