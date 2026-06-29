<template>
	<app-layout>
		<div id="appCapsule">
			<app-skeleton v-if="loading" variant="list" :count="6" />

			<div v-else class="mon-list">
				<div class="mon-empty" v-if="!orders.length">
					<i class="fa-solid fa-chart-line"></i>
					<span>{{ $t('monitoring.empty') }}</span>
				</div>

				<div class="mon-card" v-for="order in orders" :key="order.id">
					<div class="mon-head">
						<span class="mon-id"><i class="fa-solid fa-circle-check"></i> #{{ order.id }}</span>
						<span class="mon-date"><i class="fa-solid fa-clock"></i> {{ formatDate(order.created_at) }}</span>
					</div>

					<h4 class="mon-client">{{ order.client.fullname }}</h4>

					<div class="mon-stats">
						<div class="mon-stat" :class="{ danger: order.client.balance < 0 }">
							<span class="l">{{ $t('monitoring.balance') }}</span>
							<span class="v">{{ formatMoney(order.client.balance) }}</span>
						</div>
						<div class="mon-stat" :class="{ warn: order.client.container > 0 }">
							<span class="l">{{ $t('monitoring.containerDebt') }}</span>
							<span class="v">{{ order.client.container }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/components/AppLayout";
import AppSkeleton from "@/components/AppSkeleton";
import {App as CapacitorApp} from '@capacitor/app';

export default {
	name: "Index",
	components: {AppLayout, AppSkeleton},

	mounted() {
		this.getOrders()

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({canGoBack}) => {
				this.$router.push({name: 'order'})
			})
		})
	},

	data() {
		return {
			loading: true,
			orders: []
		}
	},

	methods: {
		getOrders() {
			$axios.get('/api/driver/monitoring').then(response => {
				this.orders = response.data
			}).finally(() => {
				this.loading = false
			})
		}
	}
}
</script>

<style scoped>
.mon-list {
	padding: 10px 14px 0;
}

.mon-card {
	background: #fff;
	border-radius: 18px;
	box-shadow: 0 8px 22px -16px rgba(11, 31, 58, .25);
	border: 1px solid rgba(11, 31, 58, .05);
	padding: 14px;
	margin-bottom: 12px;
}

.mon-head {
	display: flex;
	align-items: center;
	justify-content: space-between;
}

.mon-id {
	font-size: 14px;
	font-weight: 700;
	color: #16B981;
}

.mon-id i {
	margin-right: 4px;
}

.mon-date {
	font-size: 12px;
	font-weight: 500;
	color: #8295ad;
}

.mon-date i {
	font-size: 11px;
	margin-right: 4px;
}

.mon-client {
	font-size: 16px;
	font-weight: 700;
	color: #0B1F3A;
	margin: 10px 0 12px;
}

.mon-stats {
	display: flex;
	gap: 10px;
}

.mon-stat {
	flex: 1;
	background: #F2F6FB;
	border-radius: 13px;
	padding: 9px 12px;
}

.mon-stat.danger {
	background: #FFF1F2;
}

.mon-stat.warn {
	background: #FFF7E8;
}

.mon-stat .l {
	display: block;
	font-size: 11px;
	color: #8295ad;
	margin-bottom: 2px;
}

.mon-stat .v {
	display: block;
	font-size: 16px;
	font-weight: 700;
	color: #0B1F3A;
}

.mon-stat.danger .v {
	color: #E11D48;
}

.mon-stat.warn .v {
	color: #D97706;
}

.mon-empty {
	text-align: center;
	color: #8295ad;
	padding: 46px 0;
}

.mon-empty i {
	display: block;
	font-size: 34px;
	margin-bottom: 10px;
	color: #c5d2e2;
}

.mon-empty span {
	font-size: 14px;
}
</style>