<template>
  <div class="register row justify-content-center align-items-center">
    <div class="registerCard bg-white row flex-column">
      <ul class="nav nav-pills nav-justified m-2" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
          <router-link to="/login"
            ><button
              class="nav-link"
              id="tab-register"
              data-mdb-toggle="pill"
              role="tab"
              aria-controls="pills-register"
              aria-selected="false"
            >
              Login
            </button></router-link
          >
        </li>

        <li class="nav-item" role="presentation">
          <router-link to="/registration"
            ><button
              class="nav-link"
              id="tab-register"
              data-mdb-toggle="pill"
              role="tab"
              aria-controls="pills-register"
              aria-selected="false"
            >
              Register
            </button></router-link
          >
        </li>
      </ul>
      <form
        @submit.prevent="handleFormSubmission($event)"
        class="row flex-column justify-content-center align-items-center needs-validation"
        novalidate
      >
        <div class="text-center">
          <p>Sign in with:</p>
          <button type="button" class="btn btn-link btn-floating mx-1">
            <i class="fab fa-facebook-f"></i>
          </button>

          <button type="button" class="btn btn-link btn-floating mx-1">
            <i class="fab fa-google"></i>
          </button>

          <button type="button" class="btn btn-link btn-floating mx-1">
            <i class="fab fa-twitter"></i>
          </button>

          <button type="button" class="btn btn-link btn-floating mx-1">
            <i class="fab fa-github"></i>
          </button>
        </div>

        <p class="text-center">or:</p>
        <div class="name col-md-10 p-0 row">
          <div class="col-md-6">
            <label for="fname" class="form-label">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              pattern="^[a-zA-Z ,.'\-]+$"
              placeholder=" name"
              v-model="name"
              required
            />
            <div class="invalid-feedback">
              Please enter a valid First name (letters, spaces, commas, periods,
              single quotes, and hyphens)!.
            </div>
          </div>

          <div class="col-md-6">
            <label for="useremail" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="useremail"
              pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
              placeholder="example@example.com"
              v-model="email"
              required
            />
            <div class="invalid-feedback">
              This email is either invalid or already associated with an
              existing account!.
            </div>
          </div>
        </div>
        <div class="col-md-10 p-0 row">
          <div class="col-md-6">
            <label for="validationCustom04" class="form-label">Country</label>
            <select
              class="form-select"
              id="validationCustom04"
              pattern="^[a-zA-Z ,.'\-]+$"
              v-model="country"
            >
              <option selected disabled value="">Choose...</option>
              <option v-for="country in countries" :key="country">
                {{ country }}
              </option>
              <option></option>
            </select>
            <div class="invalid-feedback">Please select a valid state.</div>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Mobile phone </label>
            <input
              type="text"
              class="form-control"
              id="phone"
              pattern="^01[012]\d{8}$"
              placeholder="phone number"
              v-model="phone"
              required
            />
            <div class="invalid-feedback">Please enter user Mobile no.!.</div>
          </div>
        </div>

        <div class="name col-md-10 p-0 row">
          <div class="col-md-6">
            <label for="password" class="form-label">password</label>
            <input
              type="password"
              class="form-control"
              pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
              id="password"
              placeholder="enter password"
              v-model="password"
              required
            />
            <div class="invalid-feedback">
              Please enter a valid password Minimum eight characters, at least
              one letter and one number and one special character!.
            </div>
          </div>
          <div class="col-md-6">
            <label for="validationCustom3" class="form-label"
              >Confirm password</label
            >
            <input
              type="password"
              class="form-control"
              pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
              id="validationCustom3"
              placeholder="Renter password"
              v-model="cpassword"
              @blur="confirm"
              required
            />
            <div class="invalid-feedback">
              Please enter a valid password that matchs with previous input !.
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-6">
          <label for="userimg" class="form-label">User Image</label>
          <input
            type="file"
            @change="handleFileChange"
            class="form-control"
            aria-label="user picture"
            id="userimg"
            required
          />
          <div class="invalid-feedback">Please select a vaild image!</div>
        </div>
        

        <div class="col-12 m-2 row">
          <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import FunctionsClass from "../assets/js/registerAndUpdate";
const functionsObject = new FunctionsClass();
export default {
  data: () => ({
    name: "",
    email: "",
    phone: "",
    password: "",
    cpassword: "",

    image: null,
    countries: [],
  }),
  beforeCreate() {
    localStorage.clear();
    sessionStorage.clear();
  },
  created() {
    functionsObject.getCountrys(this);
  },
  methods: {
    handleFormSubmission(e) {
      console.log(this.name);
      functionsObject.handleFormSubmission(e, this);
    },
    confirm(e) {
      functionsObject.confirm(e, this);
    },
    handleFileChange(e) {
      functionsObject.handleFileChange(e, this);
    },
  },
};
</script>

<style scoped>
.register {
  height: 100vh;
  flex-wrap: nowrap !important;
}
.registerCard {
  flex-wrap: nowrap !important;
  padding: 50px 20px;
  border-radius: 10%;
  background-color: rgb(91 91 91 / 50%) !important;
  color: rgb(235, 227, 227);

  width: 60vw;
}
p {
  margin-top: 0;
  margin-bottom: 0;
}
#userimg {
  display: block;
}
input {
  background-color: rgb(91 91 91 / 100%) !important;
}
</style>
