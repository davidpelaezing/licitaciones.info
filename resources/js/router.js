import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    component: () => import('./views/LoginView.vue')
  },
  {
    path: '/registrar',
    component: () => import('./views/RegistroView.vue')
  },
  {
    path: '/productos',
    component: () => import('./views/ProductoView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/login')
      }
    }
  },
  {
    path: '/producto-detalle/:id',
    component: () => import('./views/ProductoDetalleView.vue')
  },
  {
    path: '/finalizar-compra',
    component: () => import('./views/FacturaView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/login')
      }
    }
  },
  {
    path: '/',
    component: () => import('./views/HomeView.vue')
  },
  {
    path: '/categorias',
    component: () => import('./views/CategoriaView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/login')
      }
    }
  },
  {
    path: '/tags',
    component: () => import('./views/TagView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/login')
      }
    }
  },
  {
    path: '/usuarios',
    component: () => import('./views/UsuarioView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/login')
      }
    }
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router