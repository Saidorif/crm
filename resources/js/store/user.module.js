import {UserService} from "../services/user.service";

const state = {
	message: null,
};

const getters = {
	getMessage(state){
		return state.message
	},
};


const actions = {
	
	async ActionUpdatePassword({commit}, data){
		try {
			let sendData = await UserService.updatePassword(data);
			await commit('setMessage',sendData.data)
			return true
		}catch(e){
			return false
		}
	},
};

const mutations = {
	setMessage(state, data){
		state.message = data
	}
};

export const user = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
