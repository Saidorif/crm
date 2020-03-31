import ApiService from './api.service'

const TestService = {
	startTest(data){
		return ApiService.post(`/api/attestat`,data)
	},
	completeTest(data){
		return ApiService.post(`/api/attestat/complete/${data.attestat_id}`,data)
	},
};

export { TestService };
