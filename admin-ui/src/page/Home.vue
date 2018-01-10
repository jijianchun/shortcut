<template>
  <div class="hello">
    <el-form ref="form" label-width="100px" size="small" :inline="true">
      <el-form-item label="快捷键分类:">
        <el-select v-model="form.category_id" placeholder="请选择快捷键分类" style="width:200px;">
          <el-option v-for="item in categorys" :key="item.id" :label="item.name" :value="item.id"></el-option>
        </el-select>
      </el-form-item>
    </el-form>
    <p style="text-align:right">
      <el-button type="primary" @click="search" size="small">查询</el-button>
      <el-button type="primary" @click="addShortDialog=true" size="small">新增short</el-button>
    </p>

    <el-table :data="tableData" style="width: 100%">
      <el-table-column prop="id" label="ID"></el-table-column>
      <el-table-column prop="name" label="名称"></el-table-column>
      <el-table-column prop="description" label="功能介绍"></el-table-column>
      <el-table-column prop="time" label="添加时间"></el-table-column>
    </el-table>

    <el-dialog title="添加short" :visible.sync="addShortDialog" width="500px">
      <el-form ref="form" label-width="100px" size="mini">
        <el-form-item label="快捷键分类:">
          <el-select v-model="form.category_id" placeholder="请选择快捷键分类" style="width:200px;">
            <el-option v-for="item in categorys" :key="item.id" :label="item.name" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="快捷键名称:">
          <el-input v-model="form.name" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item label="快捷键描述:">
          <el-input type=textarea v-model="form.description" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addShort">添加</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import requests from '@/page/requests'
export default {
  extends: requests,
  name: 'Home',
  data () {
    return {
      tableData: [],
      addShortDialog: false,
      categorys: [],
      form: {
        category_id: '',
        name: '',
        description: ''
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
  	addShort () {
  		this.requests.addShort(Object.assign({m:'add'},this.form)).then((res) => {
        console.log(res)
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
	.hello { padding:0 10px; }
</style>
