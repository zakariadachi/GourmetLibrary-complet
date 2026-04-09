import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import BooksView from '../views/BooksView.vue'
import CategoryList from '../views/CategoryList.vue'
import BookDetail from '../views/BookDetail.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/books',
      name: 'books.index',
      component: BooksView
    },
    {
      path: '/categories/:categoryId/books',
      name: 'category.books',
      component: CategoryList
    },
    {
      path: '/categories/:categoryId/books/:bookId',
      name: 'book.show',
      component: BookDetail
    }
  ]
})

export default router
