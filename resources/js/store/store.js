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
			
		},
		state:{
			
		},
		getters:{
			
		},
		mutations:{
			
		},
		actions:{
			
		}
	}
)

export default store;
