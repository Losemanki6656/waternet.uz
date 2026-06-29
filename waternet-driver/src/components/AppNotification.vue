<template>
	<div id="successNotific" class="notification-box" :class="{ show: state.success.show }">
		<div class="notification-dialog ios-style bg-success">
			<div class="notification-header">
				<div class="in">
					<img src="@/assets/img/sample/avatar/success.jpg" alt="image" class="imaged w24 rounded">
					<strong>{{ state.success.name }}</strong>
				</div>
				<div class="right">
					<span>{{ state.success.time }}</span>
					<a @click="closeSuccess" class="close-button">
						<i class="fas fa-times-circle"></i>
					</a>
				</div>
			</div>
			<div class="notification-content">
				<div class="in">
					<h3 class="subtitle">{{ state.success.title }}</h3>
					<div class="text" v-html="state.success.info"></div>
				</div>
			</div>
		</div>
	</div>

	<div id="errorNotific" class="notification-box" :class="{ show: state.error.show }">
		<div class="notification-dialog ios-style bg-danger">
			<div class="notification-header">
				<div class="in">
					<img src="@/assets/img/sample/avatar/avatar3.jpg" alt="image" class="imaged w24 rounded">
					<strong>{{ state.error.name }}</strong>
				</div>
				<div class="right">
					<span>{{ state.error.time }}</span>
					<a @click="closeError" class="close-button">
						<i class="fas fa-times-circle"></i>
					</a>
				</div>
			</div>
			<div class="notification-content">
				<div class="in">
					<h3 class="subtitle">{{ state.error.title }}</h3>
					<div class="text" v-html="state.error.info"></div>
				</div>
			</div>
		</div>
	</div>

	<div id="internet-toast" class="toast-box toast-bottom bg-danger" :class="{ show: state.internet }">
		<div class="in">
			<div class="text">
				Please check your internet connection.
			</div>
		</div>
		<button @click="closeInternet" type="button" class="btn btn-sm btn-text-light close-button">OK</button>
	</div>
</template>

<script>
import {notify, notifyState} from '@/plugins/notify'

export default {
	name: "AppNotification",

	data() {
		return {
			state: notifyState
		}
	},

	methods: {
		closeSuccess() {
			notify.closeSuccess()
		},
		closeError() {
			notify.closeError()
		},
		closeInternet() {
			notify.internet(false)
		}
	}
}
</script>

<style scoped></style>
