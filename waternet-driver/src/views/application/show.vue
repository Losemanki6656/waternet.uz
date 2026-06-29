<template>
	<app-layout>
		<div id="appCapsule">
			<div class="section mt-2 mb-2">

				<div class="card">
					<div class="table-responsive">
						<table class="table rounded">
							<thead>
							<tr>
								<th scope="col">{{ $t('detail.client') }}: <br> <span class="fw-normal">{{
										order.client.fullname
									}}</span></th>
								<th scope="col" style="vertical-align: top">{{ $t('detail.phone') }}: <br> <span
									class="fw-normal">{{ order.client.phone }}</span></th>
							</tr>
							</thead>

							<tbody>
							<tr>
								<td>{{ $t('detail.region') }}: {{ order.client.city.name }}</td>
								<td>{{ $t('detail.address') }}: {{ order.client.address }}</td>
							</tr>

							<tr>
								<td class="text-danger">{{ $t('detail.balance') }}: {{ formatMoney(order.client.balance) }}</td>
								<td class="text-danger">{{ $t('detail.containerDebt') }}: {{ order.client.container }}</td>
							</tr>

							<tr>
								<td>{{ $t('detail.productName') }}: {{ order.product.name }}</td>
								<td>{{ $t('detail.orderQuantity') }}: {{ order.product_count }}</td>
							</tr>

							<tr>
								<td>{{ $t('detail.productPrice') }}: {{ order.price }}</td>
								<td>{{ $t('detail.orderComment') }}: {{ order.comment }}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="section mt-2 mb-2">

				<form id="success-form" @submit.prevent="submit">
					<div class="row">
						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.delivered') }}</label>
									<input v-model="sod.sold_product_count"
									       class="form-control"
									       required
									       type="number">
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.price') }}</label>
									<input v-model="sod.sold_product_price"
									       class="form-control"
									       required
									       type="number">
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.status') }}</label>
									<select v-model="sod.order_status" class="form-select" required>
										<option v-for="(type, id) in order_statuses" :key="id" :value="id"
										        v-text="type"></option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.paymentType') }}</label>
									<select v-model="sod.payment" class="form-select"
									        @change="paymentTypeChange" required>
										<option v-for="(type, id) in payment_types" :key="id" :value="id"
										        v-text="type"></option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.returnedContainers') }}</label>
									<input v-model="sod.container"
									       class="form-control"
									       required
									       type="number">
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.invalidContainers') }}</label>
									<input v-model="sod.invalid_container_count"
									       class="form-control"
									       required
									       type="number">
								</div>
							</div>
						</div>

						<div class="col-12">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.paymentAmount') }}:
										{{ formatMoney(sod.sold_product_count * sod.sold_product_price) }}</label>
									<input v-model="sod.amount"
									       :disabled="amountDisabled"
									       class="form-control"
									       required
									       id="sod_amount"
									       type="number">
								</div>
							</div>
						</div>

						<div class="col-12">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<textarea v-model="sod.comment" class="form-control" :placeholder="$t('detail.comment')"></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="row mb-1">
						<div class="col-12 mb-1">
							<button type="submit" class="btn btn-block btn-success" form="success-form">
								<span v-if="loading" aria-hidden="true" class="spinner-grow spinner-grow-sm me-1"
								      role="status"></span>
								<i class="fa fa-check fa-2">&ensp;</i>
								{{ $t('detail.success') }}
							</button>
						</div>
					</div>
				</form>

			</div>


		</div>
	</app-layout>

</template>

<script>
import AppLayout from "@/components/AppLayout";
import {Geolocation} from "@capacitor/geolocation";
import _ from "lodash";
import {App as CapacitorApp} from '@capacitor/app';

export default {
	name: "show",
	components: {AppLayout},

	data() {
		return {
			origin: {
				lat: null,
				lng: null,
			},

			destination: {
				lat: null,
				lng: null,
			},

			order: {
				name: '',
				product_count: 0,
				price: 0,
				comment: '',

				product: {
					name: '',
					product_count: 0,
					price: 0,
					comment: ''
				},
				client: {
					address: '',
					location: '',
					phone: '',
					fullname: '',
					balance: 0,
					container: 0,
					city: {
						name: ''
					}
				}
			},

			payment_types: [],
			order_status: [],
			sod: {
				order_id: null,
				order_status: 1,
				sold_product_count: null,
				sold_product_price: null,
				container: 0,
				invalid_container_count: 0,
				payment: 1,
				amount: 0,
				comment: ""
			},

			loading: false,
			amountDisabled: false,
			mapUrl: ``
		}
	},

	beforeMount() {
		this.getLocation()
		this.getOrder()
		this.makeMapUrl()

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({canGoBack}) => {
				this.$router.push({name: 'application'})
			})
		})
	},

	computed: {
		payment_types: function () {
			return this.$store.state.payment_types
		},

		order_statuses: function () {
			return this.$store.state.order_statuses
		}
	},

	methods: {
		getLocation() {
			Geolocation.getCurrentPosition(coordinates => {
				this.origin.lat = coordinates.coords.latitude
				this.origin.lng = coordinates.coords.longitude
			})
		},

		makeMapUrl() {
			let oLat = this.origin.lat
			let oLng = this.origin.lng
			let location = this.order.client.location

			this.mapUrl = `http://maps.google.com/maps?saddr=${oLat},${oLng}&daddr=${location}`
		},

		getOrder() {
			$storage.get('success_orders').then(orders => {
				let order = orders.filter(order => order.id == this.$route.params.id)[0]

				this.order = order.order
				this.sod = order.sod
			})
		},

		paymentTypeChange() {
			this.amountDisabled = this.sod.payment == 3
			if (this.amountDisabled) {
				this.sod.amount = 0
			}
		},

		submit() {
			this.sod.order_id = this.$route.params.id

			this.loading = true
			$axios.post('/api/success-order', this.sod)
				.then(response => {
					let {data} = response;
					let balance = this.formatMoney(data.balance)
					Swal.fire({
						title: 'Success',
						icon: 'success',
						html: `<strong class="mr-1">Balans:</strong>${balance} <br> <strong class="mr-1">Idish qarzi:</strong>&eng;${data.container}`
					}).then(() => {
						let success_orders = _.reject($storage.get('success_orders'), {id: this.order.id})
						$storage.set('success_orders', success_orders)
						this.$router.push({name: 'order'})
					})

				}).catch(error => {

				if (!error.response) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Please check your internet connection !'
					})
				}

			}).finally(() => {
				this.loading = false
			})
		}
	}

}
</script>

<style scoped>
#iframe-map {
	border: 0;
	width: 100%;
	height: 65vh;
}
</style>