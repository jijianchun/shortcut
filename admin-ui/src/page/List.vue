<template>
  <div class="hello">
    <el-form ref="form" label-width="100px" size="mini" style="width:400px;">
    	<el-form-item label="快捷键分类:">
    		<el-select v-model="form.category_id" placeholder="请选择快捷键分类" style="width:200px;">
    			<el-option v-for="item in categorys" :key="item.id" :label="item.name" :value="item.id"></el-option>
    		</el-select>
    	</el-form-item>
    	<el-form-item>
    		<el-button type="primary" @click="search">查询</el-button>
    	</el-form-item>
    </el-form>
    <el-table :data="tableData" style="width: 100%">
      <el-table-column prop="id" label="ID"></el-table-column>
      <el-table-column prop="name" label="名称"></el-table-column>
      <el-table-column prop="description" label="功能介绍"></el-table-column>
      <el-table-column prop="time" label="添加时间"></el-table-column>
    </el-table>
  </div>
</template>

<script>
import requests from '@/page/requests'
export default {
  extends: requests,
  name: 'List',
  data () {
    return {
      tableData: [],
      categorys: [],
      form: {
        category_id: ''
      }
    }
  },
  mounted () {
    this.getCategory()
  },
  methods: {
    getCategory () {
      this.requests.getCategory({m:'cate_query'}).then((res) => {
        this.categorys = res.data
      })
    },
  	search () {
      this.requests.getShorts({m:'query',category_id:this.form.category_id}).then((res) => {
        this.tableData = res.data
      })
  	}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.hello {
		
	}
</style>
