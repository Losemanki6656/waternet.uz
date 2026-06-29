<template>
	<app-layout>
		<div id="appCapsule">
			<app-skeleton v-if="loading" variant="list" :count="5" />
			<div v-else class="section mb-2">

				<div class="wallet-card mt-2 py-2 px-3" v-for="order in orders" :key="order.id">
					<router-link :to="{name: 'application.show', params: {id: order.id}}">
						<div class="row">
							<div class="col-7">
								<h4 class="fw-bold text-primary">{{ order.client.fullname }}</h4>
							</div>
							<div class="col-5 text-end">
								<h4 class="text-secondary">{{ order.product.name }}</h4>
							</div>
							<hr class="text-center w-100 my-1">

							<div class="col-9"><span class="label">{{ $t('order.comment') }}</span></div>
							<div class="col-3"><span class="label">{{ $t('order.count') }}</span></div>

							<div class="col-9"><h4>{{ order.comment }}</h4></div>
							<div class="col-3"><h4>{{ order.product_count }}</h4></div>

						</div>

						<div class="row">
							<div class="col-12"><span class="label">{{ $t('order.address') }}</span></div>
							<div class="col-12">
								<h4>
									{{ getFullAddress(order) }}
								</h4>
							</div>
						</div>

					</router-link>

				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/components/AppLayout";
import AppSkeleton from "@/components/AppSkeleton";
import _ from "lodash";
import {App as CapacitorApp} from '@capacitor/app';

export default {
	name: "Index",
	components: {AppLayout, AppSkeleton},

	data() {
		return {
			loading: true,
			orders: []
		}
	},

	mounted() {
		$storage.get('success_orders').then(success_orders => {
			this.$store.state.applications = success_orders
			this.orders = _.map(success_orders, 'order').reverse()
		}).finally(() => {
			this.loading = false
		})

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({canGoBack}) => {
				this.$router.push({name: 'order'})
			})
		})

	},

	methods: {
		getFullAddress(order) {

			let address = '';

			if (order.client.city.name.length > 1) address += order.client.city.name +  ', '
			if (order.client.area.name.length > 1) address += order.client.area.name + ', '
			if (order.client.street.length > 1) address += order.client.street +  ', '
			if (order.client.home_number.length > 1) address += order.client.home_number + ', '
			if (order.client.entrance.length > 1) address += order.client.entrance + ', '
			if (order.client.floor.length > 1) address += order.client.floor + ', '
			if (order.client.apartment_number.length > 1) address += order.client.apartment_number + ', '
			if (order.client.address.length > 1) address += order.client.address + ', '

			return address.substring(0, address.length - 2)

		},
	}
}
</script>

<style scoped>

</style>