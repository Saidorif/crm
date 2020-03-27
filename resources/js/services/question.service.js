import ApiService from './api.service'

const QuestionService = {
	questionList(page){
		return ApiService.get(`/api/question?page=`+ page)
	},
	addQuestion(data){
		return ApiService.post(`/api/question/store`,data)
	},
	editQuestion(data){
		return ApiService.get(`/api/question/edit/${data.id}`)
	},
	updateQuestion(data){
		return ApiService.post(`/api/question/update/${data.id}`,data)
	},
	deleteQuestion(id){
		return ApiService.delete(`/api/question/destroy/${id}`)
	},
};

export { QuestionService };
