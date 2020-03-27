import {QuestionService} from "../services/question.service";

const state = {
	questions: {},
	message: [],
	question: [],
};

const getters = {
	getQuestionList(state){
		return state.questions
	},
	getMassage(state){
		return state.message
	},
	getQuestion(state){
		return state.question
	},
};


const actions = {
	async actionQuestionList({commit},page){
		try {
			const questions =  await QuestionService.questionList(page);
			await commit('setQuestionList',questions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddQuestion({commit},payload){
		try {
			const questions =  await QuestionService.addQuestion(payload);
			await commit('setMessage',questions.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditQuestion({commit},payload){
		try {
			const questions =  await QuestionService.editQuestion(payload);
			await commit('setEditQuestion',questions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateQuestion({commit},payload){
		try {
			const questions =  await QuestionService.updateQuestion(payload);
			await commit('setEditQuestion',questions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteQuestion({commit},id){
		try {
			const questions =  await QuestionService.deleteQuestion(id);
			await commit('setEditQuestion',questions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setQuestionList(state, questions){
		state.questions = questions
	},
	setMessage(state, message){
		state.message = message
	},
	setEditQuestion(state, question){
		state.question = question
	},
};

export const question = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
