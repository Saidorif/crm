import {TestService} from "../services/test.service";

const state = {
	message: [],
	tests: [],
	complete: [],
};

const getters = {
	getMassage(state){
		return state.message
	},
	getTests(state){
		return state.tests
	},
	getComplete(state){
		return state.complete
	},
};


const actions = {
	async actionStartTest({commit},payload){
		try {
			const items =  await TestService.startTest(payload);
			await commit('setStartTest',items.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCompleteTest({commit},payload){
		try {
			const items =  await TestService.completeTest(payload);
			await commit('setComplete',items.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setStartTest(state, tests){
		state.tests = tests
	},
	setMessage(state, message){
		state.message = message
	},
	setComplete(state, complete){
		state.complete = complete
	},
};

export const test = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
