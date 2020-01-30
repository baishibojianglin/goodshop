<template>
	<div class="goods_brand">
		<el-card class="main-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20" type="flex" justify="space-between">
					<el-col :span="6"><span>品牌列表</span></el-col>
					<el-col :span="6">
						<!-- 查询 s -->
						<el-form :inline="true" :model="formInline" size="mini" class="demo-form-inline">
							<el-form-item label="">
								<el-input placeholder="查询品牌" v-model="formInline.brand_name" clearable>
									<el-button slot="append" icon="el-icon-search" @click="getGoodsBrandList()"></el-button>
								</el-input>
							</el-form-item>
						</el-form>
						<!-- 查询 e -->
					</el-col>
					<el-col :span="12">
						<!-- 新增 s -->
						<router-link to="goodsbrandadd"><el-button size="mini" icon="el-icon-plus">新增品牌</el-button></router-link>
						<!-- 新增 e -->
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- 商品品牌列表 s -->
				<el-table :data="goodsBrandList" border style="width: 100%">
					<el-table-column label="ID" fixed width="90">
						<template slot-scope="scope"><span>{{scope.$index + 1}}</span></template>
					</el-table-column>
					<el-table-column prop="brand_name" label="品牌名称" fixed min-width="180"></el-table-column>
					<el-table-column prop="logo" label="logo" width="180"></el-table-column>
					<el-table-column prop="audit_status" label="审核状态" width="90" :filters="[{ text: '待审核', value: 0 }, { text: '正常', value: 1 }, { text: '驳回', value: 2 }]" :filter-method="filterAuditStatus" filter-placement="bottom-end">
						<template slot-scope="scope">
							<el-tag :type="scope.row.audit_status === 0 ? 'info' : (scope.row.audit_status === 1 ? 'success' : 'danger')" size="mini">{{scope.row.audit_status_msg}}</el-tag>
						</template>
					</el-table-column>
					<el-table-column label="操作" fixed="right" min-width="120">
						<template slot-scope="scope">
							<el-button type="primary" size="mini" plain @click="dialogFormVisible = true; form.cate_id = scope.row.cate_id; tableRowIndex = scope.$index" style="margin-left: 0.5rem;">审核</el-button>
							<el-button type="primary" size="mini" plain @click="toGoodsCateEdit(scope.row)">编辑</el-button>
							<el-button type="danger" size="mini" plain @click="deleteGoodsCate(scope)">删除</el-button>
						</template>
					</el-table-column>
				</el-table>
				<!-- 商品品牌列表 e -->
				
				<!-- 分页 s -->
				<div>
					<el-pagination
						background
						:page-sizes="[5, 10, 15, 20]"
						:page-size="goodsCatePagination.per_page"
						:total="goodsCatePagination.total"
						:current-page="goodsCatePagination.current_page"
						layout="total, sizes, prev, pager, next, jumper"
						@size-change="handleSizeChange"
						@current-change="handleCurrentChange">
					</el-pagination>
				</div>
				<!-- 分页 e -->
				
				<!-- 审核商品品牌 Dialog 对话框 s，放在“审核”按钮后边交互效果差 -->
				<el-dialog title="审核" :visible.sync="dialogFormVisible" width="30%" :destroy-on-close="true">
					<el-form ref="ruleForm" :model="form" :rules="rules" size="small">
						<el-form-item label="审核状态" prop="audit_status" label-width="120px">
							<el-select v-model="form.audit_status" placeholder="请选择…">
								<el-option :key="1" label="通过" :value="1"></el-option>
								<el-option :key="2" label="驳回" :value="2"></el-option>
							</el-select>
						</el-form-item>
					</el-form>
					<div slot="footer" class="dialog-footer">
						<el-button size="small" plain @click="dialogFormVisible = false">取 消</el-button>
						<el-button type="primary" size="small" plain @click="auditGoodsCate('ruleForm')">确 定</el-button>
					</div>
				</el-dialog>
				<!-- 审核商品品牌 Dialog 对话框 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				formInline: {
					brand_name: '' // 商品品牌名称
				},
				goodsBrandList: [], // 商品品牌列表
				goodsBrandPagination: {}, // 商品类别列表分页参数
				
				/* Dialog 对话框 s */
				dialogFormVisible: false, // 是否显示 Dialog
				form: { // Dialog 嵌套审核商品类别操作的表单数据对象
					brand_id: '',
					audit_status: ''
				},
				rules: { // 验证规则
					audit_status: [
						{ required: true, message: '请选择审核状态', trigger: 'change' }
					]
				},
				tableRowIndex: '' // 表格行序号
				/* Dialog 对话框 e */
			}
		},
		mounted() {
			this.getGoodsBrandList(); // 获取商品品牌列表
		},
		methods: {
			/**
			 * 获取商品品牌列表
			 */
			getGoodsBrandList() {
				let self = this;
				this.$axios.get(this.$url + 'goods_brand', {
					params: {
						cate_name: this.formInline.cate_name,
						page: this.goodsCatePagination.current_page,
						size: this.goodsCatePagination.per_page
					},
					headers: {
						'company-id': JSON.parse(localStorage.getItem('company')).id,
						'company-token': JSON.parse(localStorage.getItem('company')).token
					}
				})
				.then(function(res) {console.log(res)
					if (res.data.status == 1) {
						// 商品类别列表分页参数
						self.goodsCatePagination = res.data.data;
						
						// 当数据为空时
						if (self.goodsCatePagination.total == 0) {
							self.$message({
								message: '数据不存在',
								type: 'warning'
							});
							return;
						}
						
						// 商品类别列表
						let goodsBrandList = self.goodsCatePagination.data;
						goodsBrandList.forEach((item, index) => {
							if (index == 0) { // 0表示第1条数据，因每一条数据的上上级ID都相同
								self.grandparentId = item.grandparent_id; // 上上级ID是否存在时赋值
								return;
							}
						});
						self.goodsBrandList = goodsBrandList;
					} else {
						self.$message({
							message: '网络忙，请重试',
							type: 'warning'
						});
					}
				})
				.catch(function (error) {
					// 错误处理
					if (error.response) {
						console.log(error.response.data);
						console.log(error.response.status);
						console.log(error.response.headers);
					} else if (error.request) {
						console.log('error.request', error.request)
					} else {
						console.log('error.message', error.message)
					}
					console.log('error.config', error.config)
					
					self.$message({
						message: error.response.data.message,
						type: 'warning'
					});
				});
			},
			
			/**
			 * 分页 pageSize 改变时会触发
			 * @param {Object} page_size
			 */
			handleSizeChange(page_size) {
				this.goodsCatePagination.per_page = page_size; // 每页条数
				this.getGoodsCateList();
			},
			
			/**
			 * 分页 currentPage 改变时会触发
			 * @param {Object} current_page
			 */
			handleCurrentChange(current_page) {
				this.goodsCatePagination.current_page = current_page; // 当前页数
				this.getGoodsCateList();
			},
			
			/**
			 * 筛选商品品牌审核状态
			 * @param {Object} value
			 * @param {Object} row
			 */
			filterAuditStatus(value, row) {
				return row.audit_status === value;
			},
			
			/**
			 * 审核商品品牌
			 * @param {Object} formName
			 */
			auditGoodsCate(formName) {
				let self = this;
				this.$refs[formName].validate((valid) => {
					if (valid) {
						this.$axios.put(this.$url + 'goods_cate/' + this.form.cate_id, {
							audit_status: this.form.audit_status
						})
						.then(function(res) {
							let type = res.data.status == 1 ? 'success' : 'warning';
							self.$message({
								message: res.data.message,
								type: type
							});
							self.goodsBrandList[self.tableRowIndex].audit_status = self.form.audit_status; // 静态改变审核状态
							self.goodsBrandList[self.tableRowIndex].audit_status_msg = (self.form.audit_status === 0 ? '待审核' : (self.form.audit_status === 1 ? '正常' : '驳回')); // 静态改变审核状态信息
							self.dialogFormVisible = false; // 隐藏 Dialog 对话框
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
			 * 跳转商品品牌编辑页
			 * @param {Object} row
			 */
			toGoodsCateEdit(row) {
				this.$router.push({path: "goodscateedit", query: {cate_id: row.cate_id, cate_name: row.cate_name, parent_id: row.parent_id}});
			},
			
			/**
			 * 删除商品类别
			 * @param {Object} scope
			 */
			deleteGoodsCate(scope) {
				this.$confirm('此操作将永久删除该商品品牌, 是否继续?', '删除', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					// 调用删除接口
					let self = this;
					this.$axios.delete(this.$url + 'goods_cate/' + scope.row.cate_id)
					.then(function(res) {
						// 移除元素
						self.goodsBrandList.splice(scope.$index, 1);
						
						let type = res.data.status == 1 ? 'success' : 'warning';
						self.$message({
							message: res.data.message,
							type: type
						});
					})
					.catch(function (error) {
						self.$message({
							message: error.response.data.message,
							type: 'warning'
						});
					});
				}).catch(() => {
					this.$message({
						type: 'info',
						message: '已取消删除'
					});
				});
			}
		}
	}
</script>

<style>
</style>
