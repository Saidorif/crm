<template>
	<div class="for_guest">
		<div class="test_header">
			<h1>Fullname: Amanullayev Javoxir</h1>
			<h1 class="pr-100">01/50</h1>
		</div>
		<div class="test_pogination_responsive">
			<ul class="test_pogination">
				<li v-for="item in 50" :class="item == 1 ? 'active' : ''">
					<span class="pe-7s-ribbon"></span>
					<p>{{item}}</p>
				</li>
			</ul>
		</div>

		<div class="test_question_block">
			1) Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius ex, quae itaque repellendus qui tempora hic ullam ipsa quidem! Commodi laudantium aliquid itaque reiciendis doloremque ratione tenetur, rerum quam aliquam?
		</div>
		<div class="test_answers_block">
			<div class="input_radio_block">
				<input type="radio" name="question1" id="answera">
				<label for="answera"><span>A)</span> Lorem ipsum</label>
			</div>
			<div class="input_radio_block">
				<input type="radio" name="question1" id="answerb">
				<label for="answerb"><span>A)</span> Eius ex</label>
			</div>
			<div class="input_radio_block">
				<input type="radio" name="question1" id="answerc">
				<label for="answerc"><span>C) Commodi laudantium</span></label>
			</div>
			<div class="input_radio_block">
				<input type="radio" name="question1" id="answerd">
				<label for="answerd"><span>D) Rerum quam</span></label>
			</div>
		</div>
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
			<span id="base-timer-label" class="base-timer__label">{{this.formatTime(timeLeft)}}</span>
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
	const TIME_LIMIT = 300;
	let timePassed = 0;
	let timeLeft = TIME_LIMIT;
	let timerInterval = null;
	let remainingPathColor = COLOR_CODES.info.color;
	export default{
		data(){
			return{}
		},
		mounted(){
			this.startTimer();
		},
		methods:{
			onTimesUp() {
				clearInterval(timerInterval);
			},
			startTimer() {
				timerInterval = setInterval(() => {
					timePassed = timePassed += 1;
					timeLeft = TIME_LIMIT - timePassed;
					document.getElementById("base-timer-label").innerHTML = this.formatTime(
					timeLeft
					);
					this.setCircleDasharray();
					this.setRemainingPathColor(timeLeft);

					if (timeLeft === 0) {
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
				const rawTimeFraction = timeLeft / TIME_LIMIT;
				return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
			},

			setCircleDasharray() {
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