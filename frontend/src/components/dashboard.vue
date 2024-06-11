<template>
  <div class="container mt-5 row">
    <form @submit.prevent="submitProductForm" class="product-form col-6">
      <h2>Add Product</h2>
      <div class="form-group mb-3">
        <label for="title" class="form-label">Name:</label>
        <input
          type="text"
          v-model="product.name"
          class="form-control"
          id="name"
          required
        />
      </div>

      <div class="form-group mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea
          v-model="product.description"
          class="form-control"
          id="description"
        ></textarea>
      </div>

      <div class="form-group mb-3">
        <label for="price" class="form-label">Price:</label>
        <input
          type="number"
          v-model="product.price"
          class="form-control"
          id="price"
          min="10"
          required
        />
      </div>

      <div class="form-group mb-3">
        <label for="image" class="form-label">Image</label>
        <input
          type="file"
          @change="handleFileChange"
          class="form-control"
          id="image"
          required
        />
      </div>

      <div class="form-group mb-3">
        <label for="stock" class="form-label">Stock:</label>
        <input
          type="number"
          v-model="product.stock"
          class="form-control"
          id="stock"
          min="1"
          required
        />
      </div>

      <div class="form-group mb-3">
        <label for="categories" class="form-label">Categories:</label>
        <select
          v-model="product.categories"
          class="form-select"
          id="categories"
          multiple
        >
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>

      <div class="form-group mb-3">
        <label class="form-label">Variable Attributes:</label>
        <div
          v-for="(attribute, index) in product.attributes"
          :key="index"
          class="d-flex mb-2 align-items-center"
        >
          <select v-model="attribute.id" class="form-select me-2" required>
            <option
              v-for="attr in availableAttributes"
              :key="attr.id"
              :value="attr.id"
            >
              {{ attr.name }}
            </option>
          </select>
          <input
            type="text"
            v-model="attribute.value"
            class="form-control me-2"
            required
          />
          <button
            class="btn btn-danger"
            @click.prevent="removeAttribute(index)"
          >
            Remove
          </button>
        </div>
        <button class="btn btn-primary" @click.prevent="addAttribute">
          Add Attribute
        </button>
      </div>

      <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <div class="col-md-6 col-6">
      <h2>Add Category</h2>
      <form @submit.prevent="addCategory">
        <div class="mb-3">
          <label for="categoryName" class="form-label">Category Name</label>
          <input
            type="text"
            class="form-control"
            id="categoryName"
            v-model="newCategory"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
      </form>
      <h3>Existing Categories</h3>
      <ul class="list-group">
        <li
          v-for="category in categories"
          :key="category"
          class="list-group-item"
        >
          {{ category.name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { datastore } from "../stors/productStore";
import { categoreyStore } from "../stors/categoryStore";
export default {
  async created() {
    try {
      await this.categoreyStore.getCategories();
      this.categories = this.categoreyStore.categories;

      const res = await axios.get("http://127.0.0.1:8000/api/attributes", {
        headers: {
          Authorization: `Bearer ${this.adminInfo.token}`,
        },
      });
      this.availableAttributes = res.data.data;
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  },
  data() {
    return {
      adminInfo: JSON.parse(localStorage.getItem("userInfo")),
      productStore: datastore(),
      categoreyStore: categoreyStore(),
      product: {
        name: "",
        description: "",
        price: "",
        image: "",
        stock: "",
        categories: [],
        attributes: [],
      },
      newCategory: "",
      categories: [],
      availableAttributes: [],
    };
  },
  methods: {
    createFormData() {
      const formData = new FormData();
      formData.append("name", this.product.name);
      formData.append("description", this.product.description);
      formData.append("price", this.product.price);
      formData.append("image", this.product.image);
      formData.append("stock", this.product.stock);
      this.product.categories.forEach((category) => {
        formData.append("categories[]", category);
      });
      this.product.attributes.forEach((attribute, index) => {
        formData.append(`attributes[${index}][id]`, attribute.id);
        formData.append(`attributes[${index}][value]`, attribute.value);
      });
      return formData;
    },

    async submitProductForm() {
      try {
        const formData = this.createFormData();

        const response = await axios.post(
          "http://127.0.0.1:8000/api/products",
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
              Authorization: `Bearer ${this.adminInfo.token}`,
            },
          }
        );

        this.$router.push("/products");
      } catch (error) {
        console.error("Error creating product:", error);
      }
    },
    addAttribute() {
      this.product.attributes.push({ id: "", value: "" });
    },
    removeAttribute(index) {
      this.product.attributes.splice(index, 1);
    },
    handleFileChange(e) {
      this.product.image = e.target.files[0];
    },
    addCategory() {
      if (this.newCategory && !this.categories.includes(this.newCategory)) {
        this.categories.push(this.newCategory);
        this.categoreyStore.addCategory(this.newCategory);
      } else {
        alert("Category already exists");
      }
      this.newCategory = "";
    },
  },
};
</script>

<style scoped></style>
