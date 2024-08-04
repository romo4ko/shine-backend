import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    name: 'HomePage',
    path: '/',
    meta: {
      requiresAuth: false,
    },
    component: () => import('@/views/HomePage.vue')
  },
  {
    name: 'Login',
    path: '/login',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/LoginPage.vue')
  },
  {
    name: 'Support',
    path: '/support',
    component: () => import('@/views/SupportPage.vue')
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
