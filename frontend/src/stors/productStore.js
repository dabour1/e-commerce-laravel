import { defineStore } from "pinia";
export const datastore = defineStore("product", {
  state: () => ({
    allProducts: [],
    userInfo: JSON.parse(localStorage.getItem("userInfo")),
  }),
  actions: {
    async getAllProducts() {
      try {
        const res = await fetch("http://127.0.0.1:8000/api/products/");
        if (!res.ok) {
          throw new Error("can't fetch data from server");
        }
        const productsData = await res.json();
        this.allProducts = productsData.data;
      } catch (error) {
        console.error("Error fetching projects:", error);
        throw error;
      }
    },

    async getOneProduct(id) {
      try {
        const res = await fetch(`http://127.0.0.1:8000/api/products/${id}`);
        if (!res.ok) {
          throw new Error("can't fetch data from server");
        }
        const productsData = await res.json();
        return productsData.data;
      } catch (error) {
        console.error("Error fetching projects:", error);
        throw error;
      }
    },
  },

  getters: {},
});
