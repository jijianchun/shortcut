<template>
  <div id="app">
  	<v-header></v-header>
    <router-view/>
  </div>
</template>

<script>
import headWrap from '@/components/header/head'
export default {
  name: 'app',
  components: {
  	vHeader: headWrap
  }
}
</script>

<style>
#app {

}
</style>
