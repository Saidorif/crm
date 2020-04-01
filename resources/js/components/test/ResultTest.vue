<template>
	<div class="result_test">
		<h4>All questions {{items.wrong_answers + items.true_answers}} in percentage 100%</h4>
		<h4>
			Wrong answers : {{items.wrong_answers}} in percentage 
			{{countPercentage(items.wrong_answers)}}
		</h4>
		<h4>
			Right answers : {{items.true_answers}} in percentage 
			{{countPercentage(items.true_answers)}}
		</h4>
		<router-link tag="button" class="btn btn-primary" :to='`/crm/test/test-result/${items.id}`'>
			Show test result
		</router-link>
	</div>
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