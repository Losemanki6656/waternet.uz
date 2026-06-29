<template>
	<app-layout>
		<div id="appCapsule">
			<app-skeleton v-if="loading && !orders.length" variant="order" :count="5" />

			<template v-else>
				<div class="order-search">
					<i class="fa-solid fa-magnifying-glass"></i>
					<input v-model="search" :placeholder="$t('order.search')" type="text">
					<i v-if="search" class="fa-solid fa-xmark order-search-clear" @click="search = ''"></i>
				</div>

				<div class="order-list">

				<div class="order-empty" v-if="!filteredOrders.length">
					<i class="fa-solid fa-box-open"></i>
					<span>{{ $t('order.empty') }}</span>
				</div>

				<div class="order-card" v-for="order in filteredOrders" :key="order.id">
					<router-link class="order-card-body" :to="{ name: 'order.show', params: { id: order.id } }">
						<div class="order-top">
							<div class="order-headings">
								<h4 class="order-client">{{ order.client.fullname }}</h4>
								<span class="order-product">{{ order.product.name }}</span>
							</div>
							<div class="order-qty">{{ order.product_count }}</div>
						</div>

						<div class="order-meta">
							<div class="order-meta-row">
								<i class="fa-solid fa-location-dot"></i>
								<span>{{ getFullAddress(order) }}</span>
							</div>
							<div class="order-meta-row" v-if="order.comment">
								<i class="fa-solid fa-comment-dots"></i>
								<span>{{ order.comment }}</span>
							</div>
						</div>
					</router-link>

					<div class="order-actions">
						<button v-if="order.client.location == '0'" @click="addLocation(order)"
								class="oa-btn oa-addloc">
							<i class="fa-solid fa-plus"></i>
							<span>{{ $t('order.addNavigate') }}</span>
						</button>
						<a v-else :href="makeMapUrl(order)" target="_blank" class="oa-btn oa-navigate">
							<i class="fa-solid fa-diamond-turn-right"></i>
							<span>{{ $t('order.navigate') }}</span>
						</a>

						<a :href="'tel:+998' + order.client.phone" class="oa-btn oa-call">
							<i class="fa-solid fa-phone"></i>
							<span>{{ $t('order.call') }}</span>
						</a>
					</div>
				</div>
			</div>
		</template>
		</div>
	</app-layout>
</template>

<script>

import AppLayout from "@/components/AppLayout";
import AppSkeleton from "@/components/AppSkeleton";
import { Geolocation } from '@capacitor/geolocation';
import _ from "lodash";
import { App as CapacitorApp } from '@capacitor/app';

export default {
	name: 'Order',
	components: { AppLayout, AppSkeleton },

	data() {
		return {
			loading: true,
			search: '',
			lat: null,
			lng: null,

			origin: {
				lat: null,
				lng: null,
			},

			destination: {
				lat: null,
				lng: null,
			},
		}
	},

	computed: {
		orders: function () {
			return this.$store.state.orders_list
		},

		filteredOrders: function () {
			let q = this.search.trim().toLowerCase()
			if (!q) return this.orders

			return this.orders.filter(order => {
				let name = (order.client.fullname || '').toLowerCase()
				let phone = (order.client.phone || '').toString()
				return name.includes(q) || phone.includes(q)
			})
		}
	},

	mounted() {
		this.$store.commit('getSelectData')

		$axios.get('/api/orders').then(response => {
			$storage.set('orders', response.data)
		}).finally(() => {
			$storage.get('orders').then(orders => {
				this.$store.state.orders = orders

				this.getLocation();
				this.withOutSuccessOrders()
			})

			window.onscroll = () => {
				let current = document.documentElement.scrollTop + window.innerHeight;
				let end = document.documentElement.offsetHeight;
				let bottomOfWindow = (end - current) < 3;
				// this.$store.state.appTitle = current + ' ' + end

				if (bottomOfWindow && this.$route.name === 'order') {
					this.getNextPage()
				}
			};
		});

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({ canGoBack }) => {
				CapacitorApp.exitApp()
			})
		})
	},

	methods: {
		initials(name) {
			if (!name) return '?'
			const parts = name.trim().split(/\s+/)
			const first = parts[0] ? parts[0][0] : ''
			const second = parts[1] ? parts[1][0] : ''
			return (first + second).toUpperCase()
		},

		withOutSuccessOrders() {
			$storage.get('orders').then(orders => {
				$storage.get('success_orders').then(success_orders => {
					let ids = _.map(success_orders, 'id');
					this.$store.state.orders = (orders || []).filter(o => !ids.includes(o.id));
					this.getOrders();
					this.loading = false;
				});
			})
		},

		getOrders() {
			let areas = this.$store.state.areas
			let orders = this.$store.state.orders
			let falseAreaIds = _.map(areas.filter(a => a.check === false), 'id')
			let filterOrders = orders.filter(o => !falseAreaIds.includes(o.area_id))

			this.$store.state.orders_data = _.chunk(filterOrders, 15)
			this.$store.state.orders_list = [];
			this.$store.state.page = 0;
			this.getNextPage()

			this.getAreas();
		},

		getNextPage() {
			if (this.$store.state.page < this.$store.state.orders_data.length) {
				this.$store.state.orders_list = Array.from(this.$store.state.orders_list).concat(this.$store.state.orders_data[this.$store.state.page])
				this.$store.state.page = this.$store.state.page + 1
			}
		},

		getAreas() {
			let result = []
			let areas = []

			let old_areas = this.$store.state.areas;
			areas = this.$store.state.orders.map((order) => {
				try {
					let check = true;
					if (old_areas.length) {
						for (let index = 0; index < old_areas.length; index++) {
							if (old_areas[index].id == order.client.area.id)
								check = old_areas[index].check;
						}
					}
					order.client.area.check = check
					return order.client.area
				} catch (e) {
				}
			})

			areas.map(area => {
				try {
					let key = area.id
					if (!result.hasOwnProperty(key)) {
						area.count = 0;
						result[key] = area
					}

					result[key].count++
				} catch (e) {
				}

			})

			this.$store.state.areas = result.filter(r => r !== undefined)
		},

		getFullAddress(order) {

			let address = '';

			if (order.client.city.name.length > 1) address += order.client.city.name + ', '
			if (order.client.area.name.length > 1) address += order.client.area.name + ', '
			if (order.client.street.length > 1) address += order.client.street + ', '
			if (order.client.home_number.length > 1) address += order.client.home_number + ', '
			if (order.client.entrance.length > 1) address += order.client.entrance + ', '
			if (order.client.floor.length > 1) address += order.client.floor + ', '
			if (order.client.apartment_number.length > 1) address += order.client.apartment_number + ', '
			if (order.client.address.length > 1) address += order.client.address + ', '

			return address.substring(0, address.length - 2)

		},

		async getLocation() {
			const coordinates = await Geolocation.getCurrentPosition()

			this.origin.lat = coordinates.coords.latitude
			this.origin.lng = coordinates.coords.longitude
		},

		makeMapUrl(order) {
			// let oLat = this.origin.lat
			// let oLng = this.origin.lng
			let location = order.client.location
			// const myArray = location.split(",");
			// let toLat = myArray[0];
			// let toLong = myArray[1];

			return `geo:${location}`;
			// return `yandexmaps://build_route_on_map?lat_from=${oLat}&lon_from=${oLng}&lat_to=${toLat}&lon_to=${toLong}`;

			// return `https://yandex.ru/maps/?rtext=${oLat},${oLng}~${location}&rtt=mt`;
			// return `https://yandex.ru/maps/?rtext=~${oLat}%2C${oLng}`;
			// return `yandexmaps://maps.yandex.ru/?pt=${oLat},${oLng}4&z=12&l=map`;

			// return `https://yandex.ru/maps?ll=${oLat},${oLng}&daddr=${location}`
		},

		addLocation(order) {

			Geolocation.getCurrentPosition({
				enableHighAccuracy: true,
				timeout: 5000,
			}).then(coordinates => {
				this.origin.lat = coordinates.coords.latitude
				this.origin.lng = coordinates.coords.longitude
			})

			$axios.post('/api/client/add-location', {
				client_id: order.client_id,
				lat: this.origin.lat,
				lng: this.origin.lng
			}).then(response => {
				Swal.fire({
					icon: "success",
					title: response.data.message
				}).then(() => {
					this.$router.go(0)
				})
			})
		}
	}
}
</script>

<style scoped>
.order-search {
	position: sticky;
	top: calc(64px + env(safe-area-inset-top));
	z-index: 90;
	display: flex;
	align-items: center;
	gap: 10px;
	margin: 0 14px 12px;
	padding: 0 14px;
	background: #fff;
	border-radius: 14px;
	border: 1px solid rgba(11, 31, 58, .06);
	box-shadow: 0 8px 20px -12px rgba(11, 31, 58, .4);
}

.order-search > i {
	color: #2563EB;
	font-size: 15px;
}

.order-search input {
	flex: 1;
	border: 0;
	outline: 0;
	background: transparent;
	height: 46px;
	font-size: 14.5px;
	color: #0B1F3A;
}

.order-search-clear {
	color: #8295ad;
	font-size: 15px;
	padding: 6px;
	cursor: pointer;
}

.order-list {
	padding: 0 14px;
}

.order-empty {
	text-align: center;
	color: #8295ad;
	padding: 46px 0;
}

.order-empty i {
	display: block;
	font-size: 34px;
	margin-bottom: 10px;
	color: #c5d2e2;
}

.order-empty span {
	font-size: 14px;
}

.order-card {
	background: #fff;
	border-radius: 18px;
	box-shadow: 0 8px 22px -16px rgba(11, 31, 58, .25);
	border: 1px solid rgba(11, 31, 58, .05);
	margin-bottom: 12px;
	overflow: hidden;
}

.order-card-body {
	display: block;
	padding: 13px 14px 11px;
}

.order-top {
	display: flex;
	align-items: center;
	gap: 12px;
}

.order-headings {
	flex: 1;
	min-width: 0;
}

.order-client {
	font-size: 15.5px;
	font-weight: 700;
	color: #0B1F3A;
	margin: 0;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.order-product {
	display: inline-block;
	margin-top: 4px;
	font-size: 12px;
	font-weight: 600;
	color: #1D4ED8;
	background: #E8F1FF;
	padding: 3px 10px;
	border-radius: 8px;
}

.order-qty {
	flex: 0 0 auto;
	min-width: 40px;
	text-align: center;
	background: #E8F1FF;
	color: #1D4ED8;
	font-size: 17px;
	font-weight: 700;
	border-radius: 11px;
	padding: 6px 12px;
}

.order-meta {
	margin-top: 10px;
}

.order-meta-row {
	display: flex;
	align-items: flex-start;
	gap: 9px;
	font-size: 13.5px;
	line-height: 1.4;
	color: #46566c;
	margin-top: 7px;
}

.order-meta-row i {
	color: #2563EB;
	margin-top: 2px;
	flex: 0 0 16px;
	text-align: center;
	font-size: 13px;
}

.order-actions {
	display: flex;
	gap: 10px;
	padding: 0 15px 15px;
}

.oa-btn {
	flex: 1;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	border: 0;
	border-radius: 13px;
	padding: 11px 0;
	font-size: 14px;
	font-weight: 600;
}

.oa-navigate {
	background: #E8F1FF;
	color: #1D4ED8;
}

.oa-addloc {
	background: linear-gradient(135deg, #F59E0B, #F97316);
	color: #fff;
}

.oa-call {
	background: linear-gradient(135deg, #16B981, #0EA5A4);
	color: #fff;
}

.oa-btn:active {
	transform: scale(.97);
}
</style>
