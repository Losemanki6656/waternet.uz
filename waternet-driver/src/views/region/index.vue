<template>
	<app-layout>
		<div id="appCapsule">
			<div class="region-wrap">
				<div class="filter-head">
					<span class="filter-title">{{ $t('region.title') }}</span>
					<button type="button" class="select-all-pill" :class="{ on: selectAllCheck }" @click="selectAll">
						<i class="fa-solid" :class="selectAllCheck ? 'fa-circle-check' : 'fa-list-check'"></i>
						{{ $t('region.selectAll') }}
					</button>
				</div>

				<app-skeleton v-if="loading && !regions.length" variant="rows" :count="7" />

				<div v-else class="region-acc" id="accordion01">

					<div class="region-item" v-for="region in regions" :key="region.id">
						<button class="region-btn collapsed" type="button" data-bs-toggle="collapse"
							:data-bs-target="'#accordion' + region.id">
							<span class="region-ico"><i class="fa-solid fa-map-location-dot"></i></span>
							<span class="region-name">{{ region.name }}</span>
							<span class="region-count">{{ regionSelected(region) }}/{{ region.areas.length }}</span>
							<i class="fa-solid fa-chevron-down region-chev"></i>
						</button>

						<div :id="'accordion' + region.id" class="collapse" data-bs-parent="#accordion01">
							<div class="area-list">
								<div class="check-row" v-for="area in region.areas" :key="area.id"
									:class="{ on: isAreaChecked(area) }" @click="selectArea(area.id)">
									<span class="check-name">{{ area.name }}</span>
									<span class="check-box"><i class="fa-solid fa-check"></i></span>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="filter-submit">
					<button class="btn" @click="submit">{{ $t('region.submit') }}</button>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/components/AppLayout";
import AppSkeleton from "@/components/AppSkeleton";
import _ from "lodash"
import { App as CapacitorApp } from '@capacitor/app';

export default {
	name: "Index",
	components: { AppLayout, AppSkeleton },

	data() {
		return {
			loading: true,
			selected: [],
			selectAllCheck: true
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
		selectAll() {
			this.selectAllCheck = !this.selectAllCheck
			this.selected = []
			this.$store.state.regions.map(region => {
				region.areas.map(area => {
					area.check = this.selectAllCheck
					if (area.check) this.selected.push(area.id)
				})
			})
		},

		getRegions() {
			$axios.get('/api/driver/regions').then(response => {
				this.$store.state.regions = response.data
			}).then(() => {
				this.loadSelected()
			}).finally(() => {
				this.loading = false
			})
		},

		loadSelected() {
			this.$store.state.regions.map(region => {
				region.areas.map(area => {
					if (area.check) {
						this.selected.push(area.id)
					}
				})
			})
		},

		selectArea(id) {
			if (this.selected.includes(id)) {
				this.selected = _.without(this.selected, id)
			} else {
				this.selected.push(id)
			}
		},

		isAreaChecked(area) {
			return this.selected.includes(area.id)
		},

		regionSelected(region) {
			return region.areas.filter(a => this.selected.includes(a.id)).length
		},

		submit() {
			$axios.post('/api/driver/areas/filter', {
				areas: this.selected
			}).then(response => {

				$notify.success({
					name: this.$t('toast.filterSuccess'),
					title: this.$t('toast.success'),
					info: this.$t('toast.filterSuccessText')
				})

				this.$router.push({ name: 'order' })
			})
		}
	}
}
</script>

<style scoped>
.region-wrap {
	padding: 12px 14px 0;
}
</style>