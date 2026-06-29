<template>
	<div class="appHeader bg-primary text-light">
		<div class="left">
			<a v-if="$route.name === 'order'" href="#" class="headerButton" data-bs-toggle="modal"
				data-bs-target="#sidebarPanel">
				<i class="fa fa-bars"></i>
			</a>
			<a v-else class="headerButton" @click="goBack">
				<i class="fa-solid fa-arrow-left"></i>
			</a>
		</div>
		<div class="pageTitle">
			<span class=""> {{ pageTitle }} </span>
		</div>
		<div class="right">
			<a v-if="$route.name === 'order'" class="headerButton" data-bs-toggle="modal" data-bs-target="#FilterPanelRight">
				<i class="fa fa-filter"></i>
			</a>

			<a @click="submitAllApplications" v-if="$route.name === 'application'" class="headerButton">
				<i class="fa fa-list-check"></i>
			</a>
		</div>
	</div>
</template>

<script>

import _ from "lodash";

export default {
	name: "AppHeader",

	computed: {
		pageTitle: function () {
			const map = {
				order: 'nav.orders',
				region: 'nav.regions',
				application: 'nav.applications',
				monitoring: 'nav.monitoring',
				map: 'nav.map'
			}
			const key = map[this.$route.name]
			return key ? this.$t(key) : this.$t('appName')
		}
	},

	methods: {
		goBack() {
			if (window.history.length > 1) {
				this.$router.back()
			} else {
				this.$router.push({ name: 'order' })
			}
		},

		async submitAllApplications() {
			let count = 0;

			this.$store.state.applications.forEach((order) => {
				console.log(order)
				order.sod.order_id = order.id
				$axios.post('/api/success-order', order.sod).then(response => {
					let success_orders = _.reject($storage.get('success_orders'), { id: order.id })
					$storage.set('success_orders', success_orders)
				})
				count++
			})

			await Swal.fire({
				title: 'Success',
				icon: 'success',
				html: `${count} order successes !`
			}).then(() => {
				this.$router.push({ name: 'order' })
			})
		}
	}
}
</script>

<style scoped></style>