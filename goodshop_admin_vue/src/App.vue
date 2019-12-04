<template>
  <div id="app">
<!--    <img src="./assets/logo.png"> -->
<!-- 	<el-container>
	  <el-header>Header</el-header>
	  <el-container>
		<el-aside width="200px">Aside</el-aside>
		<el-container>
		  <el-header>Header</el-header>
		  <el-main>Main</el-main>
		  <el-footer>Footer</el-footer>
		</el-container>
	  </el-container>
	</el-container> -->

    <Login></Login>
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
import Login from './views/Login.vue'
import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'app',
  components: {
    HelloWorld,
	Login
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
