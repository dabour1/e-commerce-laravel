<template>
  <div>
    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-5">
      <div class="container">
        <h1>Welcome to Dabour Store for Technomasr task</h1>
        <p>Your one-stop shop for all your needs</p>
        <router-link to="/products" class="text-decoration-none"
          ><button>Shop Now</button></router-link
        >
      </div>
    </header>

    <!-- Product Categories Section -->
    <section id="categories" class="py-5">
      <div class="container">
        <h2 class="text-center mb-4">Product Categories</h2>
        <div class="row">
          <div
            class="col-md-4"
            v-for="category in categories"
            :key="category.id"
          >
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">{{ category.name }}</h5>
                <p class="card-text">{{ category.description }}</p>
                <h3>Soon</h3>

                <router-link
                  style="pointer-events: none"
                  :to="'categories/' + category.id"
                  class="text-decoration-none"
                  ><button disabled class="btn btn-primary">
                    View Product
                  </button></router-link
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="py-5 bg-light">
      <div class="container">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row">
          <div class="col-md-4" v-for="product in products" :key="product.id">
            <div class="card">
              <img
                :src="product.image_url"
                class="card-img-top"
                :alt="product.name"
              />
              <div class="card-body">
                <h5 class="card-title">{{ product.name }}</h5>
                <p class="card-text">{{ product.description }}</p>
                <p class="card-text text-success">
                  {{ product.price }}
                </p>
                <router-link
                  :to="'products/' + product.id"
                  class="text-decoration-none"
                  ><button class="btn btn-primary">
                    View Product
                  </button></router-link
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- customers Section -->
    <section id="testimonials" class="py-5">
      <div class="container">
        <h2 class="text-center mb-4">What Our Customers Say</h2>
        <div class="row">
          <div
            class="col-md-4"
            v-for="testimonial in testimonials"
            :key="testimonial.id"
          >
            <div class="card">
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p>{{ testimonial.text }}</p>
                  <footer class="blockquote-footer">
                    {{ testimonial.author }}
                  </footer>
                </blockquote>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { datastore } from "../stors/productStore";
import { categoreyStore } from "../stors/categoryStore";
export default {
  async created() {
    await this.storData.getAllProducts();
    await this.categoreyStore.getCategories();
    this.products = this.storData.allProducts.slice(0, 3);
    this.categories = this.categoreyStore.categories.slice(0, 3);
  },
  data() {
    return {
      storData: datastore(),
      categoreyStore: categoreyStore(),
      categories: [],
      products: [],
      testimonials: [
        { id: 1, author: "Customer 1", text: "Testimonial from customer 1." },
        { id: 2, author: "Customer 2", text: "Testimonial from customer 2." },
        { id: 3, author: "Customer 3", text: "Testimonial from customer 3." },
      ],
    };
  },
};
</script>

<style scoped>
header {
  background-color: #007bff;
}

.card-title {
  font-size: 1.25rem;
  margin-bottom: 0.75rem;
}

.card-text {
  font-size: 1.1rem;
}

.card-text.text-success {
  color: #28a745;
}

.btn-primary {
  background-color: #007bff;
  border: none;
}

.btn-primary:hover {
  background-color: #0056b3;
}
</style>
