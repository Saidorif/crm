import {CategoryService} from "../services/category.service";

const state = {
	categories: {},
	message: [],
	category: [],
};

const getters = {
	getCategoryList(state){
		return state.categories
	},
	getMassage(state){
		return state.message
	},
	getCategory(state){
		return state.category
	},
};


const actions = {
	async actionCategoryPag({commit},page){
		try {
			const categories =  await CategoryService.categoryPag(page);
			await commit('setCategoryList',categories.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddCategory({commit},payload){
		try {
			const categories =  await CategoryService.addCategory(payload);
			await commit('setMessage',categories.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditCategory({commit},payload){
		try {
			const categories =  await CategoryService.editCategory(payload);
			await commit('setEditCategory',categories.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateCategory({commit},payload){
		try {
			const categories =  await CategoryService.updateCategory(payload);
			await commit('setEditCategory',categories.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteCategory({commit},id){
		try {
			const categories =  await CategoryService.deleteCategory(id);
			await commit('setEditCategory',categories.data.result)
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
	setMessage(state, message){
		state.message = message
	},
	setEditCategory(state, category){
		state.category = category
	},
};

export const category = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
