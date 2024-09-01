new Vue({
  el: "#app", // point to the hooker
  data: {
    username: "",
    password: "",
    phone: "",
    mode: "register",
  },
  methods: {
    registerUser() {
      // define the NF
      const usernameRegex = /^[a-zA-Z][\w]{5,}$/; // must start with a letter, no less than 6 characters
      const passwordRegex = /^.{6,}$/; // no less than 6 characters

      const formData = new FormData();
      formData.append("username", this.username); //bind the value in the form
      formData.append("password", this.password);
      formData.append("phone", this.phone);

      console.log(formData);
      console.log('on Reg'+this.username);

      //detect the username, and pop up the message by using the preset element funtion
      //https://element.eleme.io/#/en-US/component/notification
      if (!usernameRegex.test(this.username)) {
        const h = this.$createElement;
        this.$notify({
          title: "username error",
          message: h(
            "i",
            { style: "color: teal" },
            "Username must start with a letter, no less than 6 characters"
          ),
        });
        return;
      }

      //detect the password
      if (!passwordRegex.test(this.password)) {
        const h = this.$createElement;
        this.$notify({
          title: "Password error",
          message: h(
            "i",
            { style: "color: teal" },
            "Password must be not less than 6 characters"
          ),
        });
        return;
      }

      //the oringinal post function in js, which I found to be much easier for me, because if straightly interacting with the php script is really confusing and often causes bugs
      fetch("../../model/userRegister.php", {
        method: "POST",
        body: formData,
        credentials: "include", // include the cookie, otherwise the session won't be able to be written
      })
        .then((response) => response.json())
        .then((data) => {
          
          console.log(data);
          if (data.status === 200) {
            console.log(data.message);
            this.$alert("Register success!", "Notification", {
              confirmButtonText: "OK",
              callback: (action) => {
                window.location.href = "../home";
              },
            });
          } else {
            const h = this.$createElement;
            this.$notify({
              title: "username error,maybe duplicate",
              message: h("i", { style: "color: teal" }),
            });
          }
        })
        .catch((error) => {
          console.error(error);
          const h = this.$createElement;
            this.$notify({
              title: "database error"+error.message,
              message: h("i", { style: "color: teal" }),
            });
        });
    },

    loginUser() {
      // define the NF
      const usernameRegex = /^[a-zA-Z][\w]{5,}$/; // must start with a letter, no less than 6 characters
      const passwordRegex = /^.{6,}$/; // no less than 6 characters

      const formData = new FormData();
      formData.append("username", this.username); //bind the value in the form
      formData.append("password", this.password);

      console.log(formData);

      //detect the username, and pop up the message by using the preset element funtion
      //https://element.eleme.io/#/en-US/component/notification
      if (!usernameRegex.test(this.username)) {
        const h = this.$createElement;
        this.$notify({
          title: "username error",
          message: h(
            "i",
            { style: "color: teal" },
            "Username must start with a letter, no less than 6 characters"
          ),
        });
        return;
      }

      //detect the password
      if (!passwordRegex.test(this.password)) {
        const h = this.$createElement;
        this.$notify({
          title: "Password error",
          message: h(
            "i",
            { style: "color: teal" },
            "Password must be not less than 6 characters"
          ),
        });
        return;
      }

      //the oringinal post function in js, which I found to be much easier for me, because if straightly interacting with the php script is really confusing and often causes bugs
      fetch("../../model/userLogin.php", {
        method: "POST",
        body: formData,
        credentials: "include", // include the cookie, otherwise the session won't be able to be written
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);

          if (data.status === 200) {
            console.log(data.message);
            this.$alert("Login success! Welcome", "Notification", {
              confirmButtonText: "OK",
              callback: (action) => {
                window.location.href = "../home";
              },
            });
          } else {
            const h = this.$createElement;
            this.$notify({
              title: "username error",
              message: h("i", { style: "color: teal" }, data.message),
            });
          }
        })
        .catch((error) => {
          console.error(error);
          console.error("Error:", error.message);
          const h = this.$createElement;
            this.$notify({
              title: "severlet error",
              message: h("i", { style: "color: teal" }, error.message),
            });
        });
    },
  },
});
