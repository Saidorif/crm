<template>
	<div class="show_test_result">
		
	</div>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	export default{
		data(){
			return{

			}
		},
		async mounted(){
			await this.actionShowTest(this.$route.params.showTestId)
			console.log(this.getTest)
		},
		methods:{
			...mapActions('test',['actionShowTest']),
		},
		computed:{
			...mapGetters('test',['getTest'])
		}
	}
</script>
<style scoped>
	
</style>