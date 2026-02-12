import { createRouter, createWebHistory } from 'vue-router'
import BookList from '../components/BookList.vue'

const routes = [
  {
    path: '/',
    name: 'books',
    component: BookList
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
