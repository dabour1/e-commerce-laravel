<template>
  <div class="container my-5">
    <div class="row">
      <div
        v-for="product in products"
        :key="product.id"
        class="col-md-4 col-sm-6 mb-4"
      >
        <div class="card product-card">
          <img
            :src="product.image_url"
            class="card-img-top"
            :alt="product.name"
          />
          <div class="card-body">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text">{{ product.description }}</p>
            <p class="card-text text-success">${{ product.price }}</p>
            <button class="btn btn-primary" @click="addToCart(product)">
              Add to Cart
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { datastore } from "../stors/productStore";
import { catdatastore } from "../stors/cartStore";
export default {
  async created() {
    await this.storData.getAllProducts();
    this.products = this.storData.allProducts;
    await this.storData.getCartItems();
    this.cartItems = this.storData.cartItems;
  },
  data() {
    return {
      userInfo: JSON.parse(localStorage.getItem("userInfo")),
      storData: datastore(),
      cartStore: catdatastore(),
      products: [],
      cartItems: [],
    };
  },
  methods: {
    addToCart(product) {
      if (this.userInfo == null) {
        alert(`you must login to add items to cart`);
        return;
      }
      if (this.userInfo.role == "admin") {
        alert(`Admins have No Cart `);
        return;
      }
      const productExsting = this.cartItems.some(
        (item) => item.id == product.id
      );

      if (productExsting) {
        alert(`this item is already exist in your cart`);
        return;
      }
      this.cartStore.addItemToCart(product.id);
      this.cartItems.push(product);
      alert(`${product.name} has been added to your cart.`);
    },
  },
};
</script>

<style scoped>
header {
  background-color: #007bff;
}

.product-card {
  transition: transform 0.2s;
}

.product-card:hover {
  transform: scale(1.05);
}

.card-img-top {
  height: 200px;
  object-fit: cover;
}

.card-title {
  font-size: 1.25rem;
  margin-bottom: 0.75rem;
}

.card-text {
  font-size: 1.1rem;
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
