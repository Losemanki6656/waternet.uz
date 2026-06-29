<template>
	<app-layout>
		<div class="map-wrap">
			<div id="clients-map"></div>
			<button type="button" class="map-recenter" @click="recenter">
				<i class="fa-solid fa-location-crosshairs"></i>
			</button>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/components/AppLayout";
import {Geolocation} from "@capacitor/geolocation";
import {App as CapacitorApp} from '@capacitor/app';

// Yandex Maps JS API key — read from waternet-driver/.env (YANDEX_MAPS_KEY).
const YANDEX_KEY = import.meta.env.YANDEX_MAPS_KEY || ''

let ymapsPromise = null

function loadYmaps() {
	if (window.ymaps && window.ymaps.Map) return Promise.resolve(window.ymaps)
	if (ymapsPromise) return ymapsPromise

	ymapsPromise = new Promise((resolve, reject) => {
		const s = document.createElement('script')
		s.src = `https://api-maps.yandex.ru/2.1/?apikey=${YANDEX_KEY}&lang=ru_RU`
		s.onload = () => window.ymaps.ready(() => resolve(window.ymaps))
		s.onerror = reject
		document.head.appendChild(s)
	})

	return ymapsPromise
}

export default {
	name: "ClientsMap",
	components: {AppLayout},

	data() {
		return {
			map: null,
			driverMark: null,
			watchId: null
		}
	},

	async mounted() {
		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', () => {
				this.$router.push({name: 'order'})
			})
		})

		try {
			const ymaps = await loadYmaps()
			this.initMap(ymaps)
		} catch (e) {
			console.error('Yandex Maps failed to load', e)
		}
	},

	beforeUnmount() {
		if (this.watchId != null) {
			Geolocation.clearWatch({id: this.watchId}).catch(() => {
			})
			this.watchId = null
		}
	},

	methods: {
		initMap(ymaps) {
			this.map = new ymaps.Map('clients-map', {
				center: [39.767, 64.421],   // Buxoro fallback; recenters on the driver
				zoom: 12,
				controls: ['zoomControl']
			})

			this.loadClients(ymaps)
			this.trackDriver(ymaps)
		},

		loadClients(ymaps) {
			$axios.get('/api/driver/clients-map').then(res => {
				const clusterer = new ymaps.Clusterer({
					preset: 'islands#invertedOrangeClusterIcons',
					groupByCoordinates: false
				})

				const marks = (res.data || []).map(c => new ymaps.Placemark(
					[c.lat, c.lng],
					{
						balloonContentHeader: c.fullname,
						balloonContentBody:
							(c.phone ? ('☎ +998' + c.phone + '<br>') : '') +
							'Balans: ' + (c.balance || 0) + '<br>Idish: ' + (c.container || 0),
						hintContent: c.fullname
					},
					{preset: 'islands#orangeIcon'}
				))

				clusterer.add(marks)
				this.map.geoObjects.add(clusterer)
			}).catch(() => {
			})
		},

		trackDriver(ymaps) {
			const update = (coords) => {
				const pos = [coords.latitude, coords.longitude]
				if (this.driverMark) {
					this.driverMark.geometry.setCoordinates(pos)
				} else {
					this.driverMark = new ymaps.Placemark(pos, {hintContent: 'Siz'}, {
						preset: 'islands#geolocationIcon',
						iconColor: '#16B981'
					})
					this.map.geoObjects.add(this.driverMark)
					this.map.setCenter(pos, 14)
				}
			}

			Geolocation.getCurrentPosition({enableHighAccuracy: true})
				.then(p => update(p.coords))
				.catch(() => {
				})

			Geolocation.watchPosition({enableHighAccuracy: true, timeout: 10000}, (p, err) => {
				if (err || !p) return
				update(p.coords)
			}).then(id => {
				this.watchId = id
			}).catch(() => {
			})
		},

		recenter() {
			if (this.driverMark && this.map) {
				this.map.setCenter(this.driverMark.geometry.getCoordinates(), 15, {duration: 300})
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
}

#clients-map {
	width: 100%;
	height: 100%;
	touch-action: none;
}

/* let the Yandex map own all touch gestures (drag / pinch-zoom) */
#clients-map :deep(.ymaps-2-1-79-events-pane),
#clients-map :deep([class*="-events-pane"]) {
	touch-action: none !important;
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
