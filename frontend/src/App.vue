<script setup>
import navbar from "./components/navbar.vue";
import pageFooter from "./components/footer.vue";
</script>

<template>
  <div class="container map">
    <navbar   />
    <div class="">
      <router-view></router-view>
    </div>
    <pageFooter />
  </div>
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
