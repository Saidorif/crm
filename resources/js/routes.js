import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import {TokenService} from './services/storage.service'
import {ability} from "./store/store";
import store from "./store/store";

// Master
import Master from './components/layouts/Master'
// Dashboard component
import Dashboard from './components/admin/Dashboard'
import Admin from './components/admin/layouts/Admin'
import Login from './components/auth/login'
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
import Permission from './components/admin/permission/Permission'

// Position
import Position from './components/admin/position/Position'
import AddPosition from './components/admin/position/AddPosition'
import EditPosition from './components/admin/position/EditPosition'

// Test
import ShowTestResult from './components/test/ShowTestResult'
import StartTest from './components/test/StartTest'
import ForGuest from './components/test/ForGuest'
import TestList from './components/testlist/TestList'

// TestUser
import TestUser from './components/testUser/TestUser'
import TestUserStart from './components/testUser/TestUserStart'

// controller
import Conts from './components/admin/conts/Conts'
import AddConts from './components/admin/conts/AddConts'
import EditConts from './components/admin/conts/EditConts'

// controller
import Action from './components/admin/action/Action'
import AddAction from './components/admin/action/AddAction'
import EditAction from './components/admin/action/EditAction'


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
					meta:{
						action:'index',
						subject:'DashboardController'
					}
				},
				{
					path:'profile',
					component:Profile,
					meta:{
						action:'profile',
						subject:'UserController'
					}
				},
				{
					path:'category',
					component:Category,
					meta:{
						action:'index',
						subject:'TestCategoryController'
					}
				},
				{
					path:'category/add',
					component:AddCategory,
					meta:{
						action:'store',
						subject:'TestCategoryController'
					}
				},
				{
					path:'category/edit/:categoryId',
					component:EditCategory,
					meta:{
						action:'edit',
						subject:'TestCategoryController'
					}
				},
				{
					path:'employee',
					component:Employee,
					meta:{
						action:'index',
						subject:'EmployeeController'
					}
				},
				{
					path:'employee/add',
					component:AddEmployee,
					meta:{
						action:'store',
						subject:'EmployeeController'
					}
				},
				{
					path:'employee/edit/:employeeId',
					component:EditEmployee,
					meta:{
						action:'edit',
						subject:'EmployeeController'
					}
				},
				{
					path:'question',
					component:Question,
					meta:{
						action:'index',
						subject:'QuestionController'
					}
				},
				{
					path:'question/add',
					component:AddQuestion,
					meta:{
						action:'store',
						subject:'QuestionController'
					}
				},
				{
					path:'question/edit/:questionId',
					component:EditQuestion,
					meta:{
						action:'edit',
						subject:'QuestionController'
					}
				},
				{
					path:'role',
					component:Role,
					meta:{
						action:'index',
						subject:'RoleController'
					}
				},
				{
					path:'role/add',
					component:AddRole,
					meta:{
						action:'store',
						subject:'RoleController'
					}
				},
				{
					path:'role/edit/:roleId',
					component:EditRole,
					meta:{
						action:'store',
						subject:'RoleController'
					}
				},
				{
					path:'role/:roleId',
					component:Permission,
					meta:{
						action:'edit',
						subject:'RoleController'
					}
				},
				{
					path:'position',
					component:Position,
					meta:{
						action:'index',
						subject:'PositionController'
					}
				},
				{
					path:'position/add',
					component:AddPosition,
					meta:{
						action:'store',
						subject:'PositionController'
					}
				},
				{
					path:'position/edit/:positionId',
					component:EditPosition,
					meta:{
						action:'edit',
						subject:'PositionController'
					}
				},
				{
					path:'test/test-for-guest',
					component:ForGuest,
					meta:{
						action:'startTestUser',
						subject:'AttestatController'
					}
				},
				{
					path:'test/start-test',
					component:StartTest,
					meta:{
						action:'attestat',
						subject:'AttestatController'
					}
				},
				{
					path:'test/list',
					component:TestList,
					meta:{
						action:'list',
						subject:'TestCategoryController'
					}
				},
				{
					path:'test/test-result/:showTestId',
					component:ShowTestResult,
					meta:{
						action:'list',
						subject:'TestCategoryController'
					}
				},
				{
					path:'test/test-user',
					component:TestUser,
					meta:{
						action:'list',
						subject:'AttestatController'
					}
				},
				{
					path:'test/test-user-start/:userTestId',
					component:TestUserStart,
					meta:{
						action:'list',
						subject:'TestCategoryController'
					}
				},
				{
					path:'conts',
					component:Conts,
					meta:{
						action:'index',
						subject:'ContsController'
					}
				},
				{
					path:'conts/add',
					component:AddConts,
					meta:{
						action:'store',
						subject:'ContsController'
					}
				},
				{
					path:'conts/edit/:contId',
					component:EditConts,
					meta:{
						action:'edit',
						subject:'ContsController'
					}
				},
				{
					path:'action',
					component:Action,
					meta:{
						action:'index',
						subject:'ActionController'
					}
				},
				{
					path:'action/add',
					component:AddAction,
					meta:{
						action:'store',
						subject:'ActionController'
					}
				},
				{
					path:'action/edit/:actionId',
					component:EditAction,
					meta:{
						action:'edit',
						subject:'ActionController'
					}
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
			path:'/main',
			name:'master',
			meta:{
				requiredAuth:true
			},
			components:{
				default:Master,
			},
			children:[
				// {
				// 	path:'/',
				// 	component:Question,
				// 	meta:{
				// 		action:'index',
				// 		subject:'QuestionController'
				// 	}
				// },
			]
			
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
  if (to.matched.some(record => record.meta.requiredAuth)) {
  	const loggedIn = TokenService.getToken();
    if (!loggedIn || loggedIn == 'undefined'){
      next({
        path: '/',
        query: { redirect: to.fullPath }
      })
    } else {
    	if (TokenService.getCurrentUser().role.name != 'admin') {
		 	const checkPerm = to.matched.some(route => {
			    return ability.can(route.meta.action, route.meta.subject)
		  	})
		  	if (!checkPerm) {
			    return next('/notfound')
		  	}
    	}
      	next()
    }
  } else {
    next() 
  }
})

export default router;
