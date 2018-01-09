<script>
import axios from '@/common/ajax/ajax'
export default {
  data () {
    return {
      requests: {
        getCategory: (fields = {}) => axios.ajax('/common/dept-device-tree', 'get', fields)
      }
    }
  }
}
</script>
