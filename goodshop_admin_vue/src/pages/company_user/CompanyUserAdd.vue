<template>
	<div class="company_user_add">
		<el-card class="main-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20" type="flex" justify="space-between">
					<el-col :span="6"><span>新增供应商用户</span></el-col>
					<el-col :span="3">
						<el-button size="mini" icon="el-icon-back" title="返回" @click="back()">返回</el-button>
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- Form 表单 s -->
				<el-form ref="ruleForm" :model="form" :rules="rules" label-width="100px" size="small" class="demo-form-inline">
					<el-form-item label="供应商" prop="company_id">
						<el-select v-model="form.company_id" :disabled="companySelectDisabled" placeholder="请选择…" filterable>
							<el-option :key="0" label="平台" :value="0"></el-option>
							<el-option
								v-for="item in companyOptions"
								:key="item.id"
								:label="item.name"
								:value="item.id">
							</el-option>
						</el-select>
					</el-form-item>
					<el-form-item prop="user_name" label="供应商用户名称">
						<el-input v-model="form.user_name" placeholder="输入供应商用户名称" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="avatar" label="证件照(头像)">
						<el-input v-model="form.avatar" v-show="false" style="width:350px;"></el-input>
						<el-upload :action="this.$url+'upload'" name="avatar" :on-success="handleUploadSuccess" :limit="1">
						<el-button size="medium" type="primary" plain icon="el-icon-upload">上传证件照</el-button>
						</el-upload>
					</el-form-item>
					<el-form-item prop="account" label="供应商用户账号">
						<el-input v-model="form.account" placeholder="输入供应商用户账号" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="phone" label="电话号码">
						<el-input v-model="form.phone" placeholder="输入供应商用户电话号码" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="ratio" label="提成比例">
						<el-input v-model="form.ratio" placeholder="输入供应商用户提成比例" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item>
						<el-button type="primary" plain @click="submitForm('ruleForm')">提交</el-button>
						<el-button plain @click="resetForm('ruleForm')">重置</el-button>
					</el-form-item>
				</el-form>
				<!-- Form 表单 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: {
					company_id: '', // 供应商ID
					user_name: '', // 供应商用户名称
					avatar: '', // 供应商用户证件照
					account: '', // 供应商用户账号
					phone: '', // 电话号码
					ratio: '', // 提成比例
				},
				rules: { // 验证规则
					user_name: [
						{ required: true, message: '请输入供应商用户名称', trigger: 'blur' },
						{ min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur' }
					],
					account: [
						{ required: true, message: '请输入供应商用户账号', trigger: 'blur' },
						{ min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur' }
					],
					/* avatar: [
						{ required: true, message: '请上传供应商用户证件照', trigger: 'blur' }
					] */
				},
				companyOptions: [], // 供应商下拉框列表
				companySelectDisabled: false, // 供应商下拉框禁用状态
			}
		},
		created() {
			this.getCompanyTree(); // 获取供应商列表树
			
			// 供应商ID
			this.form.company_id = JSON.parse(localStorage.getItem('company')).company_id;
			if (this.form.company_id != 0) {
				this.companySelectDisabled = true;
			}
		},
		methods: {
			/**
			 * 获取供应商列表树
			 */
			getCompanyTree() {
				let self = this;
				this.$axios.get(this.$url + 'company_tree')
				.then(function(res) {
					if (res.data.status == 1) {
						self.companyOptions = res.data.data;
					} else {
						self.$message({
							message: '网络忙，请重试',
							type: 'warning'
						});
					}
				})
				.catch(function (error) {
					self.$message({
						message: error.response.data.message,
						type: 'warning'
					});
				});
			},
			
			/**
			 * 新增供应商用户提交表单
			 * @param {Object} formName
			 */
			submitForm(formName) {
				let self = this;
				this.$refs[formName].validate((valid) => {
					if (valid) {
						this.$axios.post(this.$url + 'company_user', {
							// 参数
							company_id: this.form.company_id,
							user_name: this.form.user_name,
							avatar: this.form.avatar,
							account: this.form.account,
							phone: this.form.phone,
							ratio: this.form.ratio
						}, {
							// 请求头配置
							headers: {
								'company-user-id': JSON.parse(localStorage.getItem('company')).user_id,
								'company-user-token': JSON.parse(localStorage.getItem('company')).token
							}
						})
						.then(function(res) {
							let type = res.data.status == 1 ? 'success' : 'warning';
							self.$message({
								message: res.data.message,
								type: type
							});
							self.$router.go(-1); // 返回上一页
						})
						.catch(function (error) {
							self.$message({
								message: error.response.data.message,
								type: 'warning'
							});
						});
					} else {
						self.$message({
							message: 'error submit!!',
							type: 'warning',
						});
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
			 * 返回上一页
			 */
			back(){
				this.$router.go(-1);
			},
			
			/**
			 * 文件上传成功时的钩子
			 * @param {Object} response
			 * @param {Object} file
			 * @param {Object} fileList
			 */
			handleUploadSuccess(response, file, fileList){
				console.log(file);
			}
		}
	}
</script>

<style>
</style>
