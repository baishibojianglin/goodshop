<template>
	<div class="goods_cate">
		<el-card class="main-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20" type="flex" justify="space-between">
					<el-col :span="6"><span>商品类别列表</span></el-col>
					<el-col :span="6">
						<!-- 查询 s -->
						<el-form :inline="true" :model="formInline" size="mini" class="demo-form-inline">
							<el-form-item label="">
								<el-input placeholder="查询商品类别" v-model="formInline.cate_name" clearable>
									<el-button slot="append" icon="el-icon-search" @click="getGoodsCateList(formInline.cate_name)"></el-button>
								</el-input>
							</el-form-item>
						</el-form>
						<!-- 查询 e -->
					</el-col>
					<el-col :span="6">
						<!-- 新增 s -->
						<router-link to="goodscateadd"><el-button size="mini" icon="el-icon-plus">新增类别</el-button></router-link>
						<!-- 新增 e -->
					</el-col>
					<el-col :span="6">
						<el-button size="mini" icon="el-icon-back" title="返回" @click="getGoodsCateList()" v-if="isBack">顶级</el-button>
						<el-button size="mini" icon="el-icon-back" title="返回" @click="getGoodsCateList(grandparentId)" v-if="isBack">上级</el-button>
						<!-- <el-button size="mini" icon="el-icon-refresh" title="刷新" @click="getGoodsCateList(parentId)">刷新</el-button> -->
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- 商品类别列表 s -->
				<el-table :data="goodsCateList" border style="width: 100%">
					<el-table-column prop="id" label="ID" fixed width="90"></el-table-column>
					<el-table-column prop="cate_name" label="类别名称" fixed min-width="180"></el-table-column>
					<el-table-column prop="parent_name" label="上级类别" width="180"></el-table-column>
					<!-- <el-table-column prop="parent_id" label="上级ID" width="90"></el-table-column> -->
					<!-- <el-table-column prop="grandparent_id" label="上上级ID" width="100"></el-table-column> -->
					<el-table-column prop="audit_status_msg" label="审核状态" width="120"></el-table-column>
					<el-table-column label="操作" fixed="right" width="210">
						<template slot-scope="scope">
							<el-button size="mini" @click="getGoodsCateList(scope.row)">下级</el-button>
							<el-button type="primary" size="mini" plain @click="toGoodsCateEdit(scope.row)">编辑</el-button>
							<el-button type="danger" size="mini" plain @click="deleteGoodsCate(scope.row)">删除</el-button>
						</template>
					</el-table-column>
				</el-table>
				<!-- 商品类别列表 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				formInline: {
					cate_name: '' // 商品类别名称
				},
				goodsCateList: [], // 商品类别列表，如 [{cate_id: 1, cate_name: '油盐酱醋茶', parent_id: 0, audit_status: 0, audit_status_msg: '待审核'}, {…}, …]
				grandparentId: '', // 上上级ID
				parentId: 0, // 上级ID，默认为 0 查看顶级类别
				isBack: false, // 是否显示返回按钮
			}
		},
		mounted() {
			this.getGoodsCateList(); // 获取商品类别列表
		},
		methods: {
			/**
			 * 获取商品类别列表
			 * @param {Object} row
			 */
			getGoodsCateList(row) {
				let self = this;
				
				// 当参数 row 存在时，执行 查看下级 、 返回上级  或 查询 操作
				this.isBack = row ? true : false;
				if (row) {
					if (row.cate_id && typeof(row.cate_id) == 'number') { // 当为 查看下级 操作时
						this.parentId = row.cate_id;
					} else if (typeof(row) == 'number') { // 当为 返回上级 操作时
						this.parentId = row;
					} else if (typeof(row) == 'string') { // 查询操作
						this.formInline.cate_name = row;
						this.parentId = '';
					}
				} else { // 加载页面或从第二级类别返回上级操作时
					this.formInline.cate_name = '';
					this.parentId = 0;
				}
				
				this.$axios.get(this.$url + 'goods_cate', {
					params: {
						cate_name: this.formInline.cate_name,
						parent_id: this.parentId
					}
				})
				.then(function(res) {
					if (res.data.status == 1) {
						let goodsCateList = res.data.data;
						if (goodsCateList.length == 0) {
							self.$message({
								message: '不存在下级分类',
								type: 'warning'
							});
							return;
						}
						
						goodsCateList.forEach((item, index) => {
							item.index = index; // 定义index
							item.id = index + 1; // 定义编号ID
							if (index == 0) { // 0表示第1条数据
								self.grandparentId = item.grandparent_id; // 上上级ID是否存在时赋值
								return;
							}
						});
						self.goodsCateList = goodsCateList;
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
			 * 跳转商品类别编辑页
			 * @param {Object} row
			 */
			toGoodsCateEdit(row) {
				this.$router.push({path: "goodscateedit", query: {cate_id: row.cate_id, cate_name: row.cate_name, parent_id: row.parent_id}});
			},
			
			/**
			 * 删除商品类别
			 * @param {Object} row
			 */
			deleteGoodsCate(row) {
				this.$confirm('此操作将永久删除该类别, 是否继续?', '删除', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					// 调用删除接口
					let self = this;
					this.$axios.delete(this.$url + 'goods_cate/' + row.cate_id)
					.then(function(res) {
						// 移除元素
						self.goodsCateList.splice(row.index, 1);
						
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
