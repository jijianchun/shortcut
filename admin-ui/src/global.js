export const global = {
	AJAX_BASE_URL: 'http://project.jameschun.cc'
}

export default {
	install (Vue, options) {
		Object.assign(Vue.prototype, global)
	}
}