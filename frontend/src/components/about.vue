<template>
  <div class="funding-container">
    <h2 class="funding-title text-center">
      Helping People Find <br />
      What They Need
    </h2>
    <img
      src="/3.jpeg"
      width="80%"
      alt="about"
      class="funding-image mx-auto d-block"
    />
    <h1 class="funding-message text">
      Lorem ipsum dolor, sit amet consectetur adipisicing elit. Porro eum odit
      nostrum! Ea adipisci, natus eligendi quia laborum dolores quas suscipit
      aut modi quod autem odio sunt cum dolorum molestias. Lorem ipsum dolor
      sit, amet consectetur adipisicing elit. Cumque similique perspiciatis
      soluta rerum excepturi, sapiente, nostrum animi tempore quod expedita
      exercitationem ipsam obcaecati? Non id, similique molestias iusto hic
      molestiae. Lorem ipsum dolor sit amet consectetur adipisicing elit.
      Consectetur, harum atque. Veniam non minus mollitia, impedit quae incidunt
      tempore quis quo possimus id voluptates doloribus beatae, illo assumenda
      fugit! Amet.
    </h1>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",

  data() {
    return {};
  },
};
</script>

<style scoped>
.funding-container {
  border: 1px solid var(--primary-color-3);
  border-radius: 20px;
  box-shadow: 0px 0 31px 0px rgb(0 0 0 / 10%);
  backdrop-filter: blur(15px);
  margin: 2rem 0;
  padding: 40px;
}

.funding-title {
  font-size: 3rem;
  margin-bottom: 20px;
  text-transform: capitalize;
}

.funding-message {
  text-align: start;
  font-size: 18px;
  line-height: 2rem;
  position: relative;
  padding: 12px;
}

.funding-image {
  max-width: 100%;
  height: 50vh;
}
</style>
