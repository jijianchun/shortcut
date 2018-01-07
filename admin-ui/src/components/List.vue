<template>
  <div class="hello">
    <el-form ref="form" label-width="100px" size="mini">
    	<el-form-item label="快捷键分类:">
    		<el-select v-model="form.category_id" placeholder="请选择快捷键分类" style="width:200px;">
    			<el-option label="sublime" value="1"></el-option>
    			<el-option label="webstorm" value="2"></el-option>
    		</el-select>
    	</el-form-item>
    	<el-form-item>
    		<el-button type="primary" @click="search">查询</el-button>
    	</el-form-item>
    </el-form>
  </div>
</template>

<script>
import qs from 'qs'
export default {
  name: 'List',
  data () {
    return {
      form: {
        category_id: ''
      }
    }
  },
  methods: {
  	search () {
  		this.$http.post('http://192.168.231.132/mysql/short.php?m=query',qs.stringify(this.form)).then((res) => {
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
