import {createStore} from 'vuex'

export default createStore({
	state: {
		GOOGLE_API_KEY: 'AIzaSyCxitB5jQcw7weQdg9MqBRfxr6mj81wT7I',
		INTERNET: true,
		user: {
			id: 0,
			name: 'User name',
			email: ''
		},
		areas: [],

		orders: [],
		orders_data: [],
		orders_list: [],
		page: 0,

		selected: [],
		regions: [],
		applications: [],

		order_statuses: [],
		payment_types: [],

		appTitle: 'waternet'
	},

	getters: {

	},

	mutations: {
		clearStorageData(state) {
			$storage.set('user', null)
			$storage.set('access_token', null)
			$storage.set('orders', [])
			$storage.set('success_orders', [])
			$storage.set('payment_types', null)
			$storage.set('order_statuses', null)

			state.orders = []
			state.orders_data = []
			state.orders_list = []
			state.page = 0
			state.application = []
			state.regions = []
			state.areas = []
			state.payment_types = []
			state.order_statuses = []

			$axios.defaults.headers['Authorization'] = `Bearer )}`
		},

		// Payment types and order statuses are essentially static — fetch them
		// from the API only once, cache in storage, and reuse on later loads.
		getSelectData(state) {
			$storage.get('payment_types').then(cached => {
				if (cached) {
					state.payment_types = cached
				} else {
					$axios.get('/api/payment/types').then(response => {
						$storage.set('payment_types', response.data)
						state.payment_types = response.data
					})
				}
			})

			$storage.get('order_statuses').then(cached => {
				if (cached) {
					state.order_statuses = cached
				} else {
					$axios.get('/api/order/status').then(response => {
						$storage.set('order_statuses', response.data)
						state.order_statuses = response.data
					})
				}
			})
		}
	},

	actions: {

	},

	modules: {

	}
})
