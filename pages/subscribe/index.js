new Vue({
  el: "#app", // point to the hooker
  data: {
    currentDate: new Date(),
    dialogVisible: false,
    options: [
      //length of plans, unit:month
      {
        value: 1,
        label: "month",
      },
      {
        value: 3,
        label: "quarter",
      },
      {
        value: 12,
        label: "year",
      },
      {
        value: 2,
        label: "2 months",
      },
      {
        value: 24,
        label: "2 years",
      },
    ],
    value: 1,
    unitPrice: "",
    currentPlan: "",
    currentTotalPrice: "",
    username: "", //this use to update the database
    volumn: "", //the volumn of the plan
  },

  methods: {
    calculate1() {
      this.dialogVisible = true;
      this.unitPrice = 3.6;
      this.currentPlan = "Bronze";
      this.currentTotalPrice = (this.unitPrice * this.value).toFixed(2);
      this.volumn = 100;
    },

    calculate2() {
      this.dialogVisible = true;
      this.unitPrice = 4.6;
      this.currentPlan = "Gold";
      this.currentTotalPrice = (this.unitPrice * this.value).toFixed(2);
      this.volumn = 300;
    },

    calculate3() {
      this.dialogVisible = true;
      this.unitPrice = 6.6;
      this.currentPlan = "Platinum";
      this.currentTotalPrice = (this.unitPrice * this.value).toFixed(2);
      this.volumn = 500;
    },

    //the button in the confirm window
    confirmSubscription() {
      //get the username first
      fetch("../../model/userSession.php", {
        method: "GET", //the GET this php will return the username
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          if (data.status === 200) {
            console.log(data.message);
            this.username = data.username;
            console.log("the username):" + this.username); // see if the username returned successfully
            this.updateTheOrderInDatabase();
          } else {
            this.$alert(
              "Please Login to purchase the subscription!",
              "Notification",
              {
                confirmButtonText: "OK",
                callback: (action) => {
                  window.location.href = "../subscribe"; //and refresh this page
                },
              }
            );
          }
        })
        .catch((error) => {
          this.$alert(
            "Please Login to purchase the subscription! !",
            "Notification",
            {
              confirmButtonText: "OK",
              callback: (action) => {
                window.location.href = "../subscribe"; //and refresh this page
              },
            }
          );
          console.log("in error:" + error.message);
        });
    },

    updateTheOrderInDatabase() {
      //generate the end date for database
      const endDate = new Date(
        new Date().getFullYear(),
        new Date().getMonth() + this.value, //plus the number of the months
        new Date().getDate()
      );

      //make sure the format is as the same in the database
      const formattedEndDate = `${
        endDate.getFullYear() +
        "-" +
        ("0" + (endDate.getMonth() + 1)).slice(-2) +
        "-" + // month star from 0, so plus 1, and make sure this is 2 digit
        ("0" + endDate.getDate()).slice(-2)
      }`;
      console.log(formattedEndDate);

      //do the same thing to start date
      const formattedStartDate = `${
        this.currentDate.getFullYear() +
        "-" +
        ("0" + (this.currentDate.getMonth() + 1)).slice(-2) +
        "-" + // month star from 0, so plus 1, and make sure this is 2 digit
        ("0" + this.currentDate.getDate()).slice(-2)
      }`;
      console.log(formattedStartDate);

      const formData = {
        type: this.currentPlan,
        user_name: this.username,
        start_date: formattedStartDate,
        end_date: formattedEndDate,
        volumn_total: this.volumn,
      };

      console.log(formData);
      //post here
      fetch("../../model/Order.php", {
        method: "POST",
        body: JSON.stringify(formData), //must have post the data in a strict format, or the date data will be error
        credentials: "include",
      })
        .then((response) => response.json())
        .then((res) => {
          if (res.status === 200) { // only the status code ==200 means successful
            this.$alert("Subcribe successfully!", "Subscription", {
              confirmButtonText: "Continue",
              callback: (action) => {
                this.$message({
                  type: "success",
                  message: ``,
                });
                window.location.href = "../subscribe"; //and refresh this page
              },
            });
          }else{
            //if other code, print the error message
            this.$alert("please login to subscribe!"+res.message, "Error", {
              confirmButtonText: "Continue",
              callback: (action) => {
                this.$message({
                  type: "success",
                  message: ``,
                });
                window.location.href = "../subscribe"; //and refresh this page
              },
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error.message);
          this.$alert("something wrong in database"+ error.message, "Error", {
            confirmButtonText: "Continue",
            callback: (action) => {
              this.$message({
                type: "warning",
                message: ``,
              });
              window.location.href = "../subscribe"; //and refresh this page
            },
          });
        });
    },
  },
});
