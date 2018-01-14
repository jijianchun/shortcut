<script>
import axios from '@/common/ajax/ajax'
import utils from '@/common/lib/utils'
export default {
  data () {
    return {
      requests: {
        // 添加分类
        addCategory: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 编辑分类
        editCategory: (...params) => axios.ajax('/short.php', 'post', ...params),
      	// 获取分类
        getCategory: (fields) => axios.ajax('/short.php', 'get', fields),
        // 删除分类
        delCategory: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 获取某个分类下的列表
        getShorts: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 添加内容
        addShort: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 修改内容
        editShort: (...params) => axios.ajax('/short.php', 'post', ...params),
        // 删除内容
        delShort: (...params) => axios.ajax('/short.php', 'post', ...params)
      }
    }
  },
  methods: {
    utils() {
      return utils
    }
  }
}
</script>
