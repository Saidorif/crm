import {ContsService} from "../services/conts.service";

const state = {
	conts: {},
	contList: [],
	message: [],
	cont: [],
};

const getters = {
	getConts(state){
		return state.conts
	},
	getContList(state){
		return state.contList
	},
	getMassage(state){
		return state.message
	},
	getCont(state){
		return state.cont
	},
};


const actions = {
	async actionContsFind({commit},){
		try {
			const conts =  await ContsService.contFindUrl();
			await commit('setContList',conts.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionConts({commit},page){
		try {
			const conts =  await ContsService.conts(page);
			await commit('setConts',conts.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddCont({commit},payload){
		try {
			const conts =  await ContsService.addCont(payload);
			await commit('setMessage',conts.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditCont({commit},payload){
		try {
			const conts =  await ContsService.editCont(payload);
			await commit('setEditCont',conts.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateCont({commit},payload){
		try {
			const conts =  await ContsService.updateCont(payload);
			await commit('setEditCont',conts.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setContList(state, contList){
		state.contList = contList
	},
	setConts(state, conts){
		state.conts = conts
	},
	setMessage(state, message){
		state.message = message
	},
	setEditCont(state, cont){
		state.cont = cont
	},
};

export const conts = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
