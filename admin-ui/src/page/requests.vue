<script>
import axios from '@/common/ajax/ajax'
export default {
  data () {
    return {
      requests: {
        getCategory: (fields) => axios.ajax('/short.php', 'get', fields),
        getShorts: (...params) => axios.ajax('/short.php', 'post', ...params)
      }
    }
  }
}
</script>
