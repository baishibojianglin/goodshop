<template>
	<div class="goods_cate">
		<el-card class="box-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20">
					<el-col :span="6"><span>商品类别列表</span></el-col>
					<el-col :span="6">
						<!-- 查询 s -->
						
						<!-- 查询 e -->
					</el-col>
					<el-col :span="6">
						<!-- 新增 s -->
						<el-button size="mini" icon="el-icon-plus">新增类别</el-button>
						<!-- 新增 e -->
					</el-col>
					<el-col :span="3" :offset="3">
						<router-view v-if="true"></router-view>
						<el-button size="mini" icon="el-icon-refresh" title="刷新" @click="getGoodsCateList()">刷新</el-button>
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- 商品类别列表 s -->
				<el-table :data="goodsCateList" border style="width: 100%">
					<el-table-column prop="cate_id" label="类别ID" width="100"></el-table-column>
					<el-table-column prop="cate_name" label="类别名称" minwidth="180"></el-table-column>
					<el-table-column prop="parent_id" label="上级ID" width="180"></el-table-column>
					<el-table-column prop="status_msg" label="审核状态" width="180"></el-table-column>
					<el-table-column label="操作" fixed="right" width="100">
						<template slot-scope="scope">
							<el-button @click="getGoodsCateList(scope.row)" type="text" size="small">子类</el-button>
							<el-button type="text" size="small">编辑</el-button>
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
				goodsCateList: [] // 商品类别列表，如 [{cate_id: 1, cate_name: '王小虎', parent_id: 0, status}, {…}, …]
			}
		},
		mounted() {
			this.getGoodsCateList(); // 获取商品类别列表
		},
		methods: {
			/**
			 * 获取商品类别列表
			 */
			getGoodsCateList(row) {
				let self = this;
				console.log('handleClick', row);
				let parent_id = row ? row.cate_id : ''; // 父级ID是否存在时赋值
				this.$axios.get(this.$url + 'goods_cate', {
					params: {
						cate_name: '',
						parent_id: parent_id
					}
				})
				.then(function(res) {
					if (res.data.status == 1) {
						self.goodsCateList = res.data.data;
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
			}
		}
	}
</script>

<style>
</style>
