import router from './../router'
import axios from "axios";
import {notify} from "./notify";

let $axios = axios.create({
	baseURL: 'https://depo.waternet.uz',
	headers: {
		'Content-Type': 'application/json',
		'Accept': 'application/json',
	}
});

$storage.get('access_token').then(access_token => {
	$axios.defaults.headers['Authorization'] = `Bearer ${access_token}`
})

$axios.interceptors.response.use((response) => response, (error) => {
	if (error.response && error.response.status === 401) {
		router.push({name: 'login'}).then(r => r)
	}

	if (error.response && error.response.status >= 500 && error.response.status <= 599) {
		notify.error({
			name: 'Error Message',
			time: 'Close',
			title: 'error',
			info: error.response.data.message
		})
	}

	return Promise.reject(error)
})

$axios.interceptors.response.use((response) => response, error => {
	if (!error.response) {
		notify.internet(true)
	}

	return Promise.reject(error)
})

window.$axios = $axios;
