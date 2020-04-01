<template>
	<div class="for_guest">
		<div class="test_header" v-if="userInfo">
			<h1>Ф.И.О: {{userInfo.fio}}</h1>
			<h1 class="pr-100" v-if="tests.length > 0" >{{nextItemIndex + 1}}/{{tests.length}}</h1>
		</div>
		<div class="test_pogination_responsive">
			<ul class="test_pogination" v-if="tests.length > 0">
				<li v-for="(item,index) in tests" :class="index == nextItemIndex ? 'active' : ''">
					<span class="pe-7s-ribbon"></span>
					<p>{{index+1}}</p>
				</li>
			</ul>
		</div>
		<template v-for="(item,index) in showItem" v-if="showItem.length">
			<template v-if="item">
				<div class="test_question_block">
				 	{{item.title}} ?
				</div>
				<div class="test_answers_block" v-for="(variant,i) in item.variants">
					<div class="input_radio_block">
						<input 
							type="radio" 
							:name='"answer"+variant.id' 
							:id='"answer"+variant.id'
							:value="variant.id"
							v-model="answers[index]"
							@change="clickAnswer(variant.question_id,variant.id)"
						>
						<label :for='"answer"+variant.id'>
							<span>{{i+1}})</span>{{variant.title}}
						</label>
					</div>
				</div>
			</template>
		</template>
		<button 
			class="btn btn-success" 
			@click.prevent="prevBtn">
			< prev 
		</button>
		<button 
			class="btn btn-success" 
			@click.prevent="nextBtn"
			:disabled="disabledTrue"
		>
			next >
		</button>
		<button 
			v-if="tests.length == myAnswers.length"
			class="btn btn-success" 
			@click.prevent="completeTest">
			complete test
		</button>
		<div class="base-timer">
			<svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
				<g class="base-timer__circle">
				<circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
				<path
					id="base-timer-path-remaining"
					stroke-dasharray="283"
					class="base-timer__path-remaining blue ${remainingPathColor}"
					d="
					M 50, 50
					m -45, 0
					a 45,45 0 1,0 90,0
					a 45,45 0 1,0 -90,0
					"
				></path>
				</g>
			</svg>
			<span id="base-timer-label" class="base-timer__label">{{formatTime(timeLeft)}}</span>
		</div>
	</div>
</template>		
<script>
	const FULL_DASH_ARRAY = 283;
	const WARNING_THRESHOLD = 10;
	const ALERT_THRESHOLD = 5;
	const COLOR_CODES = {
		info: {
			color: "green"
		},
		warning: {
			color: "orange",
			threshold: WARNING_THRESHOLD
		},
		alert: {
			color: "red",
			threshold: ALERT_THRESHOLD
		}
	};
	let remainingPathColor = COLOR_CODES.info.color;
	import {mapActions, mapGetters} from 'vuex'
	import {TokenService} from './../../services/storage.service'
	export default{
		data(){
			return{
				answers:[],
				userInfo:[],
				tests:[],
				chosenAnswerID:null,
				nextItemIndex:null,
				myAnswers:[],
				timePassed:0,
				timeLeft:300,
				TIME_LIMIT:300,
				timerInterval:null,
			}
		},
		async mounted(){
			if (TokenService.getGuestInfo()) {
				await this.actionStartTest(TokenService.getGuestInfo())
				this.startTimer();
				this.userInfo = this.getTests.attestat
				this.tests = this.getTests.result
				this.timeLeft = this.getTests.total_time
				this.TIME_LIMIT = this.getTests.total_time
			}else{
				this.$router.push("/crm/test/start-test");
			}
		},
		computed:{
			...mapGetters('test',['getTests','getMassage','getComplete']),
			showItem(){
				if (this.tests.length > 0) {
					let newArr = this.tests.map((item,index)=>{
						if(this.chosenAnswerID == null){
							if (index == 0) {
								this.nextItemIndex = index
								return item
							}
						}else{
							if (this.chosenAnswerID == parseInt(item.id)) {
								this.nextItemIndex = index
								return item
							}
						}
					})
					return newArr;
				}
			},
			disabledTrue(){
				if(this.myAnswers.length == this.tests.length){
					return false
				}else{
					if (this.myAnswers.length != (this.nextItemIndex+1)) {
						return true
					}else{
						return false
					}
				}
			}
		},
		methods:{
			...mapActions('test',['actionCompleteTest','actionStartTest']),
			async completeTest(){
				if (this.tests.length == this.myAnswers.length) {
					let data = {
						attestat_id:this.userInfo.id,
						questions:this.myAnswers
					}
					await this.actionCompleteTest(data)
					TokenService.removeGuestInfo()
				}
			},
			prevBtn(){
				if (this.tests[this.nextItemIndex-1]) {
					this.chosenAnswerID = this.tests[this.nextItemIndex-1].id
				}
			},
			nextBtn(){
				if (this.tests[this.nextItemIndex+1]) {
					this.chosenAnswerID = this.tests[this.nextItemIndex+1].id
				}
			},
			clickAnswer(qID,ansID){	
				this.myAnswers = this.myAnswers.filter((item,index)=>{
					if (item) {
						if (item.id != parseInt(qID)) {
							return item 
						}
					}	
				})
				this.myAnswers.push({id:parseInt(qID),answer_id:ansID})
				console.log(this.myAnswers.length)
				console.log(this.nextItemIndex+1)
			},
			onTimesUp() {
				clearInterval(this.timerInterval);
			},
			chooseAnswer(id){
				this.chosenAnswerID = id
			},
			startTimer() {
				this.timerInterval = setInterval(() => {
					this.timePassed = this.timePassed += 1;
					this.timeLeft = this.TIME_LIMIT - this.timePassed;
					document.getElementById("base-timer-label").innerHTML = this.formatTime(
					this.timeLeft
					);
					this.setCircleDasharray();
					this.setRemainingPathColor(this.timeLeft);

					if(this.timeLeft === 0){
						this.onTimesUp();
					}
				}, 1000);
			},

			formatTime(time) {
				const minutes = Math.floor(time / 60);
				let seconds = time % 60;

				if (seconds < 10) {
					seconds = `0${seconds}`;
				}

				return `${minutes}:${seconds}`;
			},
			setRemainingPathColor(timeLeft) {
				const { alert, warning, info } = COLOR_CODES;
				if (timeLeft <= alert.threshold) {
					document
					.getElementById("base-timer-path-remaining")
					.classList.remove(warning.color);
					document
					.getElementById("base-timer-path-remaining")
					.classList.add(alert.color);
				} else if (timeLeft <= warning.threshold) {
					document
					.getElementById("base-timer-path-remaining")
					.classList.remove(info.color);
					document
					.getElementById("base-timer-path-remaining")
					.classList.add(warning.color);
				}
			},
			calculateTimeFraction() {
				const rawTimeFraction = this.timeLeft / this.TIME_LIMIT;
				return rawTimeFraction - (1 / this.TIME_LIMIT) * (1 - rawTimeFraction);
			},
			setCircleDasharray(){
				const circleDasharray = `${(
					this.calculateTimeFraction() * FULL_DASH_ARRAY
				).toFixed(0)} 283`;
				document
					.getElementById("base-timer-path-remaining")
					.setAttribute("stroke-dasharray", circleDasharray);
			},
		}
	}
</script>
<style scoped>

</style>