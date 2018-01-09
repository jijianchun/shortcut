import Qs from 'qs'
import axios from './ajax-config'

// 添加请求拦截器
axios.interceptors.request.use(config => {
	console.log(config)
})

export default {
	ajax (url, method, params) {
		return new Promise((resolve, reject) => {
			axios({
				url: url,
				method: method,
				data: params
			})
			.then(response => {
	          resolve(response)
	        })
	        .catch(error => {
	          reject(error)
	        })
		})
	}
}