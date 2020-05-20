<template>
	<div class="dashboard">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-rocket"></i>
				    Админ панель
				</h4>
		  	</div>
		  	<div class="card-body">
	  			<div class="row">
	  				<div class="col-md-3" v-if="loaded">
	  					<Bar :propchartdata="this.getDashboard.ages" propLabel="Yoshi" :propColor="['#f87979', '#b87979', '#000', 'red']"/>
	  				</div>
	  				<div class="col-md-3" v-if="loaded">
	  					<Pie :propchartdata="this.getDashboard.staj" propLabel="Staj" propColor="#b87979"/>
	  				</div>
	  			</div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import Bar from './chart/Bar'
	import Line from './chart/Line'
	import Pie from './chart/Pie'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			Bar,
			Line,
			Pie,
		},
		data(){
			return{
				loaded: false,
			}
		},
		computed:{
			...mapGetters('dashboard',['getDashboard'])
		},
		methods:{
			...mapActions('dashboard',['actionDashboard'])
		},
		async mounted(){
			await this.actionDashboard()
			this.loaded = true
		}
	}
</script>