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
	testListUrl(page){
		return ApiService.get(`/api/attestat/all?page=`+ page)
	},
};

export { TestService };
