import { defineStore } from "pinia";
export const datastore = defineStore("userStore", {
  state: () => ({
    user: {},

    userInfo:
      JSON.parse(localStorage.getItem("userInfo")) ||
      JSON.parse(sessionStorage.getItem("userInfo")),
  }),
  actions: {
    async getUserData(id, token) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/users/${id}`, {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Authorization: `bearer ${token} `,
          },
        });
        if (!response.ok) {
          throw new Error("can't fetch data from server");
        }
        const user = await response.json();
        this.user = user;
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    },
    
  },

  getters: {},
});
