import ApiService from './api.service'

const PositionService = {
	positionList(){
		return ApiService.get(`/api/position/list`)
	},
	positions(page){
		return ApiService.get(`/api/position/all?page=`+ page)
	},
	addPosition(data){
		return ApiService.post(`/api/position/store`,data)
	},
	editPosition(data){
		return ApiService.get(`/api/position/edit/${data.id}`,data)
	},
	updatePosition(data){
		return ApiService.post(`/api/position/update/${data.id}`,data)
	},
	deletePosition(id){
		return ApiService.delete(`/api/position/destroy/${id}`)
	},
};

export { PositionService };
