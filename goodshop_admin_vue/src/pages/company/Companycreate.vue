<template>
	<div class="create">
		<el-row>
		  <el-col :span="15">
			 <el-steps :active="active" finish-status="success" style="margin-left: 50px;margin-bottom: 50px;">
			   <el-step title="填写基本信息"></el-step>
			   <el-step title="填写配置信息"></el-step>
			   <el-step title="创建成功"></el-step>
			 </el-steps>			  
		  </el-col>
		 </el-row>

		
		 <el-form  ref="ruleForm" :model="ruleForm" :rules="rules"  label-width="150px">
			 
		   <el-form-item label="供应商名称" prop="name">
			 <el-input style="width:350px;"  v-model="ruleForm.name"></el-input>
		   </el-form-item>

		   <el-form-item label="供应商地址" prop="address">
			 <el-input style="width:350px;"  v-model="ruleForm.address"></el-input>
		   </el-form-item>

		   <el-form-item label="联系电话" prop="phone">
			 <el-input style="width:350px;"  v-model="ruleForm.phone"></el-input>
		   </el-form-item>

		   <el-form-item label="法人身份证" prop="url_idcard" class="idcard">
			   <el-input v-show='false' style="width:350px;"  v-model="ruleForm.url_idcard"></el-input>
			   <el-upload :class="{hide:hideUpload[0]}" list-type="picture-card" :action="this.$url+'upload?name=image'" :limit="1" :on-success="function (res,file,fileList) { return returnUrl(res,file,fileList,'url_idcard',0)}" :on-change="function (file,fileList) { return delePlusButton(file,fileList,1,0)}"  :on-remove="function (file,fileList) { return handleRemove(file,fileList,0,1,'url_idcard')}" :on-preview="handlePictureCardPreview"  name='image'>
				     <i class="el-icon-circle-plus-outline" style="font-size: 14px;"> 上传正面照</i>
			   </el-upload>
			   <el-dialog :visible.sync="dialogVisible">
			     <img width="100%" :src="dialogImageUrl" alt="">
			   </el-dialog>
		   </el-form-item>
	   
		   <el-form-item label="法人姓名" prop="legalperson_name">
		   			 <el-input style="width:350px;"  v-model="ruleForm.legalperson_name"></el-input>
		   </el-form-item>

		   <el-form-item label="法人身份证号码" prop="legalperson_idcard_code">
		   			 <el-input style="width:350px;"  v-model="ruleForm.legalperson_code"></el-input>
		   </el-form-item>
		   		   
		   <el-form-item label="营业执照" prop="url_license" class="license">
			   <el-input v-show='false' style="width:350px;"  v-model="ruleForm.url_license"></el-input>
			   <el-upload :class="{hide:hideUpload[1]}" list-type="picture-card" :action="this.$url+'upload?name=image'" :limit="1" :on-success="function (res,file,fileList) { return returnUrl(res,file,fileList,'url_license',1)}" :on-change="function (file,fileList) { return delePlusButton(file,fileList,1,1)}"  :on-remove="function (file,fileList) { return handleRemove(file,fileList,1,1,'url_license')}" :on-preview="handlePictureCardPreview"  name='image'>
				     <i class="el-icon-circle-plus-outline" style="font-size: 14px;"> 上传营业执照</i>
			   </el-upload>
			   <el-dialog :visible.sync="dialogVisible">
			     <img width="100%" :src="dialogImageUrl" alt="">
			   </el-dialog>
		   </el-form-item>  
		   
		   
		   

		   <el-form-item label="社会统一信用码" prop="license_creditcode">
			 <el-input style="width:350px;"  v-model="ruleForm.license_creditcode"></el-input>
		   </el-form-item>		   

		   <el-form-item label="登录账号" prop="account">
			 <el-input style="width:350px;"  v-model="ruleForm.account"></el-input>
		   </el-form-item>

		   <el-form-item label="设置密码" prop="password">
			 <el-input style="width:350px;" type="password" :show-password="true"   v-model="ruleForm.password"></el-input>
		   </el-form-item>			   

		   
		   <el-form-item>
			 <el-button type="primary" @click="submitForm('ruleForm')">下一步</el-button>
			 <el-button @click="resetForm('ruleForm')">重置</el-button>
		   </el-form-item>
		   
		   
		 </el-form>    
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
				ruleForm: {
				   name: '1', //供应商名字
				   address:'1', //供应商地址
				   phone:'1', //供应商联系电话
			       url_idcard:'1', //身份证正面图片地址
				   legalperson_name:'1', //法人姓名
				   legalperson_idcard_code:'1', //法人身份证号码
				   url_license:'1', //营业执照图片地址
				   license_creditcode:'1', //营业执照社会统一信用码
				   account:'2', //登录账号
				   password:'1' ,//供应商密码
				   upid:'78'
				},
				rules: {
				  name: [
					{ required: true, message: '请输入供应商名称', trigger: 'blur' }
				  ],
				  address:[
					{ required: true, message: '请输入供应商地址', trigger: 'blur' }					  
				  ],
				  phone:[
					{ required: true, message: '请输入供应商电话', trigger: 'blur' }					  
				  ],
				  url_idcard:[
					{ required: true, message: '请上传法人身份证正面照' }
				  ],
				  legalperson_name:[
					{ required: true, message: '请输入法人姓名', trigger: 'blur' }
				  ],
				  legalperson_idcard_code:[
					{ required: true, message: '请填写法人身份证号码', trigger: 'blur' }
				  ],
				  url_license:[
					{ required: true, message: '请上传营业执照'}					  
				  ],																		
				  license_creditcode:[
					{ required: true, message: '请输入社会统一信用码', trigger: 'blur' }	
				  ],
				  account:[
				  	{ required: true, message: '请设置登录账号',trigger: 'blur'}					  
				  ],
				  password:[
					{ required: true, message: '请设置密码',trigger: 'blur'}					  
				  ]													  
				},
				dialogImageUrl: '',
				dialogVisible: false, //放大预览图片
				active: 0,  //步骤条
				img_name:[], //存储图片名字
				hideUpload:[false,false] //隐藏图片添加按钮
		   }
     },
     methods: {
		  /**
		  * 提交表单
		  * @param {Object} formName
		  */
		  submitForm(formName) {
			let company=JSON.parse(localStorage.getItem('company'));
			//this.ruleForm['upid']=company.upid;
			this.$refs[formName].validate((valid) => {
			  if (valid) {
				this.$axios.post(this.$url+'createCompany',{
				   data:this.ruleForm
				}).then(function(res){	
                   console.log(res.data)
				})                
				this.next();
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
		   * @param {string} url_name 图片地址变量名
		   * @param {string} index 上传组件索引
		   */
		  returnUrl(response, file, fileList,url_name,index){
			  this.ruleForm[url_name]=response['url'];
			  this.$set(this.img_name,index,response['name']);
		  },
          /**
		   * 删除图片上传完后的添加按钮
		   * @param {Object} file
		   * @param {Object} fileList
		   * @param {Object} num 允许上传的图片张数
		   * @param {string} index 上传组件索引
		   */
		  delePlusButton(file,fileList,num,index){
			  this.$set(this.hideUpload,index,fileList.length >= num);
		  },
		  /**
		   * 删除图片
		   * @param {Object} file
		   * @param {Object} fileList
		   * @param {string} index 上传组件索引
		   * @param {Object} num 允许上传的图片张数
		   * @param {string} url_name 图片地址变量名
		   */
		   handleRemove(file,fileList,index,num,url_name) {
			    let self=this;
				//删除oss上的图片
				this.$axios.post(this.$url+'deleteimages',{
					name:self.img_name[index]
				}).then(function(res){	
					self.$set(self.hideUpload,index,fileList.length >= num);
					self.ruleForm[url_name]='';
				})			   
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
	.create{
		padding:20px 0 50px 0;
	}
	.el-upload-list{
		width: 180px;
	}
	.idcard .el-upload-list--picture-card .el-upload-list__item{
		width: 190px;
		height: 120px;
		line-height: 120px;
	}
	.idcard .el-upload--picture-card {
		width: 190px;
		height: 120px;
		line-height: 120px;
	}
	.license .el-upload-list--picture-card .el-upload-list__item{
		width: 120px;
		height: 170px;
		line-height: 170px;
	}
	.license .el-upload--picture-card {
		width: 120px;
		height: 170px;
		line-height: 170px;
	}
	.hide .el-upload--picture-card {
		display: none;
	}
</style>
