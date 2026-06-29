<template>
	<div class="login-page">
		<!-- Hero -->
		<div class="login-hero">
			<div class="lang-pills">
				<button v-for="l in locales" :key="l"
						:class="{ active: currentLocale === l }"
						@click="setLang(l)" type="button">{{ l.toUpperCase() }}</button>
			</div>

			<div class="brand">
				<svg class="brand-logo" viewBox="0 0 120 140" fill="none" xmlns="http://www.w3.org/2000/svg">
					<defs>
						<linearGradient id="dropGrad" x1="20" y1="10" x2="100" y2="135" gradientUnits="userSpaceOnUse">
							<stop stop-color="#EAF4FF"/>
							<stop offset="1" stop-color="#BFE0FF"/>
						</linearGradient>
					</defs>
					<!-- droplet -->
					<path d="M60 8C60 8 104 58 104 90C104 114.3 84.3 134 60 134C35.7 134 16 114.3 16 90C16 58 60 8 60 8Z"
						  fill="url(#dropGrad)" stroke="#ffffff" stroke-width="3"/>
					<!-- distribution network inside the drop -->
					<g stroke="#2563EB" stroke-width="3" stroke-linecap="round">
						<line x1="60" y1="64" x2="40" y2="92"/>
						<line x1="60" y1="64" x2="82" y2="88"/>
						<line x1="40" y1="92" x2="66" y2="108"/>
						<line x1="82" y1="88" x2="66" y2="108"/>
					</g>
					<g fill="#1D4ED8">
						<circle cx="60" cy="64" r="7"/>
						<circle cx="40" cy="92" r="6"/>
						<circle cx="82" cy="88" r="6"/>
						<circle cx="66" cy="108" r="6"/>
					</g>
				</svg>

				<h1 class="brand-name">{{ $t('appName') }}</h1>
				<p class="brand-tagline">{{ $t('login.tagline') }}</p>
			</div>
		</div>

		<!-- Form -->
		<div class="login-body">
			<div class="login-card">
				<h2 class="login-title">{{ $t('login.title') }}</h2>
				<p class="login-subtitle">{{ $t('login.subtitle') }}</p>

				<form @submit.prevent="submit" id="loginForm">
					<div class="field">
						<i class="fa fa-envelope"></i>
						<input id="email1" v-model="authData.email" :placeholder="$t('login.email')" type="text">
					</div>
					<h6 v-if="errors.email" class="text-danger field-err" v-text="errors.email"></h6>
					<h6 v-if="errors.error" class="text-danger field-err" v-text="errors.error"></h6>

					<div class="field">
						<i class="fa fa-lock"></i>
						<input id="password1" v-model="authData.password" :placeholder="$t('login.password')"
							   type="password">
					</div>
					<h6 v-if="errors.password" class="text-danger field-err" v-text="errors.password"></h6>

					<button class="btn btn-primary btn-lg w-100 mt-2" type="submit" form="loginForm" :disabled="loading">
						<span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"></span>
						{{ $t('login.submit') }}
					</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import {App as CapacitorApp} from '@capacitor/app';
import {SUPPORTED_LOCALES, setLocale} from '@/plugins/i18n';

export default {
	name: "Login",

	data() {
		return {
			locales: SUPPORTED_LOCALES,
			loading: false,
			authData: {
				email: null,
				password: null
			},
			errors: {
				email: null,
				password: null,
				error: null
			}
		}
	},

	computed: {
		currentLocale() {
			return this.$i18n.locale
		}
	},

	mounted() {
		CapacitorApp.removeAllListeners().then(() => {
			CapacitorApp.addListener('backButton', ({canGoBack}) => {
				CapacitorApp.exitApp()
			})
		})
	},

	methods: {
		setLang(locale) {
			setLocale(locale)
		},

		submit() {
			this.errorsReset()
			this.loading = true
			$axios.post('/api/auth/login', this.authData).then(response => {
				let {data} = response;

				if (data.hasOwnProperty('access_token') && data.hasOwnProperty('user')) {
					$storage.set('access_token', data.access_token)
					$storage.set('user', data.user)
					this.$store.state.user = data.user

					$storage.get('access_token').then(access_token => {
						$axios.defaults.headers['Authorization'] = `Bearer ${access_token}`
						if (window.$tracker) window.$tracker.start()
					})

					$axios.get('/api/orders').then(response => {
						$storage.set('orders', response.data)
					}).finally(() => {
						this.$router.push({name: 'order'})
					})
				}
			}).catch(error => {
				let data = error.response.data

				this.errors.email = data.hasOwnProperty('email') ? data.email[0] : null
				this.errors.password = data.hasOwnProperty('password') ? data.password[0] : null
				this.errors.error = data.hasOwnProperty('error') ? data.error : null
			}).finally(() => {
				this.loading = false
			})
		},

		errorsReset() {
			this.errors = {
				email: null,
				password: null,
				error: null
			}
		}
	}
}
</script>

<style scoped>
.login-page {
	min-height: 100vh;
	background: #f4f6fb;
}

.login-hero {
	position: relative;
	background: linear-gradient(135deg, #1D4ED8 0%, #2563EB 45%, #0EA5E9 100%);
	padding: 54px 24px 44px;
	text-align: center;
	overflow: hidden;
	border-radius: 0 0 34px 34px;
}

.login-hero:before {
	content: "";
	position: absolute;
	top: -70px;
	right: -50px;
	width: 200px;
	height: 200px;
	background: radial-gradient(circle, rgba(255, 255, 255, .22), transparent 60%);
}

.lang-pills {
	position: absolute;
	top: 16px;
	right: 16px;
	display: flex;
	gap: 6px;
	z-index: 2;
}

.lang-pills button {
	border: 0;
	background: rgba(255, 255, 255, .18);
	color: #fff;
	font-size: 12px;
	font-weight: 700;
	padding: 5px 10px;
	border-radius: 10px;
	transition: background .15s ease;
}

.lang-pills button.active {
	background: #fff;
	color: #1D4ED8;
}

.brand {
	position: relative;
	z-index: 1;
	padding-bottom: 4px;
}

.brand-logo {
	width: 96px;
	height: 112px;
	filter: drop-shadow(0 12px 20px rgba(0, 0, 0, .18));
}

.brand-name {
	color: #fff;
	font-weight: 800;
	font-size: 30px;
	letter-spacing: .5px;
	margin: 6px 0 2px;
}

.brand-tagline {
	color: rgba(255, 255, 255, .85);
	font-size: 14px;
	margin: 0;
}

.login-body {
	padding: 0 22px 34px;
}

.login-card {
	position: relative;
	z-index: 2;
	background: #fff;
	border-radius: 24px;
	padding: 26px 22px;
	box-shadow: 0 18px 40px -16px rgba(11, 31, 58, .28);
	margin-top: -30px;
}

.login-title {
	font-weight: 800;
	font-size: 23px;
	color: #0B1F3A;
	margin: 0 0 2px;
}

.login-subtitle {
	color: #7c8aa0;
	font-size: 14px;
	margin: 0 0 22px;
}

.field {
	display: flex;
	align-items: center;
	gap: 12px;
	background: #f4f6fb;
	border: 1.5px solid transparent;
	border-radius: 14px;
	padding: 0 16px;
	margin-bottom: 12px;
	transition: border-color .15s ease, background .15s ease;
}

.field:focus-within {
	border-color: #3B82F6;
	background: #fff;
}

.field i {
	color: #2563EB;
	font-size: 16px;
}

.field input {
	border: 0;
	outline: 0;
	background: transparent;
	width: 100%;
	height: 52px;
	font-size: 15px;
	color: #0B1F3A;
}

.field-err {
	margin: -6px 4px 8px;
	font-size: 12px;
}
</style>
