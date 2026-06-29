import {Capacitor, registerPlugin} from '@capacitor/core'

const BackgroundGeolocation = registerPlugin('BackgroundGeolocation')

// Buffer GPS points locally and flush them to the API in batches every
// FLUSH_MS. Points survive offline periods (kept in the queue until a POST
// succeeds), mirroring the app's offline-first order flow.
const QUEUE_KEY = 'pending_locations'
const FLUSH_MS = 30000
const MAX_BUFFER = 25

let watcherId = null
let flushTimer = null
let flushing = false
let queue = []

async function loadQueue() {
	try {
		const saved = await window.$storage.get(QUEUE_KEY)
		queue = Array.isArray(saved) ? saved : []
	} catch (e) {
		queue = []
	}
}

function persist() {
	window.$storage.set(QUEUE_KEY, queue)
}

function enqueue(location) {
	queue.push({
		lat: location.latitude,
		lng: location.longitude,
		accuracy: location.accuracy,
		speed: location.speed,
		heading: location.bearing,
		recorded_at: location.time
	})
	persist()

	if (queue.length >= MAX_BUFFER) {
		flush()
	}
}

async function flush() {
	if (flushing || !queue.length) return
	flushing = true

	const batch = queue.slice()

	try {
		await window.$axios.post('/api/driver/locations', {locations: batch})
		queue = queue.slice(batch.length)
		persist()
	} catch (e) {
		// keep the queue and retry on the next tick (offline-resilient)
	} finally {
		flushing = false
	}
}

export const tracker = {
	async start() {
		if (watcherId || !Capacitor.isNativePlatform()) return

		await loadQueue()

		try {
			watcherId = await BackgroundGeolocation.addWatcher({
				backgroundMessage: 'Lokatsiya kuzatilmoqda',
				backgroundTitle: 'Waternet Driver',
				requestPermissions: true,
				stale: false,
				distanceFilter: 30
			}, (location, error) => {
				if (error) {
					console.error('BackgroundGeolocation error', error)
					return
				}
				if (location) enqueue(location)
			})

			flushTimer = setInterval(flush, FLUSH_MS)
		} catch (e) {
			console.error('Failed to start location tracking', e)
		}
	},

	async stop() {
		if (flushTimer) {
			clearInterval(flushTimer)
			flushTimer = null
		}

		await flush()

		if (watcherId) {
			try {
				await BackgroundGeolocation.removeWatcher({id: watcherId})
			} catch (e) {
				// ignore
			}
			watcherId = null
		}
	}
}

window.$tracker = tracker
