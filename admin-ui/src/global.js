export const global = {
	AJAX_BASE_URL: 'http://api.jameschun.cc'
}

export default {
	install (Vue, options) {
		Object.assign(Vue.prototype, global)
	}
}
