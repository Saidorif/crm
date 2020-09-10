<template>
	<ul class="result_test user_info_result">
		<li><b> {{$t('all_questions')}}</b> {{items.wrong_answers + items.true_answers}} {{$t('in_parsentage')}} 100%</li>
		<li>
			<b>{{$t('wrong_answers')}}</b> {{items.wrong_answers ? items.wrong_answers : 0}} {{$t('in_parsentage')}}
			{{countPercentage(items.wrong_answers)}}
		</li>
		<li>
			<b>{{$t('correct_answers')}}</b> {{items.true_answers ? items.true_answers : 0}} {{$t('in_parsentage')}}
			{{countPercentage(items.true_answers)}}
		</li>
		<router-link tag="button" class="btn btn-primary" :to='`/crm/test/test-result/${items.id}`'>
			{{$t('show_result_test')}}
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
