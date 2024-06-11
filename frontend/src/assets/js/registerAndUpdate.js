class FunctionsClass {
  constructor() {}
  async getCountrys(par) {
    try {
      const response = await fetch(
        "https://countriesnow.space/api/v0.1/countries/codes"
      );
      const data = await response.json();
      par.countries = data.data.map((data) => {
        return data.name;
      });
    } catch (error) {
      console.error("Error fetching country codes:", error);
    }
  }

  HTMLValidations(e) {
    if (!e.target.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
      e.target.classList.add("was-validated");
      return false;
    } else {
      e.target.classList.add("was-validated");
      return true;
    }
  }

  createUserForm(par) {
    const formData = new FormData();
    formData.append("name", par.name);
    formData.append("email", par.email);
    formData.append("phone", par.phone);
    formData.append("image", par.image);
    formData.append("password", par.password);
    return formData;
  }

  async insertUserRequest(par) {
    const formData = this.createUserForm(par);
    // Validate the form data object to delete empty Properties before sending
    const form = Object.fromEntries(formData.entries());
    for (let [key, value] of Object.entries(form)) {
      console.log(key, value);
      if (!value || value === "null") {
        formData.delete(key);
      }
    }

    try {
      const response = await fetch("http://127.0.0.1:8000/api/users", {
        method: "POST",
        body: formData,
      });
      if (!response.ok) {
        console.log(response);
        throw new Error("can't insert data to server");
      }
      // const data = await response.json();

      par.$router.push("/congs");

      console.log(data);
    } catch (error) {
      console.error("Error fetching api:", error);
    }
  }

  confirm(e, par) {
    if (par.cpassword != par.password) {
      e.target.setCustomValidity("Passwords don't match");
    } else {
      e.target.setCustomValidity("");
    }
  }

  handleFileChange(event, par) {
    par.image = event.target.files[0];
  }

  handleFormSubmission(e, par) {
    if (this.HTMLValidations(e)) {
      this.insertUserRequest(par);
    }
  }

  getStorgData() {
    const localStorageData = JSON.parse(localStorage.getItem("userInfo"));
    let userData = localStorageData ? localStorageData : null;
    return userData;
  }

  async logedInPagesCreated(par) {
    let userData = this.getStorgData();
    if (!userData) {
      par.$router.push("/login");
    } else {
      par.storgData = userData;
      await par.storData.getUserData(userData.id, userData.token);
      par.user = par.storData.user;
    }
  }

  async featchUserData(par) {
    let userData = this.getStorgData();
    if (userData) {
      par.storgData = userData;
      await par.storData.getUserData(userData.id, userData.token);
      par.user = par.storData.user.data;
    }
  }
}

export default FunctionsClass;
