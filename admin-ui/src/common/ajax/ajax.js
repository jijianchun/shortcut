import Qs from 'qs'
import axios from './ajax-config'

// 添加请求拦截器
axios.interceptors.request.use(config => {
	if (config.method === 'get' || config.method === 'delete' || config.method === 'post') {
      config.params = config.data
    }
    console.log(config)
    return config
}, error => {
  // 对请求错误做些什么
  alert(error)
  return Promise.reject(error)
})

function checkStatus (res) {
  if (res && (res.status === 200 || res.status === 304 || res.status === 400)) {
    var hasResult = res.hasOwnProperty('result')
    var returnVal = hasResult === true ? res.result : res
    return returnVal
  } 
  return res
}

export default {
	ajax (url, method, params) {
		return new Promise((resolve, reject) => {
			axios({
				url: url,
				method: method,
				data: params
			})
			.then(response => {
				let res = checkStatus(response.data)
	        	resolve(res)
	        })
	        .catch(error => {
	        	reject(error)
	        })
		})
	}
}