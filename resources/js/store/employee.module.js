import {EmployeeService} from "../services/employee.service";

const state = {
	employees: {},
	employeeList: [],
	message: [],
	employee: [],
};

const getters = {
	getEmployees(state){
		return state.employees
	},
	getEmployeeList(state){
		return state.employeeList
	},
	getMassage(state){
		return state.message
	},
	getEmployee(state){
		return state.employee
	},
};


const actions = {
	async actionEmployeeList({commit}){
		try {
			const employees =  await EmployeeService.employeeList();
			await commit('setEmployeeList',employees.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEmployees({commit},payload){
		try {
			const employees =  await EmployeeService.employees(payload);
			await commit('setEmployees',employees.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddEmployee({commit},payload){
		try {
			const employees =  await EmployeeService.addEmployee(payload);
			await commit('setMessage',employees.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditEmployee({commit},payload){
		try {
			const employees =  await EmployeeService.editEmployee(payload);
			await commit('setEditEmployee',employees.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateEmployee({commit},payload){
		try {
			const employees =  await EmployeeService.updateEmployee(payload);
			await commit('setMessage',employees.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteEmployee({commit},id){
		try {
			const employees =  await EmployeeService.deleteEmployee(id);
			await commit('setMessage',employees.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCheckEmail({commit},payload){
		try {
			const email =  await EmployeeService.checkEmail(payload);
			await commit('setMessage',email.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setEmployeeList(state, employees){
		state.employeeList = employees
	},
	setEmployees(state, employees){
		state.employees = employees
	},
	setMessage(state, message){
		state.message = message
	},
	setEditEmployee(state, employee){
		state.employee = employee
	},
};

export const employee = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
