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
	  				<div class="col-md-3">
	  					<Bar/>
	  				</div>
	  			</div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import Bar from './chart/Bar'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			Bar
		},
		data(){
			return{
				
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
			console.log(this.getDashboard)
		}
	}
</script>