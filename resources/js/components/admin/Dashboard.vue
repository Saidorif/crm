<template>
	<div class="dashboard">
		<Loader v-if="loading" />
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-rocket"></i>
				    {{ $t('admin_menu.admin_panel') }}
				</h4>
		  	</div>
		  	<div class="card-body">
	  			<div class="row">
	  				<div class="col-md-6 chartBlock" v-if="loaded" >
						  <div class="chartBlock_item">
	  						<Bar :propchartdata="this.agesData" :propLabel="$t('dashboard.chart_age')" :propColor="['#f09311', '#0b9ca6', '#bc1b21', '#76cac1']"/>
						  </div>
	  				</div>
	  				<div class="col-md-6 chartBlock" v-if="loaded">
						  <div class="chartBlock_item">
	  						<!-- <Pie :propchartdata="this.getDashboard.tests" :propLabel="$t('dashboard.chart_exper')" :propColor="['#3f6ad8', '#3fd86e', '#387324', '#d42e2e', '#0A2463', '#FB3640','#605F5E','#247BA0','#E2E2E2','#FFC6D9','#FFE1C6','#FFF7AE','#48284A']"/> -->
	  						<Line-chart :propchartdata="this.getDashboard.tests" :propLabel="$t('dashboard.chart_exper')" :propColor="['#3f6ad8', '#3fd86e', '#387324', '#d42e2e', '#0A2463', '#FB3640','#605F5E','#247BA0','#E2E2E2','#FFC6D9','#FFE1C6','#FFF7AE','#48284A']" />
						  </div>
	  				</div>
					<!-- <div class="col-md-6 chartBlock" v-if="loaded">
						<div class="chartBlock_item">
	  						<Pie :propchartdata="this.usersData" :propLabel="$t('dashboard.chart_sex')" :propColor="['#3f6ad8', '#3fd86e', '#387324', '#d42e2e']"/>
						</div>
	  				</div>
					<div class="col-md-6 chartBlock" v-if="loaded">
						<div class="chartBlock_item">
	  						<Bar :propchartdata="this.testsData" :propLabel="$t('dashboard.chart_test')" :propColor="['#3f6ad8', '#3fd86e', '#387324', '#d42e2e']"/>
						</div>
	  				</div> -->
	  			</div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import Bar from './chart/Bar'
	import LineChart from './chart/LineChart'
	import Pie from './chart/Pie'
	import Loader from '../Loader'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			Bar,
			LineChart,
			Pie,
			Loader
		},
		data(){
			return{
				loaded: false,
				loading: true,
				testsData: {},
				usersData: {},
				agesData: {},
			}
		},
		computed:{
			...mapGetters('dashboard',['getDashboard'])
		},
		methods:{
			...mapActions('dashboard',['actionDashboard']),
		},
		async mounted(){
			await this.actionDashboard()
			Object.keys(this.getDashboard.ages).forEach(element => {
				this.agesData[element] =  parseFloat(this.getDashboard.ages[element].percent).toFixed(2)
			});
			this.testsData = {"Август": 5, "Апрель": 2, "Декабр": 3, "Июль": 5, "Июнь": 3, "Май": 10, "Март": 24, "Ноябр": 12, "Октябр": 2, "Сентябр": 6, "Февраль": 3, "Январь": 2}
			this.loading = false;
			// this.getDashboard.tests.forEach((elem, key) => {
			// 	if(elem.status == 'complete'){
			// 		this.testsData['Завершено'] = parseInt(elem.total)
			// 	}else if(elem.status == 'fail'){
			// 		this.testsData['Неудавшийся'] = parseInt(elem.total)
			// 	}else if(elem.status == 'progress'){
			// 		this.testsData['Прогресс'] = parseInt(elem.total)
			// 	}else if(elem.status == 'start'){
			// 		this.testsData['Начало'] = parseInt(elem.total)
			// 	}
			// });
			// this.getDashboard.users.forEach((elem, key) => {
			// 	this.usersData[elem.gender == 'male' ? 'Мужчина' : 'Женщина' ] = parseInt(elem.total)
			// });
			
			this.loaded = true;
		}
	}
</script>
<style  scoped>
.card{
	box-shadow: none;
    background-color: #f1f4f6;
}
.chartBlock_item{
	    box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
		background: #fff;
		margin-bottom: 30px;
		padding: 30px;
}
.card-body{
	padding-bottom: 0;
}
.card-header{
	background: #fff;
}
</style>