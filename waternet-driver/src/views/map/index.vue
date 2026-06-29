<template>
	<app-layout>
		<div class="map-wrap">
			<div ref="mapRef" id="clients-map"></div>
			<button type="button" class="map-recenter" @click="recenter">
				<i class="fa-solid fa-location-crosshairs"></i>
			</button>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/components/AppLayout";
import {GoogleMap} from "@capacitor/google-maps";
import {Geolocation} from "@capacitor/geolocation";
import {App as CapacitorApp} from '@capacitor/app';

// Google Maps key (Android Maps SDK must be enabled for this key).
const GOOGLE_MAPS_KEY = 'AIzaSyCWdCZwISLuqFF-IBrtdeWCHyAkL-qJH4k'

export default {
	name: "ClientsMap",
	components: {AppLayout},

	data() {
		return {
			map: null
		}
	},

	async mounted() {
		// the native map renders behind the WebView — make the page see-through
		document.documentElement.classList.add('native-map-open')
		document.body.classList.add('native-map-open')

		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', () => {
				this.$router.push({name: 'order'})
			})
		})

		await this.initMap()
	},

	async beforeUnmount() {
		document.documentElement.classList.remove('native-map-open')
		document.body.classList.remove('native-map-open')
		if (this.map) {
			try {
				await this.map.destroy()
			} catch (e) {
			}
			this.map = null
		}
	},

	methods: {
		async initMap() {
			let center = {lat: 39.767, lng: 64.421}   // Buxoro fallback

			// Make sure location permission is granted BEFORE the map turns on its
			// current-location layer — enabling it without permission crashes the
			// native map (the exception bypasses JS try/catch).
			let hasLocation = false
			try {
				let perm = await Geolocation.checkPermissions()
				if (perm.location !== 'granted' && perm.coarseLocation !== 'granted') {
					perm = await Geolocation.requestPermissions()
				}
				hasLocation = (perm.location === 'granted' || perm.coarseLocation === 'granted')
			} catch (e) {
			}

			if (hasLocation) {
				try {
					const pos = await Geolocation.getCurrentPosition({enableHighAccuracy: true})
					center = {lat: pos.coords.latitude, lng: pos.coords.longitude}
				} catch (e) {
				}
			}

			try {
				this.map = await GoogleMap.create({
					id: 'clients-map',
					element: this.$refs.mapRef,
					apiKey: GOOGLE_MAPS_KEY,
					config: {
						center,
						zoom: 13
					}
				})

				// native realtime "you are here" blue dot — only when allowed
				if (hasLocation) {
					try {
						await this.map.enableCurrentLocation(true)
					} catch (e) {
					}
				}

				await this.loadClients()
			} catch (e) {
				console.error('GoogleMap create failed', e)
			}
		},

		async loadClients() {
			try {
				const res = await $axios.get('/api/driver/clients-map')
				const markers = (res.data || []).map(c => ({
					coordinate: {lat: c.lat, lng: c.lng},
					title: c.fullname,
					snippet: (c.phone ? ('+998' + c.phone + ' · ') : '') +
						'Balans: ' + (c.balance || 0) + ' · Idish: ' + (c.container || 0)
				}))

				if (markers.length && this.map) {
					await this.map.addMarkers(markers)
					try {
						await this.map.enableClustering()
					} catch (e) {
					}
				}
			} catch (e) {
			}
		},

		async recenter() {
			if (!this.map) return
			try {
				const pos = await Geolocation.getCurrentPosition({enableHighAccuracy: true})
				await this.map.setCamera({
					coordinate: {lat: pos.coords.latitude, lng: pos.coords.longitude},
					zoom: 15,
					animate: true
				})
			} catch (e) {
			}
		}
	}
}
</script>

<style scoped>
.map-wrap {
	position: fixed;
	top: 62px;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 1;
	background: transparent;
}

#clients-map {
	display: block;
	width: 100%;
	height: 100%;
	background: transparent;
}

.map-recenter {
	position: absolute;
	right: 16px;
	bottom: 100px;
	width: 46px;
	height: 46px;
	border: 0;
	border-radius: 14px;
	background: #fff;
	box-shadow: 0 8px 20px -8px rgba(11, 31, 58, .45);
	display: flex;
	align-items: center;
	justify-content: center;
	color: #2563EB;
	font-size: 18px;
	z-index: 50;
}
</style>
