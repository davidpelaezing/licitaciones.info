import axios from 'axios';
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    component: () => import('./views/LoginView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (!token) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/logout',
    component: () => import('./views/LoginView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        logout();
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/registrar',
    component: () => import('./views/RegistroView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (!token) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/productos',
    component: () => import('./views/ProductoView.vue'),
    beforeEnter: (to, from, next) => {
      const usuario = JSON.parse(localStorage.getItem('user'));
      const token = localStorage.getItem('token');
      if (token && usuario.admin) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/producto-detalle/:id',
    component: () => import('./views/ProductoDetalleView.vue')
  },
  {
    path: '/finalizar-compra',
    component: () => import('./views/FinalizarView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/facturas',
    component: () => import('./views/FacturaView.vue'),
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem('token');
      if (token) {
        next()
      }else{
        next('/')
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
      const usuario = JSON.parse(localStorage.getItem('user'));
      const token = localStorage.getItem('token');
      if (token && usuario.admin) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/comentarios',
    component: () => import('./views/ComentarioView.vue'),
    beforeEnter: (to, from, next) => {
      const usuario = JSON.parse(localStorage.getItem('user'));
      const token = localStorage.getItem('token');
      if (token && usuario.admin) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/tags',
    component: () => import('./views/TagView.vue'),
    beforeEnter: (to, from, next) => {
      const usuario = JSON.parse(localStorage.getItem('user'));
      const token = localStorage.getItem('token');
      if (token && usuario.admin) {
        next()
      }else{
        next('/')
      }
    }
  },
  {
    path: '/usuarios',
    component: () => import('./views/UsuarioView.vue'),
    beforeEnter: (to, from, next) => {
      const usuario = JSON.parse(localStorage.getItem('user'));
      const token = localStorage.getItem('token');
      if (token && usuario.admin) {
        next()
      }else{
        next('/')
      }
    }
  },
]

async function logout(){
  try {
    await axios.get('/logout')
    return true
  } catch (error) {
    
  }
}

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router