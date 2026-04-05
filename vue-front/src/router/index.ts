import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserListView from '@/views/users/UserListView.vue'
import VeiculosListView from '@/views/veiculos/VeiculosListView.vue'
import UserShowView from '@/views/users/UserShowView.vue'
import VeiculoShowView from '@/views/veiculos/VeiculoShowView.vue'
import UserCreateView from '@/views/users/UserCreateView.vue'
import VeiculoCreateView from '@/views/veiculos/VeiculoCreateView.vue'
import VeiculoEditView from '@/views/veiculos/VeiculoEditView.vue'
import UserEditView from '@/views/users/UserEditView.vue'
import UserEditPassView from '@/views/users/UserEditPassView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/users',
      name: 'users',
      component: UserListView,
    },
    {
      path: '/users/:id',
      name: 'user.show',
      component: UserShowView,
      props: true
    },
    {
      path: '/users/create',
      name: 'user.create',
      component: UserCreateView,
    },
    {
      path: '/users/:id/edit',
      name: 'user.edit',
      component: UserEditView,
      props: true
    },
    {
      path: '/users/:id/edit-password',
      name: 'user.edit-password',
      component: UserEditPassView,
      props: true
    },
    {
      path: '/veiculos',
      name: 'veiculos',
      component: VeiculosListView,
    },
    {
      path: '/veiculos/:id',
      name: 'veiculo.show',
      component: VeiculoShowView,
      props: true
    },
    {
      path: '/veiculos/create',
      name: 'veiculo.create',
      component: VeiculoCreateView,
    },
    {
      path: '/veiculos/:id/edit',
      name: 'veiculo.edit',
      component: VeiculoEditView,
      props: true
    }
  ],
})

export default router
