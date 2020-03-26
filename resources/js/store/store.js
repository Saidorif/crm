import Vue from 'vue'
import Vuex from 'vuex'

// ability 
import storage from "./storage"
import {abilityPlugin, ability as appAbility} from './ability'
import router from "./../routes"

// user service
import {UserService} from "../services/user.service";
// modules
import {user} from "./user.module"
import {category} from "./category.module"

import { TokenService } from './../services/storage.service'

Vue.use(Vuex)
export const ability = appAbility

const store = new Vuex.Store(
	{
		plugins:[
			// storage({
			// 	storedKeys:['token','rules'],
			// 	destroyOn:['logoutSuccess']
			// }),
			abilityPlugin
		],
		modules:{
			user,
			category
		},
		state:{
			rules:[],
			user:[],
			token:'',
			authenticationErrorCode: false,
			authenticationError: '',
			registerError: '',
			authenticating: false,
			registerErrorCode: false,
		},
		getters:{
			getUser(state){
				return state.user
			},
			authenticationErrorCode(state){
				return state.authenticationErrorCode
			},

			authenticationError(state){
				return state.authenticationError
			},
			registerError(state){
				return state.registerErrorCode
			},
			authenticating(state){
				return state.authenticating
			},
		},
		mutations:{
			loginRequest(state){
				state.authenticating = true;
				state.authenticationError = '';
				state.authenticationErrorCode = false
			},
			logoutSuccess(state){
				state.token = '';
				state.rules = [];
			},
			loginSuccess(state,user){
				TokenService.saveCurrentUser(user.result);
				state.token = user.token;
				state.authenticationErrorCode = false
				state.user = user.result;
			},
			loginError(state,user){
				state.authenticating = false
				state.authenticationErrorCode = user.data.error
				state.authenticationError = user.data.message
			},
		},
		actions:{
			async login({ commit,dispatch }, userData) {
				try{
					const user = await UserService.login(userData);
					if (user.data.error === true) {
						await commit('loginError', user);
					}else{
						await commit('loginSuccess', user.data);
						// let routeHistory = router.history.current.query.redirect
						// router.push(routeHistory && routeHistory != '/' ? routeHistory : '/')
					}
				}catch(e){

				}
			},
			// register
			async register({ commit,dispatch }, payload){
				const newUser = await UserService.register(payload);
				if(newUser.data.error === true){
					await commit('registerError', newUser);
				}
			}, 
			// register-end
			logout({ commit }){
				UserService.logout();
				commit('logoutSuccess');
				router.push('/');
			}
		}
	}
)

export default store;
