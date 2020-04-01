import {TestService} from "../services/test.service";

const state = {
	message: [],
	tests: [],
	complete: [],
	test: [],
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
	getTest(state){
		return state.test
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
	async actionShowTest({commit},id){
		try {
			const items =  await TestService.showTest(id);
			await commit('setShowTest',items.data)
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
	setShowTest(state, complete){
		state.test = complete
	},
};

export const test = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
