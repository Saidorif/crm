<template>
	<div class="show_test_result">
		<ul v-if="userInfo" class="user_info_result">
			<li><b> User Fullname :</b> {{userInfo.fio}}</li>
			<li><b>Status Test :</b> {{userInfo.status}}</li>
			<li><b>Test Quantity : </b>{{userInfo.limit}} in percentage 100%</li>
			<li>
				<b>Wrong answers :</b> {{userInfo.wrong_answers}} in percentage 
				{{countPercentage(userInfo.wrong_answers)}}
			</li>
			<li>
				<b>Right answers :</b> {{userInfo.true_answers}} in percentage 
				{{countPercentage(userInfo.true_answers)}}
			</li>
			<li><b>Data for test :</b> {{getTime}}</li>
			<li><b>Test Category: </b> {{items[0].category}}</li>
		</ul>
		<ul v-for="(item,index) in items" v-if="items.length > 0" class="result_test_item">
			<li class="result_quelstion_item">{{index+1}} ) <b> {{item.title}}</b></li>
			<ol type="A" class="result_test_item_variants">
				<template  v-for="(q,i) in item.variants" >	
					<li :class="{'correctAnswer': chechAnswer(item.user_choose,q)=='true_answer', 'mistakeAnswer': chechAnswer(item.user_choose,q)=='wrong_answer'}">
						<span >{{q.title}}  </span>
					</li>
				</template>
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