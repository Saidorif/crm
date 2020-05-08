import {TestService} from "../services/test.service";

const state = {
	message: [],
	tests: [],
	complete: [],
	test: [],
	testList: {},
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
	getTestList(state){
		return state.testList
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
	async actionTestList({commit},payload){
		try {
			const items =  await TestService.testListUrl(payload);
			await commit('setTestList',items.data.result)
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
	setTestList(state, testList){
		state.testList = testList
	},
};

export const test = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
