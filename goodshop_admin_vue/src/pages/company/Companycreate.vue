<template>
	<div class="create">
		 <el-steps :active="active" finish-status="success">
		   <el-step title="步骤 1"></el-step>
		   <el-step title="步骤 2"></el-step>
		   <el-step title="步骤 3"></el-step>
		 </el-steps>
		
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

		   <el-form-item label="法人身份证" prop="legalperson_idcard_image">
			   <el-input v-show='false' style="width:350px;"  v-model="ruleForm.legalperson_idcard"></el-input>
			   <el-upload :action="this.$url+'upload'" :limit="1" :on-success="test" name='image'>
				  <el-button size="medium" type="primary" plain>上传身份证件正面图片</el-button>
			   </el-upload>
		   </el-form-item>
		   
		   <el-form-item label="法人姓名" prop="legalperson_name">
		   			 <el-input style="width:350px;"  v-model="ruleForm.legalperson_name"></el-input>
		   </el-form-item>

		   <el-form-item label="法人身份证号码" prop="legalperson_idcard_code">
		   			 <el-input style="width:350px;"  v-model="ruleForm.legalperson_code"></el-input>
		   </el-form-item>
		   
		   <el-form-item label="营业执照" prop="license_image">
			   <el-input v-show='false' style="width:350px;"  v-model="ruleForm.license_image"></el-input>
			   <el-upload :action="this.$url+'upload'" :limit="1" :on-success="test" name='image'>
				  <el-button size="medium" type="primary" plain>上传营业执照副本图片</el-button>
			   </el-upload>
		   </el-form-item>

		   <el-form-item label="社会统一信用码" prop="license_creditcode">
			 <el-input style="width:350px;"  v-model="ruleForm.license_creditcode"></el-input>
		   </el-form-item>		   

		   <el-form-item label="设置密码" prop="password">
			 <el-input style="width:350px;"  v-model="ruleForm.password"></el-input>
		   </el-form-item>			   



		   
		   <el-form-item>
			 <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
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
				   name: '',
				   address:'',
				   phone:'',
				   license:'',
				   creditcode:'',
				   fileList: []
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
				  license_creditcode:[
					{ required: true, message: '请输入社会统一信用码', trigger: 'blur' }	
				  ],
				  legalperson_name:[
					{ required: true, message: '请输入法人姓名', trigger: 'blur' }
				  ],
				  legalperson_idcard_image:[
					{ required: true, message: '请上传法人身份证正面照', trigger: 'blur' }
				  ],
				  legalperson_idcard_code:[
					{ required: true, message: '请填写法人身份证号码', trigger: 'blur' }
				  ],
				  license_image:[
					{ required: true, message: '请上传营业执照'}					  
				  ],
				  password:[
					{ required: true, message: '请设置密码'}					  
				  ]													  
				},
				active: 0 //步骤条
		   }
     },
     methods: {
		 /**
		  * 提交表单
		  * @param {Object} formName
		  */
		  submitForm(formName) {
			this.$refs[formName].validate((valid) => {
			  if (valid) {
				alert('submit!');
				console.log(filelist);
				this.next();
			  }else {
				console.log(this.fileList);
				this.next();
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
		  test(response, file, fileList){
			  console.log(file);
		  }
     }
   }
 </script>  

<style>
	.create{
		padding: 50px 0 20px 0;
	}
</style>
