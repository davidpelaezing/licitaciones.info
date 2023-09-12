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
    component: () => import('./views/ProductoView.vue')
  },
  {
    path: '/producto-detalle/:id',
    component: () => import('./views/ProductoDetalleView.vue')
  },
  {
    path: '/finalizar-compra',
    component: () => import('./views/FacturaView.vue')
  },
  {
    path: '/',
    component: () => import('./views/HomeView.vue')
  },
  {
    path: '/categorias',
    component: () => import('./views/CategoriaView.vue')
  },
  {
    path: '/tags',
    component: () => import('./views/TagView.vue')
  },
  {
    path: '/usuarios',
    component: () => import('./views/UsuarioView.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router