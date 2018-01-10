<template>
  <div class="hello">
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
  </div>
</template>

<script>
import requests from '@/page/requests'
export default {
  extends: requests,
  name: 'Home',
  data () {
    return {
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
  	}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.hello {
		width: 400px;
	}
</style>
