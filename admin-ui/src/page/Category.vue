<template>
  <div class="hello">
    <p style="text-align:right">
      <el-button type="primary" @click="addCategoryDialog=true" size="small">新增category</el-button>
    </p>

    <el-table :data="tableData" style="width: 100%">
      <el-table-column prop="id" label="ID"></el-table-column>
      <el-table-column prop="name" label="名称"></el-table-column>
      <el-table-column prop="time" label="添加时间" :formatter="dateFormatter"></el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="toEditCategory(scope.row)">编辑</el-button>
          <el-button type="text" size="small" @click="toDelCategory(scope.row)">删除</el-button>
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

    <!-- 添加category -->
    <el-dialog title="添加short" :visible.sync="addCategoryDialog" width="500px" @close="closeDialog('add')">
      <el-form :model="addCategoryForm" label-width="100px" size="mini" :rules="validAddCategoryForm" ref="validAddCategoryForm">
        <el-form-item label="快捷键名称:" prop="name">
          <el-input v-model="addCategoryForm.name" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addCategory">添加</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
    <!-- 编辑category -->
    <el-dialog title="编辑short" :visible.sync="editCategoryDialog" width="500px" @close="closeDialog('edit')">
      <el-form :model="editCategoryForm" label-width="100px" size="mini" :rules="validEditCategoryForm" ref="validEditCategoryForm">
        <el-form-item label="快捷键名称:" prop="name">
          <el-input v-model="editCategoryForm.name" style="width:200px;"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button @click="editCategoryDialog = false">取消</el-button>
          <el-button type="primary" @click="editCategory">保存</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import requests from '@/page/requests'
export default {
  extends: requests,
  name: 'Category',
  data () {
    return {
      currentPage: 1,
      pageSize: 10,
      totalNum: 0,
      tableData: [],
      addCategoryDialog: false,
      addCategoryForm: {
        name: ''
      },
      editCategoryDialog: false,
      editCategoryForm: {
        id: '',
        name: ''
      },
      validAddCategoryForm: {
        name: [
          { required: true, message: '名称不能为空', trigger: 'change' }
        ]
      },
      validEditCategoryForm: {
        name: [
          { required: true, message: '名称不能为空', trigger: 'change' }
        ]
      }
    }
  },
  mounted () {
    this.getList()
  },
  methods: {
    toDelCategory (item) {
      this.$confirm('此操作将永久删除该条记录，是否继续?','提示',{
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        let params = {
          id: item.id
        }
        this.requests.delCategory(params).then((res) => {
          if (res.status) {
            this.$message({
              message: '删除成功',
              type: 'success'
            })
            this.getList()
          } else {
            this.$message.error(res.msg)
          }
        })
      }).catch(() => {

      })
    },
    toEditCategory (item) {
      this.editCategoryForm = {
        id: item.id,
        name: item.name
      }
      this.editCategoryDialog = true
    },
    editCategory () {
      this.$refs['validEditCategoryForm'].validate((valid) => {
        if (valid) {
          let params = {
            id: this.editCategoryForm.id,
            name: this.editCategoryForm.name
          }
          this.requests.editCategory(params).then((res) => {
            if (res.status) {
              this.$message({
                message: '编辑成功',
                type: 'success'
              })
              this.editCategoryDialog = false
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
        pageNo: this.currentPage
      }
      this.requests.getCategory(params).then((res) => {
        this.tableData = res.data
        this.totalNum = res.total
      })
    },
  	addCategory () {
      this.$refs['validAddCategoryForm'].validate((valid) => {
        if (valid) {
          this.requests.addCategory(this.addCategoryForm).then((res) => {
            if (res.status) {
              this.$message({
                message: '添加成功',
                type: 'success'
              })
              this.addCategoryDialog = false
              this.getList()
            } else {
              this.$message.error(res.message)
            }
          })
        }
      })
  	},
    closeDialog (type) {
      if (type == 'add') {
        this.$refs['validAddCategoryForm'].clearValidate()
        this.addCategoryForm = {
          name: ''
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
    },
    // 日期格式化
    dateFormatter (row,column,cellValue) {
      let time = cellValue * 1000
      let date = new Date(time)
      return date.getFullYear() + '-' + this.utils().toDouble((date.getMonth()+1)) + '-' + this.utils().toDouble(date.getDate()) + ' ' + this.utils().toDouble(date.getHours()) + ':' + this.utils().toDouble(date.getMinutes()) + ':' + this.utils().toDouble(date.getSeconds())
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
