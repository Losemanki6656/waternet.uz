<template>
	<div v-if="$route.name == 'order'" class="modal fade panelbox panelbox-right" id="FilterPanelRight" tabindex="-1"
		role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header filter-modal-head">
					<h5 class="modal-title">
						<i class="fa-solid fa-filter"></i> {{ $t('region.title') }}
					</h5>
					<a href="javascript:;" class="filter-close" data-bs-dismiss="modal">
						<i class="fa-solid fa-xmark"></i>
					</a>
				</div>
				<div class="modal-body">
					<div class="check-row select-all-row" :class="{ on: checkAll }" @click="selectAll">
						<span class="check-name">{{ $t('region.selectAll') }}</span>
						<span class="check-count">{{ allOrderCount }}</span>
						<span class="check-box"><i class="fa-solid fa-check"></i></span>
					</div>

					<div class="check-row" v-for="area in areas" :key="area.id" :class="{ on: area.check }"
						@click="selectArea(area.id)">
						<span class="check-name">{{ area.name }}</span>
						<span class="check-count">{{ area.count }}</span>
						<span class="check-box"><i class="fa-solid fa-check"></i></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

import _ from "lodash";

export default {
	name: "AppAreaFilterModal",

	data() {
		return {
			selected: [],
			checkAll: true
		}
	},

	computed: {
		areas: function () {
			let arr = this.$store.state.areas;
			if (arr.length) {
				for (let index = 0; index < arr.length; index++) {
					if (!arr[index].check) {
						this.checkAll = false
						break
					}
				}
			}

			return this.$store.state.areas || [];
		},

		allOrderCount: function () {
			let sum = 0;
			Array.from(this.$store.state.areas).map(o => sum += o.count)

			return sum
		}
	},

	methods: {
		selectAll() {
			let areas = this.$store.state.areas;
			let resultAreas = [];
			areas.map(area => {
				area.check = !this.checkAll
				resultAreas.push(area)
			})

			this.$store.state.areas = resultAreas
			this.checkAll = !this.checkAll

			this.getOrders()
		},

		selectArea(id) {
			let areas = this.$store.state.areas;
			let index = areas.findIndex(a => a.id === id)
			areas[index].check = !areas[index].check

			// console.log(areas);
			this.$store.state.areas = areas
			this.getOrders()
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
		},

		getNextPage() {
			if (this.$store.state.page < this.$store.state.orders_data.length) {
				this.$store.state.orders_list = Array.from(this.$store.state.orders_list).concat(this.$store.state.orders_data[this.$store.state.page])
				this.$store.state.page = this.$store.state.page + 1
			}
		},
	}
}
</script>

<style scoped>
/* Blue header so it merges with the native status bar above the modal */
.filter-modal-head {
	background: #1D4ED8;
	border: 0;
	padding: 16px;
}

.filter-modal-head .modal-title {
	font-size: 17px;
	font-weight: 700;
	color: #fff;
}

.filter-modal-head .modal-title i {
	color: #fff;
	margin-right: 7px;
}

.filter-close {
	width: 36px;
	height: 36px;
	border-radius: 11px;
	background: rgba(255, 255, 255, .18);
	color: #fff;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-size: 16px;
}

.modal-body {
	padding: 14px;
}

.select-all-row {
	margin-bottom: 12px;
	border: 1px dashed #c5d6ef;
	background: #fff;
}

.select-all-row.on {
	border-style: solid;
	border-color: transparent;
}
</style>