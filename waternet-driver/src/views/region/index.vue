<template>
	<app-layout>
		<div id="appCapsule">
			<app-skeleton v-if="loading && !regions.length" variant="rows" :count="6" />

			<div v-else class="region-wrap">
				<div class="filter-head">
					<span class="filter-title">{{ $t('region.assigned') }}</span>
				</div>

				<div class="region-empty" v-if="!regions.length">
					<i class="fa-solid fa-map-location-dot"></i>
					<span>{{ $t('region.empty') }}</span>
				</div>

				<div v-else class="region-acc">
					<div class="region-item" v-for="region in regions" :key="region.id">
						<button class="region-btn collapsed" type="button" data-bs-toggle="collapse"
							:data-bs-target="'#accordion' + region.id">
							<span class="region-ico"><i class="fa-solid fa-map-location-dot"></i></span>
							<span class="region-name">{{ region.name }}</span>
							<span class="region-count">{{ region.areas.length }}</span>
							<i class="fa-solid fa-chevron-down region-chev"></i>
						</button>

						<div :id="'accordion' + region.id" class="collapse">
							<div class="area-list">
								<div class="area-chip-ro" v-for="area in region.areas" :key="area.id">
									<i class="fa-solid fa-location-dot"></i>
									<span>{{ area.name }}</span>
								</div>
							</div>
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
import { App as CapacitorApp } from '@capacitor/app';

export default {
	name: "Index",
	components: { AppLayout, AppSkeleton },

	data() {
		return {
			loading: true
		}
	},

	computed: {
		regions: function () {
			return this.$store.state.regions
		}
	},

	beforeMount() {
		this.getRegions()

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({ canGoBack }) => {
				this.$router.push({ name: 'order' })
			})
		})
	},

	methods: {
		getRegions() {
			$axios.get('/api/driver/regions').then(response => {
				this.$store.state.regions = response.data
			}).finally(() => {
				this.loading = false
			})
		}
	}
}
</script>

<style scoped>
.region-wrap {
	padding: 12px 14px 0;
}

.region-empty {
	text-align: center;
	color: #8295ad;
	padding: 50px 0;
}

.region-empty i {
	display: block;
	font-size: 38px;
	margin-bottom: 12px;
	color: #c5d2e2;
}

.region-empty span {
	font-size: 14px;
}

.area-chip-ro {
	display: inline-flex;
	align-items: center;
	gap: 7px;
	background: #E8F1FF;
	color: #1D4ED8;
	font-size: 13px;
	font-weight: 500;
	padding: 8px 13px;
	border-radius: 11px;
	margin: 0 8px 8px 0;
}

.area-chip-ro i {
	font-size: 12px;
}

.area-list {
	padding: 6px 12px 12px;
}
</style>
