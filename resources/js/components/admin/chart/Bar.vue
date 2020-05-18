<template>
	<canvas ref="canvas" height="400"></canvas>
</template>
<script>
import { Bar } from 'vue-chartjs'

export default {
  	extends: Bar,
	props: {
		chartdata: {
			type: Object,
			default: null
		},
		options: {
		   	responsive: true,
			type: Object,
			default: null
		},
	},
	mounted () {
		this.renderChart(this.chartdata, this.options)
	}
}
</script>
<style scoped>
	
</style>