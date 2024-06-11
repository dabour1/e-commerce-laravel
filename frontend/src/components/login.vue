<template>
  <div class="login mt-3 row justify-content-center align-items-center rounded">
    <div
      class="loginCard bg-white rounded row flex-column justify-content-evenly"
    >
      <div class="normalLogIn row gap-4 justify-content-center">
        <p v-if="faild" class="text-center text-danger errMsg">
          Invalid Email or Password
        </p>

        <div class="form-floating">
          <input
            type="email"
            id="loginName"
            class="form-control"
            placeholder="email"
            v-model="email"
          />
          <label for="loginName" class="text-dark">Email</label>
        </div>

        <div class="form-floating">
          <input
            type="password"
            id="loginPassword"
            class="form-control"
            placeholder="password"
            v-model="password"
          />
          <label class="text-dark" for="loginPassword">Password</label>
        </div>
      </div>

      <div class="">
        <div class="form-check bg-secondary rounded-3">
          <input
            type="radio"
            class="form-check-input"
            id="validationFormCheck2"
            name="radio-stacked"
            value="admin"
            v-model="role"
            required
          />
          <label class="form-check-label" for="validationFormCheck2"
            >Login in as Admin</label
          >
        </div>
        <div class="form-check bg-secondary rounded-3">
          <input
            type="radio"
            class="form-check-input"
            id="validationFormCheck3"
            name="radio-stacked"
            value="user"
            v-model="role"
            required
          />
          <label class="form-check-label" for="validationFormCheck3"
            >Login in as user</label
          >
        </div>
        <div class="invalid-feedback">More example invalid feedback text</div>
      </div>

      <button
        type="submit"
        class="btn btn-outline-primary rounded-5"
        @click="sendLoginReq"
      >
        Sign in
      </button>

      <div class="text-center">
        <span>Not a member? </span>
        <router-link
          to="/registration"
          class="text-primary text-decoration-underline"
          >Register Now</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      faild: false,
      email: "",
      password: "",
      role: "",

      errorMessage: "",
    };
  },
  methods: {
    async sendLoginReq() {
      if (!this.email || !this.password || !this.role) {
        alert("All fields are required!");
        return;
      }

      const userData = {
        email: this.email,
        password: this.password,
        role: this.role,
      };

      try {
        this.errorMessage = "";

        const res = await fetch("http://127.0.0.1:8000/api/auth/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(userData),
        });

        if (!res.ok) {
          this.faild = true;
          throw new Error("Request failed with status " + res.status);
        }
        const data = await res.json();
        localStorage.setItem("userInfo", JSON.stringify(data));
        // this.$router.push("/");
        window.location.href = "http://localhost:5173/";
      } catch (error) {
        console.error("Login error:", error.message);
      }
    },
  },
};
</script>

<style scoped>
.login {
  height: 85vh;
}
.loginCard {
  opacity: 0.8;
  color: black;
  width: 33%;
  height: 100%;
}
#loginName,
#loginPassword {
  border: none;
  border-bottom: 0.5px solid #777777e1;
  border-radius: 0% !important;
}
#loginName:focus,
#loginPassword:focus {
  box-shadow: none !important;
}
@media (orientation: portrait) {
  .loginCard {
    width: 60%;
  }
}
input:-webkit-autofill,
input:-webkit-autofill:focus {
  transition: background-color 0s 600000s, color 0s 600000s !important;
}
@media (max-width: 768px) {
  .loginCard {
    width: 50%;
  }
}

@media (min-width: 769px) and (max-width: 1024px) {
  .loginCard {
    width: 40%;
  }
}
</style>
