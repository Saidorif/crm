<template>
	<div class="show_test_result">
		<ul v-if="userInfo">
			<li>User Fullname : {{userInfo.fio}}</li>
			<li>Status Test : {{userInfo.status}}</li>
			<li>Test Quantity : {{userInfo.limit}} in percentage 100%</li>
			<li>
				Wrong answers : {{userInfo.wrong_answers}} in percentage 
				{{countPercentage(userInfo.wrong_answers)}}
			</li>
			<li>
				Right answers : {{userInfo.true_answers}} in percentage 
				{{countPercentage(userInfo.true_answers)}}
			</li>
			<li>Data for test : {{getTime}}</li>
		</ul>
		<ul v-for="(item,index) in items" v-if="items.length > 0">
			<li>{{index+1}} ) </li>
			<li>Test title: {{item.title}}</li>
			<li>Test Category: {{item.category}}</li>
			<b>Variants</b>
			<ol type="A">
				<li 
					v-for="(q,i) in item.variants" 
				>	
					<span :class="chechAnswer(item.user_choose,q)">{{q.title}} </span>
					<b>
						{{chechAnswer(item.user_choose,q) =='wrong_answer' ? '/ user mistake' : '' }}
					</b>
				</li>
			</ol>
		</ul>
	</div>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	export default{
		data(){
			return{
				userInfo:[],
				items:[]
			}
		},
		async mounted(){
			await this.actionShowTest(this.$route.params.showTestId)
			if (this.getTest.success) {
				this.userInfo = this.getTest.result.attestat
				this.items = this.getTest.result.questions
				console.log(this.items)
			}
		},
		methods:{
			...mapActions('test',['actionShowTest']),
			countPercentage(number){
				let summ = parseInt(this.userInfo.wrong_answers) + parseInt(this.userInfo.true_answers)
				let result = Math.round((parseInt(number)*100)/summ);
				return result + ' %';
			},
			chechAnswer(userChosen,item){
					if (userChosen == item.id && item.is_true == 1 || userChosen != item.id && item.is_true == 1) {
						return 'true_answer'
					}else if(userChosen == item.id && item.is_true == 0){
						return 'wrong_answer'
					}else{
						return ''
					}
			}
		},
		computed:{
			...mapGetters('test',['getTest']),
			getTime(){
				return parseFloat(parseInt(this.userInfo.time)/60) + ' минут'
			}
		}
	}
</script>
<style scoped>
	.true_answer{
		color:green;
	}
	.wrong_answer{
		color:red;
	}
</style>