import ApiService from './api.service'

const DashboardService = {
	dashboardChart(){
		return ApiService.get(`/api/dashboard`)
	},
};

export { DashboardService };
