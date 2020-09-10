<template>
	<canvas ref="canvas" height="400"></canvas>
</template>
<script>
import { Pie } from 'vue-chartjs'
export default {
  extends: Pie ,
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
        ],
			},
			options: {
				type: Object,
				default: null,
				title: {
					display: true,
					text: this.propLabel
				}
			},
		}
	},
	mounted () {
		this.renderChart(this.chartdata, this.options)
	}
}