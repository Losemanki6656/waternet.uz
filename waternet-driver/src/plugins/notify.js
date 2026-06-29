import {reactive} from 'vue'

// Reactive notification state that drives <AppNotification/>. This replaces the
// old jQuery `$("#successNotific").addClass('show')` DOM manipulation.
export const notifyState = reactive({
	success: {show: false, name: 'Success', time: 'Close', title: 'Success', info: ''},
	error: {show: false, name: 'Error', time: 'Close', title: 'Error', info: ''},
	internet: false,
})

let successTimer = null
let errorTimer = null

export const notify = {
	success(payload = {}, duration = 3000) {
		Object.assign(notifyState.success, {show: true}, payload)
		clearTimeout(successTimer)
		if (duration) successTimer = setTimeout(() => (notifyState.success.show = false), duration)
	},

	error(payload = {}, duration = 3000) {
		Object.assign(notifyState.error, {show: true}, payload)
		clearTimeout(errorTimer)
		if (duration) errorTimer = setTimeout(() => (notifyState.error.show = false), duration)
	},

	closeSuccess() {
		notifyState.success.show = false
	},

	closeError() {
		notifyState.error.show = false
	},

	internet(show = true) {
		notifyState.internet = show
	},
}

// Keep a global for the few non-component call sites (e.g. the axios plugin).
window.$notify = notify
