<template>
	<app-loader />
	<app-header />

	<slot />

	<app-footer />
	<app-sidebar />

	<app-area-filter-modal />
</template>

<script>
import AppHeader from "@/components/AppHeader";
import AppLoader from "@/components/AppLoader";
import AppFooter from "@/components/AppFooter";
import AppSidebar from "@/components/AppSidebar";
import AppAreaFilterModal from "@/components/AppAreaFilterModal";


export default {
	name: "AppLayout",
	components: {AppAreaFilterModal, AppSidebar, AppFooter, AppLoader, AppHeader}
}
</script>

<style scoped>

</style>