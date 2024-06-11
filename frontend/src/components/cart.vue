<template>
  <div class="container py-5">
    <div class="d-flex align-items-center my-3">
      <label for="check-all" class="m-0 mx-3 display-6">Shopping Cart</label>
    </div>

    <div v-if="cartItems.length > 0" class="row mt-5">
      <div class="col-12 col-lg-8">
        <div
          v-for="(cart, index) in cartItems"
          :key="index"
          class="d-flex my-2 p-3 border-2 border-dark border-bottom align-items-center"
        >
          <div class="d-flex align-items-center gap-3">
            <img
              class="img-responsive border-2 border-dark"
              width="100"
              height="100"
              :src="cart.product.image_url"
              :alt="cart.product.title"
            />
          </div>
          <div class="row w-100 ms-3">
            <div class="d-flex justify-content-between mb-3">
              <h5>{{ cart.product.title }}</h5>
              <button
                title="delete"
                type="button"
                @click="removeCartItem(cart.id)"
                class="btn-close bg-secondary"
              >
                <span class="visually-hidden">delete</span>
              </button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>Price: {{ cart.product.price }}</div>

              <div class="d-flex align-items-center gap-2">
                <label :for="'quantity-' + index" class="me-2">Quantity</label>
                <div class="input-group">
                  <button
                    class="btn btn-outline-secondary"
                    type="button"
                    @click="decreaseQuantity(cart)"
                    :disabled="cart.quantity <= 1"
                  >
                    -
                  </button>
                  <input
                    type="number"
                    :name="'quantity-' + index"
                    :id="'quantity-' + index"
                    v-model.number="cart.quantity"
                    min="1"
                    class="form-control text-center"
                    readonly
                  />
                  <button
                    class="btn btn-outline-secondary"
                    type="button"
                    @click="increaseQuantity(cart)"
                    :disabled="cart.quantity >= cart.product.stock"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="h-auto border border-2 border-dark p-3">
          <h5>Order Summary</h5>
          <div class="my-3">Total: {{ total }}</div>
          <button
            type="button"
            @click="createOrder"
            class="btn btn-outline-dark"
          >
            Checkout
          </button>
        </div>
      </div>
    </div>
    <div v-else class="text-center m-5 p-5">No Items found</div>
  </div>
</template>

<script>
import { catdatastore } from "../stors/cartStore";
export default {
  beforeCreate() {
    this.userInfo = JSON.parse(localStorage.getItem("userInfo"));
    if (!this.userInfo) {
      this.$router.push({ name: "login" });
    } else if (this.userInfo.role == "admin") {
      this.$router.push("/home");
    }
  },
  async created() {
    await this.storData.getCartItems();
    this.cartItems = this.storData.cartItems;
  },
  data() {
    return {
      userInfo: JSON.parse(localStorage.getItem("userInfo")),
      storData: catdatastore(),

      cartItems: [],
    };
  },
  computed: {
    total() {
      return this.cartItems.reduce(
        (acc, item) => acc + item.product.price * item.quantity,
        0
      );
    },
  },
  methods: {
    removeCartItem(id) {
      this.cartItems = this.cartItems.filter((item) => item.id !== id);
      this.storData.deletecartItem(id);
    },
    decreaseQuantity(cart) {
      if (cart.quantity > 1) {
        cart.quantity--;
        this.storData.updatacartItem(cart.id, cart.quantity);
      }
    },
    increaseQuantity(cart) {
      if (cart.quantity < cart.product.stock) {
        cart.quantity++;
        this.storData.updatacartItem(cart.id, cart.quantity);
      }
    },
    createOrder() {
      alert("Order created!");
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
