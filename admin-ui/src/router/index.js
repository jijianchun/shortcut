import Vue from 'vue'
import Router from 'vue-router'
import Short from '@/page/Short'
import Category from '@/page/Category'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Short',
      component: Short
    },
    {
      path: '/Category',
      name: 'Category',
      component: Category
    }
  ]
})
