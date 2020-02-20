require('./bootstrap');
import Vue from 'vue'
import Vuesax from 'vuesax'

import 'vuesax/dist/vuesax.css' //Vuesax styles
import 'material-icons/iconfont/material-icons.css';
Vue.use(Vuesax)

// Router
import router from './routes'

//Vuex
import store from "./store/store"

import Master from './components/layouts/Master'

const app = new Vue({
    el: '#app',
    router,
    components:{
      Master,
    },
	store,
});
