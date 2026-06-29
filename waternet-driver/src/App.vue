<template>
	<router-view />

	<app-notification />
</template>

<style lang="scss"></style>

<script>
import AppNotification from "@/components/AppNotification.vue";

export default {
	components: {AppNotification}
}
</script>
