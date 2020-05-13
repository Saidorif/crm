import ApiService from './api.service'

const TestService = {
	startTest(data){
		return ApiService.post(`/api/attestat`,data)
	},
	completeTest(data){
		return ApiService.post(`/api/attestat/complete/${data.attestat_id}`,data)
	},
	showTest(id){
		return ApiService.post(`/api/attestat/show/${id}`)
	},
	testListUrl(data){
		return ApiService.post(`/api/attestat/all?page=`+ data.page,data.items)
	},
	testUserListUrl(page){
		return ApiService.get(`/api/attestat/user?page=`+ page)
	},
	startUserTest(id){
		return ApiService.get(`/api/attestat/userstart/${id}`)
	},
};

export { TestService };
