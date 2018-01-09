import { global } from '@/global'
import axios from 'axios'

axios.defaults.baseURL = global.AJAX_BASE_URL
axios.defaults.timeout = 10000
axios.defaults.withCredentials = true

var Ajax = axios

export default Ajax