<template>
	<div id="sidebarPanel" class="modal fade panelbox panelbox-left" role="dialog" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body p-0">
					<!-- profile box -->
					<div class="profileBox pt-2 pb-2">
						<div class="sidebar-balance">
							<div class="listview-title">{{ user?.name }}</div>
							<div class="in">
								<h1 class="amount">Waternet</h1>
							</div>
						</div>
						<a class="btn text-white btn-icon sidebar-close" style="z-index: 999" data-bs-dismiss="modal">
							<i class="fa fa-close"></i>
						</a>
					</div>
					<!-- * profile box -->
					<div class="listview-title mt-1">{{ $t('nav.language') }}</div>
					<div class="px-2 pb-1">
						<div class="lang-switch">
							<button v-for="l in locales" :key="l" type="button"
								:class="{ active: currentLocale === l }" @click="setLang(l)">
								{{ l.toUpperCase() }}
							</button>
						</div>
					</div>

					<div class="listview-title mt-1">{{ $t('nav.menu') }}</div>
					<ul class="listview flush transparent no-line image-listview">
						<li>
							<a @click="redirect('order')" class="item">
								<div class="icon-box bg-primary">
									<i class="fa-solid fa-box"></i>
								</div>
								<div class="in">
									{{ $t('nav.orders') }}
								</div>
							</a>
						</li>
						<li>
							<a @click="redirect('region')" class="item">
								<div class="icon-box bg-primary">
									<i class="fa-solid fa-map-location-dot"></i>
								</div>
								<div class="in">
									{{ $t('nav.regions') }}
								</div>
							</a>
						</li>
						<li>
							<a @click="redirect('application')" class="item">
								<div class="icon-box bg-primary">
									<i class="fa-solid fa-clipboard-check"></i>
								</div>
								<div class="in">
									{{ $t('nav.applications') }}
								</div>
							</a>
						</li>
						<li>
							<a @click="redirect('monitoring')" class="item">
								<div class="icon-box bg-primary">
									<i class="fa-solid fa-chart-line"></i>
								</div>
								<div class="in">
									{{ $t('nav.monitoring') }}
								</div>
							</a>
						</li>
						<li>
							<a @click="redirect('map')" class="item">
								<div class="icon-box bg-primary">
									<i class="fa-solid fa-map"></i>
								</div>
								<div class="in">
									{{ $t('nav.map') }}
								</div>
							</a>
						</li>


						<li>
							<a @click="logout" class="item">
								<div class="icon-box bg-danger">
									<i class="fa-solid fa-arrow-right-from-bracket"></i>
								</div>
								<div class="in">
									{{ $t('nav.logout') }}
								</div>
							</a>
						</li>
					</ul>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import {Modal} from "bootstrap";
import {SUPPORTED_LOCALES, setLocale} from "@/plugins/i18n";

export default {
	name: "AppSidebar",
	data() {
		return {
			locales: SUPPORTED_LOCALES
		}
	},
	computed: {
		user() {
			return this.$store.state.user
		},
		currentLocale() {
			return this.$i18n.locale
		}
	},
	methods: {
		setLang(locale) {
			setLocale(locale)
		},

		hideSidebar() {
			const el = document.getElementById('sidebarPanel')
			if (el) Modal.getOrCreateInstance(el).hide()
		},

		redirect(route_name) {
			this.hideSidebar()
			this.$router.push({ name: route_name })
		},

		logout() {
			if (window.$tracker) window.$tracker.stop()
			this.$store.commit('clearStorageData')
			this.hideSidebar()
			this.$router.push({ name: 'login' })
		}
	}
}
</script>

<style scoped>
.avatar {
	border: 1px #958d9e solid;
	border-radius: 50%;
	padding: 10px;
}


.profileBox {
	background: linear-gradient(135deg, #1D4ED8 0%, #2563EB 45%, #0EA5E9 100%);
	border-radius: 0 0 24px 0;
}
</style>