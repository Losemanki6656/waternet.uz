<template>
	<div class="appBottomMenu">
		<router-link :to="{ name: 'order' }" class="item">
			<div class="col">
				<i class="fa-solid fa-box"></i>
				<strong>{{ $t('nav.orders') }}</strong>
			</div>
		</router-link>

		<router-link :to="{ name: 'region' }" class="item">
			<div class="col">
				<i class="fa-solid fa-map-location-dot"></i>
				<strong>{{ $t('nav.regions') }}</strong>
			</div>
		</router-link>

		<router-link :to="{ name: 'application' }" class="item">
			<div class="col">
				<i class="fa-solid fa-clipboard-check"></i>
				<strong>{{ $t('nav.applications') }}</strong>
			</div>
		</router-link>

		<router-link :to="{ name: 'monitoring' }" class="item">
			<div class="col">
				<i class="fa-solid fa-chart-line"></i>
				<strong>{{ $t('nav.monitoring') }}</strong>
			</div>
		</router-link>
	</div>
</template>

<script>
export default {
	name: "AppFooter"
}
</script>

<style scoped></style>
