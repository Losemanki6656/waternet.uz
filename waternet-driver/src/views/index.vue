<template>

</template>

<script>
export default {
	name: "index",
	mounted() {

		$storage.get('access_token').then(r => {
			if (r.length > 0) {
				if (window.$tracker) window.$tracker.start()
				this.$router.push({name: 'order'})
			} else {
				this.$store.commit('getSelectData')
				this.$router.push({name: 'login'})
			}
		}).catch(() => {
			this.$router.push({name: 'login'})
		})

		$storage.get('user').then(user => {
			this.$store.state.user = user
		})

		$storage.get('orders').then(orders => {
			this.$store.state.orders = orders
		})

		$storage.get('success_orders').then(applications => {
			this.$store.state.applications = applications
		})

		$storage.get('order_statuses').then(order_statuses => {
			this.$store.state.order_statuses = order_statuses
		})

		$storage.get('payment_types').then(payment_types => {
			this.$store.state.payment_types = payment_types
		})
	}
}
</script>

<style scoped>

</style>