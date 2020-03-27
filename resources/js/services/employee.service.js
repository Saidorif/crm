import ApiService from './api.service'

const EmployeeService = {
	employeeList(){
		return ApiService.get(`/api/employee/list`)
	},
	employees(page){
		return ApiService.get(`/api/employee?page=`+ page)
	},
	addEmployee(data){
		return ApiService.post(`/api/employee/store`,data)
	},
	editEmployee(data){
		return ApiService.get(`/api/employee/edit/${data.id}`,data)
	},
	updateEmployee(data){
		return ApiService.post(`/api/employee/update/${data.id}`,data)
	},
	deleteEmployee(id){
		return ApiService.delete(`/api/employee/destroy/${id}`)
	},
};

export { EmployeeService };
