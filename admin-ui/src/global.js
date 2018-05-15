export const global = {
	AJAX_BASE_URL: 'http://127.0.0.1/shortApi/index.php/Short/'
}

export default {
	install (Vue, options) {
		Object.assign(Vue.prototype, global)
	}
}
