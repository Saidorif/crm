<template>
	<ul class="result_test user_info_result">
		<li><b> All questions</b> {{items.wrong_answers + items.true_answers}} in percentage 100%</li>
		<li>
			<b>Wrong answers :</b> {{items.wrong_answers}} in percentage 
			{{countPercentage(items.wrong_answers)}}
		</li>
		<li>
			<b>Right answers :</b> {{items.true_answers}} in percentage 
			{{countPercentage(items.true_answers)}}
		</li>
		<router-link tag="button" class="btn btn-primary" :to='`/crm/test/test-result/${items.id}`'>
			Show test result
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
				return result + ' %';
			}
		}
		
	}
</script>
