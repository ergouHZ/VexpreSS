//this function is called in php, so it needs to be isolated
/* function deleteOrder(ticketid) {
  const ticketId = button.getAttribute('data-ticket-id');
  console.log("on delete order");
  console.log(ticketId);
  fetch("../../model/DeleteTicket.php", {
    method: "POST",
    body: JSON.stringify(ticketId), //must have post the data in a strict format, or the date data will be error
    credentials: "include",
  })
  .then((response) => response.json())
  .then((res) => {
    console.log(res);
    if (res.status === 200) {
      // only the status code ==200 means successful
      console.log("Delete successfully!", "Subscription")
    } 
  })
  .catch((error) => {
    console.error("Error:", error.message);
  });
} */

function deleteOrder(button) {
  const ticket_id = button.getAttribute('data-ticket-id');
  console.log("on delete order");
  console.log(ticket_id);
  // 发送AJAX请求到PHP端点,传递ticketId
  fetch("../../model/DeleteTicket.php", {
    method: "POST",
    body: JSON.stringify({ticket_id}),
    credentials: "include",
  })
  .then((response) => response.json())
  .then((res) => {
    console.log(res);
    if (res.status === 200) {
      // 删除成功的处理逻辑
      console.log("Delete successfully!", "Subscription")
      alert("Delete successfully!")
    } 
  })
  .catch((error) => {
    alert("Delete error")
    console.error("Error:", error.message);
  });
}

new Vue({
  el: "#app", // point to the hooker
  data: {
    dialogVisible: false,
    form: {
      title: "",
      desc: "",
      username: "",
    },
  },

  methods: {
    onClickCreate() {
      this.dialogVisible = true;
    },

    onSubmit() {
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
            this.updateTheTicketInDatabase();
          } else {
            this.$alert("Please Login to check the ticket!", "Notification", {
              confirmButtonText: "OK",
              callback: (action) => {
                window.location.href = "../tickets"; //and refresh this page
              },
            });
          }
        })
        .catch((error) => {
          this.$alert("Please Login to check the ticket!", "Notification", {
            confirmButtonText: "OK",
            callback: (action) => {
              window.location.href = "../tickets"; //and refresh this page
            },
          });
          console.log("in error:" + error.message);
        });
    },

    updateTheTicketInDatabase() {
      const formattedStartDate = `${
        new Date().getFullYear() +
        "-" +
        ("0" + (new Date().getMonth() + 1)).slice(-2) +
        "-" + // month star from 0, so plus 1, and make sure this is 2 digit
        ("0" + new Date().getDate()).slice(-2)
      }`;
      console.log(formattedStartDate);

      const formData = {
        user_name: this.username,
        date: formattedStartDate,
        title: this.form.title,
        description: this.form.desc,
      };

      console.log(formData);
      //post here
      fetch("../../model/InsertTicket.php", {
        method: "POST",
        body: JSON.stringify(formData), //must have post the data in a strict format, or the date data will be error
        credentials: "include",
      })
        .then((response) => response.json())
        .then((res) => {
          if (res.status === 200) {
            // only the status code ==200 means successful
            this.$alert("Submit successfully!", "Subscription", {
              confirmButtonText: "Continue",
              callback: (action) => {
                this.$message({
                  type: "success",
                  message: ``,
                });
                window.location.href = "../tickets"; //and refresh this page
              },
            });
          } else {
            //if other code, print the error message
            this.$alert("please subscribe first" + res.message, "Error", {
              confirmButtonText: "Continue",
              callback: (action) => {
                this.$message({
                  type: "success",
                  message: ``,
                });
                window.location.href = "../tickets"; //and refresh this page
              },
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error.message);
          this.$alert("something wrong in database" + error.message, "Error", {
            confirmButtonText: "Continue",
            callback: (action) => {
              this.$message({
                type: "warning",
                message: ``,
              });
              window.location.href = "../tickets"; //and refresh this page
            },
          });
        });
    },

    
  },
});
