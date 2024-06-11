import { defineStore } from "pinia";
import axios from "axios";
export const categoreyStore = defineStore("categoreyStore", {
  state: () => ({
    categories: [],
    userInfo: JSON.parse(localStorage.getItem("userInfo")),
  }),
  actions: {
    async getCategories() {
      try {
        const response = await axios.get(
          `http://127.0.0.1:8000/api/categories/`
        );

        this.categories = response.data.data;
      } catch (error) {
        console.error("Error fetching categories data:", error);
      }
    },

    async addCategory(name) {
      try {
        const response = await axios.post(
          `http://127.0.0.1:8000/api/categories/`,
          {
            name,
          },
          {
            headers: {
              "Content-Type": "application/json",
              Authorization: `bearer ${this.userInfo.token}`,
            },
          }
        );

        this.categories.push(response.data.data);
      } catch (error) {
        console.error("Error adding category:", error);
      }
    },
  },

  getters: {},
});
