<template>
	<canvas ref="canvas" height="400"></canvas>
</template>
<script>
import { Bar } from 'vue-chartjs'
export default {
  	extends: Bar,
	props: ['propchartdata', 'propLabel', 'propColor'],
	data(){
		return{
			chartdata: {
				labels: Object.keys(this.propchartdata),
				datasets: [
					{
						label: this.propLabel,
						backgroundColor: this.propColor,
						data: Object.values(this.propchartdata)
					}
				]
			},
			options: {
				responsive: true,
				type: Object,
				default: null,
				maintainAspectRatio: false
			},
		}
	},
	mounted () {
		this.renderChart(this.chartdata, this.options)
	}
}
</script>
<style scoped>
	
</style>

