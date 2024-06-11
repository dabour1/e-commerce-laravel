import { createRouter, createWebHistory } from "vue-router";
import notfound from "../components/notfound.vue";
import registration from "../components/registration.vue";
import about from "../components/about.vue";
import cart from "../components/cart.vue";

import login from "../components/login.vue";
import Home from "../components/home.vue";

import products from "../components/products.vue";

import congratulations from "../components/congratulations.vue";
import productsDetails from "../components/productsDetails.vue";

import Dashboard from "../components/dashboard.vue";

const routes = [
  {
    path: "/",
    component: Home,
  },
  {
    path: "/home",
    component: Home,
  },
  {
    path: "/login",
    component: login,
  },
  {
    path: "/cart",
    component: cart,
  },

  {
    path: "/registration",
    component: registration,
  },

  {
    path: "/about",
    component: about,
  },

  {
    path: "/congs",
    component: congratulations,
  },
  {
    path: "/products",
    component: products,
  },
  {
    path: "/products/:id",
    component: productsDetails,
  },
  {
    path: "/dashboard",
    component: Dashboard,
  },

  {
    path: "/:catchAll(.*)",
    component: notfound,
  },
];

const router = createRouter({
  routes,
  history: createWebHistory(),
});

export default router;
