import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
	  menuonetitle:''
  },
  mutations:{
	  menutitle(state,title){
		 state.menuonetitle=title; 
	  }
  },
  actions: {
  },
  modules: {
  }
})
