import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
// import {TokenService} from './services/storage.service'
// import {ability} from "./store/store";
import store from "./store/store";


// Dashboard component
import Dashboard from './components/admin/Dashboard'
import Master from './components/layouts/Master'

// NotFound
import NotFound from './components/NotFound/NotFound'
const router = new Router({
	mode: 'history', 
	base: process.env.BASE_URL,
	linkActiveClass: 'open active',
	routes: [
		// public components 
		{
			path:'/crm',
			name:'crm',
			components:{
				default:Master,
			},
			children:[
				{
					path:'dashboard',
					component:Dashboard,
				},
			]
		}
	]
});

// router.beforeEach((to, from, next) => {
//   if (to.matched.some(record => record.meta.requiredAuth)) {
//   	const loggedIn = TokenService.getToken();
//     if (!loggedIn || loggedIn == 'undefined'){
//       next({
//         path: '/',
//         query: { redirect: to.fullPath }
//       })
//     } else {
//     	if (TokenService.getCurrentUser().role.name != 'admin') {
// 		 	const checkPerm = to.matched.some(route => {
// 			    return ability.can(route.meta.action, route.meta.subject)
// 		  	})
// 		  	if (!checkPerm) {
// 			    return next('/notfound')
// 		  	}
//     	}
//       	next()
//     }
//   } else {
//     next() 
//   }
// })

export default router;
