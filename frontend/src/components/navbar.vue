<template>
  <nav
    class="navbar navbar-expand-lg position-sticky sticky-top top-0 z-3 bg-secondary-subtle rounded-2"
  >
    <div class="container-fluid">
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarTogglerDemo01"
        aria-controls="navbarTogglerDemo01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/" class="text-decoration-none"
              ><button
                class="nav-link"
                :class="{ active: $route.path === '/' }"
              >
                Home
              </button></router-link
            >
          </li>
          <li class="nav-item">
            <router-link to="/products" class="text-decoration-none"
              ><button
                class="nav-link"
                :class="{ active: $route.path.startsWith('/products') }"
              >
                Products
              </button></router-link
            >
          </li>

          <li class="nav-item" v-show="!isAdmin" v-if="this.isAuthenticated">
            <router-link to="/cart" class="text-decoration-none"
              ><button
                class="nav-link"
                :class="{ active: $route.path.startsWith('/cart') }"
              >
                Cart
              </button></router-link
            >
          </li>
          <li class="nav-item">
            <router-link to="/about" class="text-decoration-none"
              ><button
                class="nav-link"
                :class="{ active: $route.path.startsWith('/about') }"
              >
                About
              </button></router-link
            >
          </li>
          <li class="nav-item">
            <router-link
              v-show="isAdmin"
              v-if="isAuthenticated"
              class="text-light text-decoration-none"
              to="/dashboard"
            >
              <button
                class="nav-link text-black"
                :class="{ active: $route.path.startsWith('/dashboard') }"
              >
                <i class="fa-solid fa-screwdriver-wrench text-black"></i>
                Dashboard
              </button>
            </router-link>
          </li>
        </ul>
        <div
          v-if="isAuthenticated"
          class="avatar-container dropdown"
          data-bs-theme="dark"
        >
          <a
            class="dropdown-toggle-split text-decoration-none d-flex align-items-center"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <div class="name">{{ user.name }}</div>
            <div class="avatar">
              <img :src="user.image_url" alt="Avatar" />
            </div>
          </a>
          <ul class="dropdown-menu">
            <li>
              <router-link
                to="/"
                class="dropdown-item text-center"
                @click="logOut"
              >
                Log out &nbsp;<i class="fa-solid fa-right-from-bracket"></i>
              </router-link>
            </li>
          </ul>
        </div>
        <div v-else class="d-flex align-items-center">
          <router-link class="text-decoration-none m-2" to="registration"
            ><button class="nav-link">sign up</button></router-link
          >
          <router-link class="text-decoration-none" to="login"
            ><button class="nav-link">login</button></router-link
          >
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { datastore } from "../stors/userStore";
import FunctionsClass from "../assets/js/registerAndUpdate";
const functionsObject = new FunctionsClass();

export default {
  name: "navbar",
  async created() {
    await functionsObject.featchUserData(this);
    this.isAuthenticated =
      functionsObject.getStorgData() == null ? false : true;
  },
  data() {
    return {
      storData: datastore(),
      user: {},
      isAdmin: false,
      isAuthenticated: false,
    };
  },
  methods: {
    checkstate() {
      this.isAuthenticated =
        functionsObject.getStorgData() == null ? false : true;
    },

    logOut() {
      localStorage.clear();
      this.isAuthenticated = false;
      this.$router.push("/login");
    },
  },
  computed: {
    isAdmin() {
      const userInfo = JSON.parse(localStorage.getItem("userInfo"));
      return userInfo && userInfo.role === "admin";
    },
  },
};
</script>

<style scoped>
nav {
  background-color: var(--primary-color-1);
  box-shadow: 0px 0 31px 0px rgb(0 0 0 / 10%);
}

.navbar-brand {
  font-family: "Bungee Spice", sans-serif;
  font-weight: 400;
  font-style: normal;
  color: var(--primary-text-light) !important;
  font-size: x-large;
  letter-spacing: -3px;
  text-transform: uppercase;
}

.nav-link {
  width: max-content;
  position: relative;
  color: var(--secondary-color-1);
}

.nav-link::after {
  content: "";
  position: absolute;
  width: 90%;
  height: 2px;
  left: 5%;
  bottom: 0;
  transform: scaleX(0);
}

.nav-link:hover,
.active {
  color: var(--primary-text-light) !important;
}

.nav-link:hover::after,
.active::after {
  background-color: var(--secondary-color-1);
  transition: transform 0.5s ease-in-out;
  transform-origin: left;
  transform: scale(1);
}

.avatar-container {
  display: flex;
  align-items: center;
}

.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 2px solid var(--primary-color-3);
  margin-left: 10px;
  overflow: hidden;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.name {
  font-size: 16px;
  color: var(--secondary-color-4);
}
</style>
