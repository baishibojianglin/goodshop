<template>
	<div class="create">
       
	</div>
</template>

<script>
	import aes from '@/assets/js/aes.js';
    import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';
	
	export default {
	  name: 'companycreate',
	  data(){
		return {
	
		}  
	  },
	  components: {
	 
	  },
	  computed: {
	    ...mapState([
          'menuonetitle',
		  'menutwotitle'
	    ])
	  },
	  mounted(){
		//获取公司（供应商）基本信息
		let account=JSON.parse(localStorage.getItem("company"));
		this.name=account['name'];
	  },
	  methods: {
		//vuex存储共享数据
		...mapMutations([
		    'menutitle', //存储菜单标题
		  ]),	
		
	  }

	}
</script>

<style>

</style>
