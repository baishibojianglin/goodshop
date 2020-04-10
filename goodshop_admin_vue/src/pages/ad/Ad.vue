<template>
	<div class="goods_brand">
		<el-card class="main-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20" type="flex" justify="space-between">
					<el-col :span="6"><span>广告列表</span></el-col>
					<el-col :span="6">
						<!-- 查询 s -->
						<el-form :inline="true" :model="formInline" size="mini" class="demo-form-inline">
							<el-form-item label="">
								<el-input placeholder="查询广告" v-model="formInline.brand_name" clearable>
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
				<!-- 广告列表 s -->
				<el-table :data="adList" border style="width: 100%">
					<el-table-column prop="ad_id" label="序号" fixed width="90"></el-table-column>
					<el-table-column prop="ad_name" label="广告名称" fixed min-width="180"></el-table-column>
					<el-table-column prop="ad_pic" label="广告图片" width="180">
						<template slot-scope="scope">
							<img :src="scope.row.ad_pic" :alt="scope.row.ad_pic" :title="scope.row.ad_name" width="50" height="50" />
						</template>
					</el-table-column>
					<el-table-column prop="position_name" label="广告位" min-width="180"></el-table-column>
					<el-table-column prop="ad_link" label="广告链接" min-width="180"></el-table-column>
					<el-table-column prop="company_name" label="所属供应商" width="180"></el-table-column>
					<el-table-column prop="user_name" label="创建者" width="180"></el-table-column>
					<el-table-column prop="create_time" label="创建时间" width="180"></el-table-column>
					<el-table-column prop="target_msg" label="开启新窗口" width="120" :filters="[{ text: '当前窗口', value: 0 }, { text: '新窗口', value: 1 }]" :filter-method="filterIsOnSale" filter-placement="bottom-end"></el-table-column>
					<el-table-column prop="is_show" label="是否显示" width="90" :filters="[{ text: '不显示', value: 0 }, { text: '显示', value: 1 }]" :filter-method="filterAuditStatus" filter-placement="bottom-end">
						<template slot-scope="scope">
							<el-tag :type="scope.row.is_show === 1 ? 'success' : 'info'" size="mini">{{scope.row.is_show_msg}}</el-tag>
						</template>
					</el-table-column>
					<el-table-column label="操作" fixed="right" min-width="240">
						<template slot-scope="scope">
							<el-button type="warning" size="mini" plain @click="isShow(scope)">{{scope.row.is_show ? '不显示' : '显示'}}</el-button>
							<el-button type="primary" size="mini" plain @click="toGoodsBrandEdit(scope.row)">编辑</el-button>
							<el-button type="danger" size="mini" plain @click="deleteGoodsBrand(scope)">删除</el-button>
						</template>
					</el-table-column>
				</el-table>
				<!-- 广告列表 e -->
				
				<!-- 分页 s -->
				<div>
					<el-pagination
						background
						:page-sizes="[5, 10, 15, 20]"
						:page-size="listPagination.per_page"
						:total="listPagination.total"
						:current-page="listPagination.current_page"
						layout="total, sizes, prev, pager, next, jumper"
						@size-change="handleSizeChange"
						@current-change="handleCurrentChange">
					</el-pagination>
				</div>
				<!-- 分页 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				formInline: {
					ad_name: '', // 广告名称
					position_id: '' // 广告位ID
				},
				adList: [], // 广告列表
				listPagination: {} // 列表分页参数
			}
		},
		mounted() {
			this.getAdList(); // 获取广告列表
		},
		methods: {
			/**
			 * 获取广告列表
			 */
			getAdList() {
				let self = this;
				this.$axios.get(this.$url + 'ad', {
					params: {
						ad_name: this.formInline.ad_name,
						position_id: this.formInline.position_id,
						page: this.listPagination.current_page,
						size: this.listPagination.per_page
					},
					headers: {
						'company-user-id': JSON.parse(localStorage.getItem('company')).user_id,
						'company-user-token': JSON.parse(localStorage.getItem('company')).token
					}
				})
				.then(function(res) {console.log(res)
					if (res.data.status == 1) {
						// 广告列表分页参数
						self.listPagination = res.data.data;
						
						// 当数据为空时
						if (self.listPagination.total == 0) {
							self.$message({
								message: '数据不存在',
								type: 'warning'
							});
							return;
						}
						
						// 广告列表
						self.adList = self.listPagination.data;
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
			 * 分页 pageSize 改变时会触发
			 * @param {Object} page_size
			 */
			handleSizeChange(page_size) {
				this.listPagination.per_page = page_size; // 每页条数
				this.getGoodsBrandList();
			},
			
			/**
			 * 分页 currentPage 改变时会触发
			 * @param {Object} current_page
			 */
			handleCurrentChange(current_page) {
				this.listPagination.current_page = current_page; // 当前页数
				this.getGoodsBrandList();
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
			 * 跳转商品品牌编辑页
			 * @param {Object} row
			 */
			toGoodsBrandEdit(row) {
				this.$router.push({path: "goodsbrandedit", query: {brand_id: row.brand_id, brand_name: row.brand_name}});
			},
			
			/**
			 * 删除商品品牌
			 * @param {Object} scope
			 */
			deleteGoodsBrand(scope) {
				this.$confirm('此操作将永久删除该商品品牌, 是否继续?', '删除', {
					confirmButtonText: '确定',
					cancelButtonText: '取消',
					type: 'warning'
				}).then(() => {
					// 调用删除接口
					let self = this;
					this.$axios.delete(this.$url + 'goods_brand/' + scope.row.brand_id)
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
			},
			
			/**
			 * 筛选上下架状态
			 * @param {Object} value
			 * @param {Object} row
			 */
			filterIsOnSale(value, row) {
				return row.is_on_sale === value;
			},
			
			/**
			 * 是否显示
			 */
			isShow(scop) {
				let self = this;
				let is_on_sale = scop.row.is_on_sale;
				this.$axios.put(this.$url + 'goods_brand/' + scop.row.brand_id, {
					// 参数
					is_on_sale: is_on_sale
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
						message: res.data.status == 1 ? (is_on_sale === 1 ? '已下架' : '已上架') : res.data.message,
						type: type
					});
					scop.row.is_on_sale = is_on_sale === 1 ? 0 : 1; // 静态改变上下架状态
					scop.row.is_on_sale_msg = is_on_sale === 1 ? '下架' : '上架'; // 静态改变上下架状态信息
				})
				.catch(function (error) {
					self.$message({
						message: error.response.data.message,
						type: 'warning'
					});
				});
			}
		}
	}
</script>

<style>
</style>
