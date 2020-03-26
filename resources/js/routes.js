import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import {TokenService} from './services/storage.service'
// import {ability} from "./store/store";
import store from "./store/store";

// Dashboard component
import Dashboard from './components/admin/Dashboard'
import Admin from './components/admin/layouts/Admin'
import Login from './components/auth/Login'

// NotFound
import NotFound from './components/NotFound/NotFound'
const router = new Router({
	mode: 'history', 
	base: process.env.BASE_URL,
	linkActiveClass: 'open active',
	routes: [
		// public components 
		{
			path:'/',
			name:'crm',
			redirect:'/crm/dashboard',
			meta:{
				requiredAuth:true
			},
			components:{
				default:Admin,
			},
			children:[
				{
					path:'dashboard',
					component:Dashboard,
				},
			]
		},
		{
			path:'/',
			name:'login',
			components:{
				default:Login,
			},
		},
		{
			path:'*',
			name:'notfound',
			components:{
				default:NotFound,
			},
		}
	]
});

// router.beforeEach((to, from, next) => {
//   if (to.matched.some(record => record.meta.requiredAuth)){
//   	const loggedIn = TokenService.getToken();
//     if (!loggedIn || loggedIn == 'undefined'){
//       next({
//         path: '/',
//         query: { redirect: to.fullPath }
//       })
//     } else {
//       	next()
//     }
//   } else {
//     next() 
//   }
// })

export default router;
