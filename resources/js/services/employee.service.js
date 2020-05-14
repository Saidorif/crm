import ApiService from './api.service'

const EmployeeService = {
	employeeList(){
		return ApiService.get(`/api/employee/list`)
	},
	employees(data){
		return ApiService.post(`/api/employee?page=`+ data.page,data.items)
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
	checkEmail(data){
		return ApiService.post(`/api/checkemail`,data)
	}
};

export { EmployeeService };
