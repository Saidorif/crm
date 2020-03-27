import ApiService from './api.service'

const CategoryService = {
	categoryList(){
		return ApiService.get(`/api/category/list`)
	},
	categoryPag(page){
		return ApiService.get(`/api/category?page=`+ page)
	},
	addCategory(data){
		return ApiService.post(`/api/category/store`,data)
	},
	editCategory(data){
		return ApiService.get(`/api/category/edit/${data.id}`,data)
	},
	updateCategory(data){
		return ApiService.post(`/api/category/update/${data.id}`,data)
	},
	deleteCategory(id){
		return ApiService.delete(`/api/category/destroy/${id}`)
	},
};

export { CategoryService };
