export const global = {
	AJAX_BASE_URL: 'http://project.jameschun.cc/short.php'
}

export default {
	install (Vue, options) {
		Object.assign(Vue.prototype, global)
	}
}