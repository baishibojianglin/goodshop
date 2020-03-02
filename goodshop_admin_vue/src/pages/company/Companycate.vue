<template>
	<div class="area">
		<el-row>
		  <el-col :span="22">
			 <el-steps :active="active" finish-status="success" style="margin-left: 50px;margin-bottom: 20px;">
			   <el-step title="填写基本信息"></el-step>
			   <el-step title="配置销售地区"></el-step>
			   <el-step title="配置商品种类"></el-step>
			   <el-step title="创建成功"></el-step>
			 </el-steps>			  
		  </el-col>
		 </el-row>
		 
	     <el-row>
			  <el-col :span="15" style="margin-left: 50px;">
					<el-form  ref="ruleForm" :model="ruleForm" :rules="rules"  label-width="0px">
						
				       <p><span style="color:#f00;">*</span> 设置商品提成比例：</p>
					   <el-tree  ref="tree" :expand-on-click-node="false" :props="props" :load="loadNode" empty-text='' lazy>
						   <span  slot-scope="{ node, data }">
							   <span>{{ node.label }}</span>
							   <input class="treeinput" type="number" v-model='data.ratio' /> ‰
						   </span>
					   </el-tree> 
                      
<!-- 					   <p v-show="loadfinish"><span style="color:#f00;">*</span> 上传销售凭证：</p>
					   <el-form-item v-if="loadfinish"   label="" prop="url_sale">
						   <el-input v-show='false'  v-model="ruleForm.url_sale"></el-input>
						   <el-upload  list-type="picture-card" :action="this.$url+'upload?name=image'"  :on-success="returnUrl"  :on-preview="handlePictureCardPreview"  name='image'>
								 <i class="el-icon-circle-plus-outline" style="font-size: 14px;"> 上传凭证</i>
						   </el-upload>
						   <el-dialog :visible.sync="dialogVisible">
							 <img width="100%" :src="dialogImageUrl" alt="">
						   </el-dialog>
					   </el-form-item> -->	
															  
					   <el-form-item v-show="loadfinish" style="margin-top: 20px;">
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
			    active: 2,  //步骤条
			    companyid:'', //登录账号所属供应商
				parent_id:'', //种类父级id
				level:'', //层级
				loadfinish:false, //种类是否加载完成
				props: {
				  label: 'cate_name',
				  isLeaf: 'leaf'
				},
				ruleForm: {
				   //url_sale: '' , //凭证图片地址
				   salecate:'', //种类数据 
				   id:this.$route.query.companyid ,//新建的该供应商id
				   step:3 //创建进度
				},
				rules: {
				 //  url_sale: [
					// { required:true, message: '请上传凭证图片', trigger: 'blur' }
				 //  ]											  
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
         getCheckedAll(e){

           return this.$refs.tree.filter(function (e) {
              if(e.node.indeterminate){
                  return e.node.indeterminate
              }
			  console.log(e.node.indeterminate)
              return e.node.checked
          }).map(function (e) {
          //map高阶函数处理map之前的数据并将处理好的数据返回一个新的数组
		  console.log(e.node.indeterminate)
              return e.node
          })

          },

		 
		  /**
		  * 提交表单
		  * @param {Object} formName
		  */
		  submitForm(formName) {
			 let self=this;
             self.ruleForm.salecate='';
			this.getCheckedAll();
			return false;
			 //获取全选的数据
			 this.$refs.tree.getCheckedNodes().forEach((value,index)=>{
			 	self.ruleForm.salearea=self.ruleForm.salearea+value.region_id+'|';
			 })
			 //获取半选的数据
			 this.$refs.tree.getHalfCheckedKeys().forEach((value,index)=>{
			 	self.ruleForm.salearea=self.ruleForm.salearea+value.region_id+'|';
			 })
			 //去除最后一个符号"|"
			 self.ruleForm.salearea=self.ruleForm.salearea.slice(0,-1);
			 //验证销售地区
			 if(self.ruleForm.salearea==''){
				 self.$message({
				 					 message:'请勾选销售地区',
				 					 type: 'warning'
				 });
				 return false;
			 }
             //提交数据
			this.$refs[formName].validate((valid) => {
			  if (valid) {
				this.$axios.post(this.$url+'companyareainsert',{
				   data:this.ruleForm
				}).then(function(res){
                   if(res.data.status==1){
					  self.$message({
						 message:'销售地区配置成功',
						 type: 'success'
					  });
					  self.$router.push({path: "companyarea", query: {companyid:res.data.companyid}});
					  self.next(); 
				   }
				})                
			  }else {
				return false;
			  }
			});
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
		   * 上传图片
		   * @param {string} response  返回图片地址
		   * @param {Object} file
		   * @param {Object} fileList
		   */
		  returnUrl(response, file, fileList){
			  if(this.ruleForm.url_sale==''){
				  this.ruleForm.url_sale=response['url'];  //一张图
			  }else{
				  this.ruleForm.url_sale=this.ruleForm.url_sale+'|'+response['url']; //多张图
			  }
		  },
         /**
		  * 获取tree形数据
		  * @param {Object} node
		  * @param {Object} resolve
		  */
		  loadNode(node, resolve) {	
			  
			    let self=this;
				if(node.data){  //逐级查询
					this.parent_id=node.data.cate_id;
				}else{ //首次进入页面默认设置查询第一级地域
					this.parent_id=0;
				}	
		    
				this.$axios.post(this.$url+'getshopcate',{
					 parent_id:this.parent_id
				}).then(function(res){
					   //添加提成比例属性
					    res.data.data.forEach((value,index)=>{
							value.ratio='';
						})
					    if(res.data.data.length==0){
							self.$message({
								 message:'已无下级分类',
								 type: 'warning'
							});
						}
					    self.loadfinish=true; //种类加载显示完成
						if (node.level === 0) {
						  return resolve(res.data.data);
						}
						if (node.level > 1) return resolve(res.data.data);

						setTimeout(() => {
						  const data = res.data.data;		
						  resolve(data);
						}, 500);							
									
				})		
				
					  		
		  },
		  /**
			* 放大图片
			* @param {Object} file
		  */
		  handlePictureCardPreview(file) {
		  			  this.dialogImageUrl = file.url;
		  			  this.dialogVisible = true;
		  },

		  
		  
     }
   }
 </script>  

<style>
	.area{
		padding:20px 0 50px 0;
	}
	.treeinput{
		border:1px solid #ccc;
		border-radius:3px;
		width: 50px;
		line-height: 16px;
		margin-left: 10px;
		text-align: center;
	}
	input::-webkit-outer-spin-button,input::-webkit-inner-spin-button {
	    -webkit-appearance: none;
	}	 
	input[type="number"] {
	    -moz-appearance: textfield;
	}

</style>
