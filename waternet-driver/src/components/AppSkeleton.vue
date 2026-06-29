<template>
	<div class="sk-list">
		<div class="sk-card" v-for="n in count" :key="n">
			<!-- order / application list -->
			<template v-if="variant === 'order'">
				<div class="sk-row">
					<div class="skeleton sk-avatar"></div>
					<div class="sk-grow">
						<div class="skeleton sk-line lg w60"></div>
						<div class="skeleton sk-line w40" style="margin-top:9px"></div>
					</div>
					<div class="skeleton sk-qty"></div>
				</div>
				<div class="skeleton sk-line w90" style="margin-top:15px"></div>
				<div class="sk-btns">
					<div class="skeleton sk-btn"></div>
					<div class="skeleton sk-btn"></div>
				</div>
			</template>

			<!-- monitoring list -->
			<template v-else-if="variant === 'list'">
				<div class="sk-row">
					<div class="skeleton sk-line w30"></div>
					<div class="skeleton sk-line w40" style="margin-left:auto"></div>
				</div>
				<div class="skeleton sk-line w50" style="margin-top:14px"></div>
				<div class="skeleton sk-line w70" style="margin-top:9px"></div>
			</template>

			<!-- region rows -->
			<template v-else>
				<div class="skeleton sk-line w100" style="height:24px;border-radius:8px"></div>
			</template>
		</div>
	</div>
</template>

<script>
export default {
	name: "AppSkeleton",
	props: {
		variant: {type: String, default: 'order'},
		count: {type: Number, default: 4}
	}
}
</script>

<style scoped>
.w100 {
	width: 100%;
}
</style>
