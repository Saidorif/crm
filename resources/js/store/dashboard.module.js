import {DashboardService} from "../services/dashboard.service";

const state = {
	dashboard: [],
};

const getters = {
	getDashboard(state){
		return state.dashboard
	},
};


const actions = {
	async actionDashboard({commit}){
		try {
			const dashboard =  await DashboardService.dashboardChart();
			await commit('setDashboard',dashboard.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setDashboard(state, dashboard){
		state.dashboard = dashboard
	},
};

export const dashboard = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
