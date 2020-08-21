<template>
	<ul class="result_test user_info_result">
		<li><b> Все вопросы</b> {{items.wrong_answers + items.true_answers}} в процентах 100%</li>
		<li>
			<b>Неправильные ответы:</b> {{items.wrong_answers ? items.wrong_answers : 0}} в процентах
			{{countPercentage(items.wrong_answers)}}
		</li>
		<li>
			<b>Правильные ответы:</b> {{items.true_answers ? items.true_answers : 0}} в процентах
			{{countPercentage(items.true_answers)}}
		</li>
		<router-link tag="button" class="btn btn-primary" :to='`/crm/test/test-result/${items.id}`'>
			Показать результат теста
		</router-link>
	</ul>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	export default{
		props:['items'],
		data(){
			return{
				wrongPert:null,
				rightPert:null,
			}
		},
		methods:{
			countPercentage(number){
				let summ = this.items.wrong_answers + this.items.true_answers
				let result = Math.round((number*100)/summ);
				return result ? result : 0 + ' %';
			}
		}
		
	}
</script>
