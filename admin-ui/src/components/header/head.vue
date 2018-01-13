<template>
    <div class="header-wrapper">
      <el-menu
        :default-active="activeIndex"
        class="el-menu-demo"
        mode="horizontal"
        background-color="#415a93"
        text-color="#979797"
        :unique-opened="true"
        active-text-color="#fff"
        :router="true"
        >
        <el-menu-item index="/">首页</el-menu-item>
        <el-menu-item index="/Category">分类管理</el-menu-item>
      </el-menu>
    </div>
</template>

<script>
    export default {
      name: 'headWrap',
      data () {
        return {
          activeIndex: '/'
        }
      },
      mounted () {
      },
      methods: {
        
      }
    }
</script>

<style scoped="">
    .header-wrapper {
    	margin-bottom: 20px;
    }
</style>
