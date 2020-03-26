import {CategoryService} from "../services/category.service";

const state = {
	categories: {},
	message: [],
};

const getters = {
	getCategoryList(state){
		return state.listApply
	},
	getMassage(state){
		return state.message
	},
};


const actions = {
	async actionCategoryList({commit},payload){
		try {
			const categories =  await CategoryService.categoryList(payload);
			await commit('setCategoryList',categories.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setCategoryList(state, categories){
		state.categories = categories
	},
};

export const category = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
