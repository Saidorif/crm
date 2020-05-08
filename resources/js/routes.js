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
import Profile from './components/admin/user/Profile'

// Category
import Category from './components/admin/category/Category'
import AddCategory from './components/admin/category/AddCategory'
import EditCategory from './components/admin/category/EditCategory'

// Employee
import Employee from './components/admin/employee/Employee'
import AddEmployee from './components/admin/employee/AddEmployee'
import EditEmployee from './components/admin/employee/EditEmployee'

// Question
import Question from './components/admin/question/Question'
import AddQuestion from './components/admin/question/AddQuestion'
import EditQuestion from './components/admin/question/EditQuestion'

// Role
import Role from './components/admin/role/Role'
import AddRole from './components/admin/role/AddRole'
import EditRole from './components/admin/role/EditRole'

// Position
import Position from './components/admin/position/Position'
import AddPosition from './components/admin/position/AddPosition'
import EditPosition from './components/admin/position/EditPosition'

// Test
import ShowTestResult from './components/test/ShowTestResult'
import StartTest from './components/test/StartTest'
import ForGuest from './components/test/ForGuest'
import TestList from './components/testlist/TestList'
import TestListShow from './components/testlist/TestListShow'


// NotFound
import NotFound from './components/NotFound/NotFound'
const router = new Router({
	mode: 'history', 
	base: process.env.BASE_URL,
	linkActiveClass: 'active',
	routes: [
		// public components 
		{
			path:'/crm',
			name:'crm',
			redirect:'/crm/dashboard',
			meta:{
				requiredAuth:true
			},
			component:Admin,
			children:[
				{
					path:'dashboard',
					component:Dashboard,
				},
				{
					path:'profile',
					component:Profile,
				},
				{
					path:'category',
					component:Category,
				},
				{
					path:'category/add',
					component:AddCategory,
				},
				{
					path:'category/edit/:categoryId',
					component:EditCategory,
				},
				{
					path:'employee',
					component:Employee,
				},
				{
					path:'employee/add',
					component:AddEmployee,
				},
				{
					path:'employee/edit/:employeeId',
					component:EditEmployee,
				},
				{
					path:'question',
					component:Question,
				},
				{
					path:'question/add',
					component:AddQuestion,
				},
				{
					path:'question/edit/:questionId',
					component:EditQuestion,
				},
				{
					path:'role',
					component:Role,
				},
				{
					path:'role/add',
					component:AddRole,
				},
				{
					path:'role/edit/:roleId',
					component:EditRole,
				},
				{
					path:'position',
					component:Position,
				},
				{
					path:'position/add',
					component:AddPosition,
				},
				{
					path:'position/edit/:positionId',
					component:EditPosition,
				},
				{
					path:'test/test-for-guest',
					component:ForGuest,
				},
				{
					path:'test/start-test',
					component:StartTest,
				},
				{
					path:'test/list',
					component:TestList,
				},
				{
					path:'test/list/show',
					component:TestListShow,
				},
				{
					path:'test/test-result/:showTestId',
					component:ShowTestResult,
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

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiredAuth)){
	  	const loggedIn = TokenService.getToken();
	    if (!loggedIn || loggedIn == 'undefined'){
	      next({
	        path: '/',
	        query: { redirect: to.fullPath }
	      })
	    } else {
	      	next()
	    }
	} else {
	    next() 
	}
})

export default router;
