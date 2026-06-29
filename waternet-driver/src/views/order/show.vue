<template>
	<app-layout>
		<div id="appCapsule">
			<div class="show-wrap">

				<!-- Client card -->
				<div class="client-card">
					<div class="client-head">
						<div class="client-avatar">{{ initials(order.client.fullname) }}</div>
						<div class="client-id">
							<h3 class="client-name">{{ order.client.fullname }}</h3>
							<a :href="'tel:+998' + order.client.phone" class="client-phone">
								<i class="fa-solid fa-phone"></i> {{ order.client.phone }}
							</a>
						</div>
					</div>

					<div class="stat-row">
						<div class="stat" :class="{ danger: order.client.balance < 0 }">
							<span class="stat-label">{{ $t('detail.balance') }}</span>
							<span class="stat-value">{{ formatMoney(order.client.balance) }}</span>
						</div>
						<div class="stat" :class="{ warn: order.client.container > 0 }">
							<span class="stat-label">{{ $t('detail.containerDebt') }}</span>
							<span class="stat-value">{{ order.client.container }}</span>
						</div>
					</div>

					<div class="info-rows">
						<div class="info-row">
							<i class="fa-solid fa-calendar-day"></i>
							<span class="k">{{ $t('detail.date') }}</span>
							<span class="v">{{ formatdate(order.created_at) }}</span>
						</div>
						<div class="info-row" v-if="order.client.phone2">
							<i class="fa-solid fa-phone-volume"></i>
							<span class="k">{{ $t('detail.additionalPhone') }}</span>
							<span class="v">{{ order.client.phone2 }}</span>
						</div>
						<div class="info-row">
							<i class="fa-solid fa-city"></i>
							<span class="k">{{ $t('detail.region') }}</span>
							<span class="v">{{ order.client.city.name }}</span>
						</div>
						<div class="addr-block">
							<i class="fa-solid fa-location-dot"></i>
							<div class="addr-inner">
								<span class="k">{{ $t('detail.address') }}</span>
								<p class="addr-text">{{ clientAddress() }}</p>
							</div>
						</div>
					</div>
				</div>

				<!-- Product card -->
				<div class="product-card">
					<div class="product-ico"><i class="fa-solid fa-bottle-water"></i></div>
					<div class="product-main">
						<h4 class="product-name">{{ order.product.name }}</h4>
						<span class="product-sub">{{ $t('detail.orderComment') }}: {{ order.comment || '—' }}</span>
					</div>
					<div class="product-figures">
						<div><b>{{ order.product_count }}</b><span>{{ $t('order.count') }}</span></div>
						<div><b>{{ order.price }}</b><span>{{ $t('detail.price') }}</span></div>
					</div>
				</div>

				<!-- Delivery form -->
				<form id="success-form" class="form-card" @submit.prevent="submit">
					<div class="form-card-title">
						<i class="fa-solid fa-truck-fast"></i> {{ $t('detail.delivered') }}
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.delivered') }}</label>
									<input v-model="sod.sold_product_count" class="form-control" required type="number">
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.price') }}</label>
									<input v-model="sod.sold_product_price" class="form-control" required type="number">
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.status') }}</label>
									<select v-model="sod.order_status" class="form-select" required>
										<option v-for="(type, id) in order_statuses" :key="id" :value="id" v-text="type">
										</option>
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
										<option v-for="(type, id) in payment_types" :key="id" :value="id" v-text="type">
										</option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.returnedContainers') }}</label>
									<input v-model="sod.container" class="form-control" required type="number">
								</div>
							</div>
						</div>

						<div class="col-6">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.invalidContainers') }}</label>
									<input v-model="sod.invalid_container_count" class="form-control" required
										type="number">
								</div>
							</div>
						</div>

						<div class="col-12">
							<div class="form-group boxed">
								<div class="input-wrapper">
									<label class="label">{{ $t('detail.paymentAmount') }}:
										{{ formatMoney(sod.sold_product_count * sod.sold_product_price) }}</label>
									<input v-model="sod.amount" :disabled="amountDisabled" class="form-control" required id="sod_amount" type="number">
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

					<div class="form-actions">
						<button type="button" @click="addLocation(order)" class="fa-act fa-loc" :disabled="locLoading">
							<span v-if="locLoading" class="spinner-border spinner-border-sm" role="status"></span>
							<i v-else class="fa-solid fa-map-pin"></i>
							{{ $t('detail.addNavigate') }}
						</button>
						<button type="submit" class="fa-act fa-ok" form="success-form" :disabled="loading">
							<span v-if="loading" aria-hidden="true" class="spinner-border spinner-border-sm me-1"
								role="status"></span>
							<i v-else class="fa-solid fa-check"></i>
							{{ $t('detail.success') }}
						</button>
					</div>
				</form>

			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/components/AppLayout";
import { Geolocation } from "@capacitor/geolocation";

import { App as CapacitorApp } from '@capacitor/app';

export default {
	name: "show",
	components: { AppLayout },

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
			locLoading: false,
			amountDisabled: false,
			mapUrl: ``
		}
	},

	mounted() {
		this.getLocation()
		this.getOrder()
		this.makeMapUrl()

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({ canGoBack }) => {
				this.$router.push({ name: 'order' })
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
		initials(name) {
			if (!name) return '?'
			const parts = name.trim().split(/\s+/)
			const first = parts[0] ? parts[0][0] : ''
			const second = parts[1] ? parts[1][0] : ''
			return (first + second).toUpperCase()
		},

		clientAddress() {
			const c = this.order.client || {}
			const parts = [
				c.city && c.city.name,
				c.area && c.area.name,
				c.street,
				c.home_number,
				c.entrance,
				c.floor,
				c.apartment_number,
				c.address
			]
			return parts.filter(p => p && String(p).trim().length > 1).join(', ')
		},

		formatdate(data) {
			const dateUTC = new Date(data);
			var day = dateUTC.getDate();
			var month = dateUTC.getMonth();
			var year = dateUTC.getFullYear();
			var hours = dateUTC.getHours();
			var minute = dateUTC.getMinutes();

			if (day < 10) day = '0' + day;
			if (month < 10) month = '0' + month;
			return day + '-' + month + '-' + year + ' ' + hours + ':' + minute;
		},
		getLocation() {
			Geolocation.getCurrentPosition().then(coordinates => {
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

		addLocation(order) {
			this.locLoading = true

			Geolocation.getCurrentPosition({
				enableHighAccuracy: true,
				timeout: 5000,
			}).then(coordinates => {
				this.origin.lat = coordinates.coords.latitude
				this.origin.lng = coordinates.coords.longitude

				return $axios.post('/api/client/add-location', {
					client_id: order.client_id,
					lat: this.origin.lat,
					lng: this.origin.lng
				})
			}).then(response => {
				Swal.fire({
					icon: "success",
					title: response.data.message
				})
			}).finally(() => {
				this.locLoading = false
			})
		},

		async getOrder() {
			let orders = await $storage.get('orders')
			this.order = orders.filter(order => order.id == this.$route.params.id)[0]
			this.sod.sold_product_count = this.order.product_count
			this.sod.sold_product_price = this.order.price
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
					let { data } = response;
					let balance = this.formatMoney(data.balance)

					$notify.success({
						name: this.$t('toast.orderSuccess'),
						title: this.$t('toast.success'),
						info: `<strong class="me-1">${this.$t('toast.balance')}:</strong>${balance} <br> <strong class="me-1">${this.$t('toast.containerDebt')}:</strong>${data.container}`
					})

					this.$router.push({ name: 'order' })

				}).catch(error => {

					if (!error.response) {
						let success_order = this.order;
						let success_order_sod = this.sod;

						$storage.get('success_orders').then(success_orders => {
							if (!success_orders) {
								success_orders = []
							}

							success_orders.push({
								id: this.order.id,
								order: success_order,
								sod: success_order_sod
							})

							$storage.set('success_orders', success_orders)

							$notify.error({
								name: this.$t('toast.warningOrder'),
								title: this.$t('toast.warningOrder'),
								info: this.$t('toast.addedLocal')
							})

							this.$router.push({ name: 'order' })
						});
					}
				}).finally(() => {
					this.loading = false
				})
		}
	}

}
</script>

<style scoped>
.show-wrap {
	padding: 10px 14px 0;
}

/* Client card */
.client-card {
	background: #fff;
	border-radius: 20px;
	box-shadow: 0 12px 28px -16px rgba(11, 31, 58, .25);
	border: 1px solid rgba(11, 31, 58, .05);
	padding: 16px;
	margin-bottom: 14px;
}

.client-head {
	display: flex;
	align-items: center;
	gap: 13px;
}

.client-avatar {
	width: 54px;
	height: 54px;
	flex: 0 0 54px;
	border-radius: 16px;
	background: linear-gradient(135deg, #7CB0F7, #62CDEE);
	color: #fff;
	font-weight: 700;
	font-size: 19px;
	display: flex;
	align-items: center;
	justify-content: center;
	box-shadow: 0 8px 16px -8px rgba(37, 99, 235, .45);
}

.client-name {
	font-size: 18px;
	font-weight: 700;
	color: #0B1F3A;
	margin: 0 0 3px;
}

.client-phone {
	font-size: 13.5px;
	color: #2563EB;
	font-weight: 600;
}

.client-phone i {
	font-size: 12px;
	margin-right: 3px;
}

.stat-row {
	display: flex;
	gap: 10px;
	margin: 14px 0 4px;
}

.stat {
	flex: 1;
	background: #F2F6FB;
	border-radius: 14px;
	padding: 10px 13px;
}

.stat.danger {
	background: #FFF1F2;
}

.stat.warn {
	background: #FFF7E8;
}

.stat-label {
	display: block;
	font-size: 11px;
	color: #8295ad;
	margin-bottom: 2px;
}

.stat-value {
	display: block;
	font-size: 17px;
	font-weight: 700;
	color: #0B1F3A;
}

.stat.danger .stat-value {
	color: #E11D48;
}

.stat.warn .stat-value {
	color: #D97706;
}

.info-rows {
	margin-top: 10px;
}

.info-row {
	display: flex;
	align-items: center;
	gap: 10px;
	padding: 9px 0;
	border-top: 1px solid #f1f5f9;
	font-size: 13.5px;
}

.info-row i {
	color: #2563EB;
	flex: 0 0 18px;
	text-align: center;
	font-size: 13px;
}

.info-row .k {
	color: #8295ad;
}

.info-row .v {
	margin-left: auto;
	font-weight: 600;
	color: #0B1F3A;
	text-align: right;
}

.addr-block {
	display: flex;
	align-items: flex-start;
	gap: 10px;
	padding: 10px 0 2px;
	border-top: 1px solid #f1f5f9;
}

.addr-block > i {
	color: #2563EB;
	flex: 0 0 18px;
	text-align: center;
	font-size: 13px;
	margin-top: 3px;
}

.addr-inner .k {
	display: block;
	font-size: 11px;
	color: #8295ad;
	margin-bottom: 2px;
}

.addr-text {
	margin: 0;
	font-size: 13.5px;
	font-weight: 600;
	color: #0B1F3A;
	line-height: 1.45;
}

/* Product card */
.product-card {
	display: flex;
	align-items: center;
	gap: 13px;
	background: linear-gradient(135deg, #EAF3FF, #E4F5FE);
	border: 1px solid rgba(37, 99, 235, .12);
	border-radius: 20px;
	padding: 15px 16px;
	margin-bottom: 14px;
	box-shadow: 0 10px 24px -18px rgba(37, 99, 235, .5);
}

.product-ico {
	width: 44px;
	height: 44px;
	flex: 0 0 44px;
	border-radius: 13px;
	background: #fff;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #2563EB;
	font-size: 20px;
	box-shadow: 0 5px 12px -5px rgba(37, 99, 235, .45);
}

.product-main {
	flex: 1;
	min-width: 0;
	color: #13315C;
}

.product-name {
	font-size: 16px;
	font-weight: 700;
	margin: 0;
	color: #13315C;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.product-sub {
	font-size: 12px;
	color: #6b86a8;
}

.product-figures {
	display: flex;
	gap: 14px;
	text-align: center;
}

.product-figures b {
	display: block;
	font-size: 17px;
	font-weight: 700;
	line-height: 1;
	color: #1D4ED8;
}

.product-figures span {
	font-size: 10px;
	color: #8295ad;
}

/* Form card */
.form-card {
	background: #fff;
	border-radius: 20px;
	box-shadow: 0 12px 28px -16px rgba(11, 31, 58, .25);
	border: 1px solid rgba(11, 31, 58, .05);
	padding: 8px 14px 16px;
}

.form-card-title {
	font-size: 15px;
	font-weight: 700;
	color: #0B1F3A;
	padding: 10px 2px 4px;
}

.form-card-title i {
	color: #2563EB;
	margin-right: 6px;
}

.form-actions {
	display: flex;
	gap: 10px;
	margin-top: 6px;
}

.fa-act {
	flex: 1;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	border: 0;
	border-radius: 14px;
	padding: 13px 0;
	font-size: 14.5px;
	font-weight: 600;
	color: #fff;
}

.fa-act.fa-loc {
	background: linear-gradient(135deg, #F59E0B, #F97316);
}

.fa-act.fa-ok {
	background: linear-gradient(135deg, #16B981, #0EA5A4);
}

.fa-act:active {
	transform: scale(.98);
}
</style>