import { defineStore } from "pinia";
export const catdatastore = defineStore("cartStore", {
  state: () => ({
    cartItems: [],
    userInfo: JSON.parse(localStorage.getItem("userInfo")),
  }),
  actions: {
    async getCartItems() {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/carts`, {
          method: "GET",
          headers: {
            Authorization: `bearer ${this.userInfo.token} `,
          },
        });
        if (!response.ok) {
          throw new Error("can't fetch data from server");
        }
        const cartItems = await response.json();
        this.cartItems = cartItems.data;

       
      } catch (error) {
        console.error("Error fetching cartItems data:", error);
      }
    },

    async addItemToCart(product_id) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/carts`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `bearer ${this.userInfo.token} `,
          },
          body: JSON.stringify({
            product_id,
          }),
        });
        if (!response.ok) {
          throw new Error("can't fetch data from server");
        }
        const cartItems = await response.json();
      } catch (error) {
        console.error("Error fetching cartItems data:", error);
      }
    },
    async updatacartItem(ItemId, quantity) {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/carts/${ItemId}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
              Authorization: `bearer ${this.userInfo.token} `,
            },
            body: JSON.stringify({
              quantity,
            }),
          }
        );
        if (!response.ok) {
          console.log(response);
          throw new Error("can't fetch data from server");
        }
        const cartItems = await response.json();
      } catch (error) {
        console.error("Error fetching cartItems data:", error);
      }
    },
    async deletecartItem(ItemId) {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/carts/${ItemId}`,
          {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
              Authorization: `bearer ${this.userInfo.token} `,
            },
          }
        );
        if (!response.ok) {
          console.log(response);
          throw new Error("can't fetch data from server");
        }
      } catch (error) {
        console.error("Error fetching cartItems data:", error);
      }
    },
  },

  getters: {},
});
