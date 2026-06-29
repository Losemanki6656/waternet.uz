import {createRouter, createWebHashHistory} from 'vue-router'

// Vite can only statically analyse dynamic imports one level deep, so we build a
// lazy-loader map of every view up front and look components up by path.
const pages = import.meta.glob('../views/**/*.vue')

function page(path) {
	return pages[`../views/${path}.vue`]
}

const routes = [
	{path: '/', name: 'home', component: page('index')},

	{path: '/login', name: 'login', component: page('auth/login')},

	{path: '/order', name: 'order', component: page('order/index')},
	{path: '/order/show/:id', name: 'order.show', component: page('order/show')},


	{path: '/region', name: 'region', component: page('region/index')},

	{path: '/application', name: 'application', component: page('application/index')},
	{path: '/application/show/:id', name: 'application.show', component: page('application/show')},

	{path: '/monitoring', name: 'monitoring', component: page('monitoring/index')},
]

const router = createRouter({
	history: createWebHashHistory(),
	routes: routes,
	scrollBehavior (to, from, savedPosition) {
		return { x: 0, y: 0 }
	}
})

router.beforeEach((to, from) => {

	return true
})

export default router
