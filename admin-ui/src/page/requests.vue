<script>
import axios from '@/common/ajax/ajax'
import utils from '@/common/lib/utils'
export default {
  data () {
    return {
      requests: {
        // 获取分类
        getCategory: (fields) => axios.ajax('Index/query_category_list', 'get', fields),
        // 添加分类
        addCategory: (...params) => axios.ajax('Index/cate_add', 'post', ...params),
        // 编辑分类
        editCategory: (...params) => axios.ajax('Index/cate_modify', 'post', ...params),
        // 删除分类
        delCategory: (...params) => axios.ajax('Index/cate_del', 'get', ...params),
        // 获取某个分类下的列表
        getShorts: (...params) => axios.ajax('Index/query', 'get', ...params),
        // 添加内容
        addShort: (...params) => axios.ajax('Index/add', 'post', ...params),
        // 修改内容
        editShort: (...params) => axios.ajax('Index/modify', 'post', ...params),
        // 删除内容
        delShort: (...params) => axios.ajax('Index/del', 'get', ...params)
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
