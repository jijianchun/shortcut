<template>
  <div class="hello">
    <el-form ref="form" label-width="100px" size="small" :inline="true">
      <el-form-item label="快捷键分类:">
        <el-select v-model="searchForm.category_id" placeholder="请选择快捷键分类" style="width:200px;">
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
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="toEditShort(scope.row)">编辑</el-button>
          <el-button type="text" size="small" @click="toDelShort(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-pagination
      class="pager"
      @size-change="pageSizeChange"
      @current-change="currentPageChange"
      :current-page="currentPage"
      :page-sizes="[10, 25, 50]"
      :page-size="pageSize"
      layout="total, sizes, prev, pager, next, jumper"
      :total="totalNum">
    </el-pagination>

    <!-- 添加short -->
    <el-dialog title="添加short" :visible.sync="addShortDialog" width="500px" @close="closeDialog('add')">
      <el-form :model="addShortForm" label-width="100px" size="mini" :rules="validAddShortForm" ref="validAddShortForm">
        <el-form-item label="快捷键分类:" prop="category_id">
          <el-select v-model="addShortForm.category_id" placeholder="请选择快捷键分类" style="width:200px;">
            <el-option v-for="item in categorys" :key="item.id" :label="item.name" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="快捷键名称:" prop="name">
          <el-input v-model="addShortForm.name" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item label="快捷键描述:" prop="description">
          <el-input type=textarea v-model="addShortForm.description" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addShort">添加</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
    <!-- 编辑short -->
    <el-dialog title="编辑short" :visible.sync="editShortDialog" width="500px" @close="closeDialog('edit')">
      <el-form :model="editShortForm" label-width="100px" size="mini" :rules="validEditShortForm" ref="validEditShortForm">
        <el-form-item label="快捷键分类:" prop="category_id">
          <el-select v-model="editShortForm.category_id" placeholder="请选择快捷键分类" style="width:200px;">
            <el-option v-for="item in categorys" :key="item.id" :label="item.name" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="快捷键名称:" prop="name">
          <el-input v-model="editShortForm.name" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item label="快捷键描述:" prop="description">
          <el-input type=textarea v-model="editShortForm.description" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button @click="editShortDialog = false">取消</el-button>
          <el-button type="primary" @click="editShort">保存</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import requests from '@/page/requests'
export default {
  extends: requests,
  name: 'Short',
  data () {
    return {
      currentPage: 1,
      pageSize: 10,
      totalNum: 0,
      tableData: [],
      addShortDialog: false,
      categorys: [],
      searchForm: {
        category_id: ''
      },
      addShortForm: {
        category_id: '',
        name: '',
        description: ''
      },
      editShortDialog: false,
      editShortForm: {
        category_id: '',
        name: '',
        description: ''
      },
      validAddShortForm: {
        category_id: [
          { required: true, message: '分类不能为空', trigger: 'change' }
        ],
        name: [
          { required: true, message: '名称不能为空', trigger: 'change' }
        ],
        description: [
          { required: true, message: '描述不能为空', trigger: 'change' }
        ]
      },
      validEditShortForm: {
        category_id: [
          { required: true, message: '分类不能为空', trigger: 'change' }
        ],
        name: [
          { required: true, message: '名称不能为空', trigger: 'change' }
        ],
        description: [
          { required: true, message: '描述不能为空', trigger: 'change' }
        ]
      }
    }
  },
  mounted () {
    this.getCategory()
  },
  methods: {
    toDelShort (item) {
      this.$confirm('此操作将永久删除该条记录，是否继续?','提示',{
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        let params = {
          m: 'del',
          id: item.id
        }
        this.requests.delShort(params).then((res) => {
          if (res.status) {
            this.$message({
              message: '删除成功',
              type: 'success'
            })
            this.getList()
          } else {
            this.$message.error(res.message)
          }
        })
      }).catch(() => {
        
      })
    },
    toEditShort (item) {
      this.editShortForm = {
        category_id: item.category_id,
        name: item.name,
        description: item.description
      }
      this.editShortDialog = true
    },
    editShort () {
      this.$refs['validEditShortForm'].validate((valid) => {
        if (valid) {
          let params = {
            m: 'modify',
            category_id: this.editShortForm.category_id,
            name: this.editShortForm.name,
            description: this.editShortForm.description
          }
          this.requests.getCategory(params).then((res) => {
            if (res.status) {
              this.$message({
                message: '编辑成功',
                type: 'success'
              })
              this.editShortDialog = false
              this.getList()
            } else {
              this.$message.error(res.message)
            }
          })
        }
      })
    },
    getList () {
      let params = {
        pageSize: this.pageSize,
        pageNo: this.currentPage - 1,
        m: 'query',
        category_id: this.searchForm.category_id
      }
      this.requests.getShorts(params).then((res) => {
        this.tableData = res.data
        this.totalNum = res.total
      })
    },
    getCategory () {
      this.requests.getCategory({m:'cate_query'}).then((res) => {
        this.categorys = res.data
      })
    },
  	addShort () {
      this.$refs['validAddShortForm'].validate((valid) => {
        if (valid) {
          this.requests.addShort(Object.assign({m:'add'},this.addShortForm)).then((res) => {
            if (res.status) {
              this.$message({
                message: '添加成功',
                type: 'success'
              })
              this.addShortDialog = false
              this.getList()
            } else {
              this.$message.error(res.message)
            }
          })
        }
      })
  		
  	},
    search () {
      this.getList()
    },
    closeDialog (type) {
      if (type == 'add') {
        this.$refs['validAddShortForm'].clearValidate()
        this.addShortForm = {
          category_id: '',
          name: '',
          description: ''
        }
      }
    },
    /* @description 监听每页展示条数改变*/
    pageSizeChange (pagesize) {
      this.pageSize = pagesize
      this.getList()
    },
    /**
     * @description 监听当前页码改变
     */
    currentPageChange (currentpage) {
      this.currentPage = currentpage
      this.getList()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.hello { padding:0 10px; }
  .pager {
    margin-top:20px;
    text-align: right;
  }
</style>
