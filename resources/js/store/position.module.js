import {PositionService} from "../services/position.service";

const state = {
	positions: {},
	positionList: [],
	message: [],
	position: [],
};

const getters = {
	getPositions(state){
		return state.positions
	},
	getPositionList(state){
		return state.positionList
	},
	getMassage(state){
		return state.message
	},
	getPosition(state){
		return state.position
	},
};


const actions = {
	async actionPositionList({commit},){
		try {
			const positions =  await PositionService.positionList();
			await commit('setPositionList',positions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionPositions({commit},page){
		try {
			const positions =  await PositionService.positions(page);
			await commit('setPositions',positions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddPosition({commit},payload){
		try {
			const positions =  await PositionService.addPosition(payload);
			await commit('setMessage',positions.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditPosition({commit},payload){
		try {
			const positions =  await PositionService.editPosition(payload);
			await commit('setEditPosition',positions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdatePosition({commit},payload){
		try {
			const positions =  await PositionService.updatePosition(payload);
			await commit('setEditPosition',positions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletePosition({commit},id){
		try {
			const positions =  await PositionService.deletePosition(id);
			await commit('setMessage',positions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setPositionList(state, positions){
		state.positionList = positions
	},
	setPositions(state, positions){
		state.positions = positions
	},
	setMessage(state, message){
		state.message = message
	},
	setEditPosition(state, positions){
		state.position = positions
	},
};

export const position = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
