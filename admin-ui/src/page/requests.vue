<script>
import axios from '@/common/ajax/ajax'
export default {
  data () {
    return {
      requests: {
      	// 获取分类
        getCategory: (fields) => axios.ajax('/short.php', 'get', fields),
        // 获取某个分类下的列表
        getShorts: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 添加内容
        addShort: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 修改内容
        editShort: (...params) => axios.ajax('/short.php', 'post', ...params)
      }
    }
  }
}
</script>
