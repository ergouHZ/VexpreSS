</main>
</div> <!-- vue intent end point -->

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.16"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>

<!-- the navigation function at the home page -->
<script>
    const menuUrls = [
        '0',  //index 0
        '../home',       // index 1
        '../accesspoint',      // index 2
        '../subscribe',   // index 3
        '../orders',     // index 4
        '../usage',    // index 5
        '../profile',    // index 6
        '../tickets'     // index 7
    ];

    new Vue({
        el: '#navMenu', // to the start of the page structure
        data: {
            currentPage: 1, // index
            isCollaspe: false
        },

        methods: {
            //this is the navigation function
            onSelect(index) {
                console.log('chosen index path:', index);
                const url = menuUrls[index];  //select url through index

                if (url) {
                    this.currentPage = index;
                    window.location.href = url; // window.location to navigate
                    /* this.setData({
                        currentPage: index;
                    }); */
                } else {
                    console.error('undefined page url:', url);
                }

            },

            onSignIn() {
                console.log('sign in');
                const url = '../user';  //move to login page
                if (url) {
                    window.location.href = url; // window.location to navigate
                } else {
                    console.error('undefined page url:', url);
                }
            },


            onLogout() {
                this.$confirm('Sure to logout？', 'confirm', {
                    distinguishCancelAndClose: true,
                    confirmButtonText: 'confirm',
                    cancelButtonText: 'cancel'
                })
                    .then(() => { // post to the php api and unset the session
                        fetch("../../model/userSession.php", {
                            method: "POST",
                            credentials: "include", // include the cookie, otherwise the session won't be able to be written
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                console.log(data);
                                if (data.status === 200) {
                                    console.log(data.message);
                                    this.$alert("Logout success!", "Notification", {
                                        confirmButtonText: "OK",
                                        callback: (action) => {
                                            window.location.href = "../home";
                                        },
                                    });
                                }
                            })
                            .catch((error) => {
                                const h = this.$createElement;
                                this.$notify({
                                    title: "database error" + error.message,
                                    message: h("i", { style: "color: teal" }),
                                });
                            });
                    })
                    .catch(action => {

                    });
            }



        }
    });
</script>

<!-- the current each sub page js -->
<script src="<?php echo dirname($_SERVER['PHP_SELF']) . '/index.js'; ?>"></script>
<!-- at the index.js for each page in each subfolder, edit the script -->
<!-- and make sure that this revelant path is the current page that user activate -->

<footer>
    <p class="copyright">
        &copy;
        <?php echo date('Y'); ?> VexpreSS! VPN Inc.
    </p>
</footer>

</div>



<!-- if use external style, it will be responsive and be the current subpage,
so if have to change the style of the whole structure, using the internal style -->
<style>
    .container {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* the style of the header */
    .header {
        text-align: center;
        display: flex;
        position: fixed;
        align-items: center;
        /* the header is seperated in 2, so use this one */
        width: 100%;
        height: 50px;
        z-index: 999;
        /* 确保 header 在最上层 */
    }

    .header-left {
        width: 240px !important;
        background-color: #66b1ff;
        text-align: center;
        line-height: 50px;
        color: white;
    }

    h2 {
        margin: 0;
    }

    h5 {
        margin: 0;
        margin-top: 20px;
        text-align: center;
    }

    .header-right {
        flex: 1;
        /* use the rest of the space */
        background-color: #3375b9;
        text-align: center;
        overflow: hidden;
        color: white;
        line-height: 50px;

    }

    /* the main content style */
    main {
        margin-top: 50px;
        margin-left: 240px;
        display: flex;
        flex: 1;
        /* use the rest of the space */
    }


    /* style of navbar */
    .aside-menu {
        margin-top: 50px;
        width: 240px;
        height: 1080px;
        position: fixed;
        overflow-y: auto;
        /* if content is too much then allowed scroll vertically */
    }



    /* the styles for the HTML elements */
    html,
    body {
        height: 100%;
        /* 设置html和body的高度为100% */
        margin: 0;
        /* 去除默认的margin */
        padding: 0;
        /* 去除默认的padding */

    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #E5EfF3;
    }

    footer {
        clear: both;
        margin-top: 500px;
        position: fixed;
    }

    footer p {
        text-align: left;
        font-size: 80%;
        color: #000000;
    }

    #app {
        width: 100%;
    }

    /* here is the format for the customed container */
    .el-row {
        margin: 20px;
        margin-bottom: 20px;

        &:last-child {
            margin-bottom: 0;
        }
    }

    .el-col {
        border-radius: 8px;
    }

    .bg-bg {
        background: #99a9bf;
    }

    .bg-white {
        background: #ffffff;
    }

    .bg-purple {
        background: #b3e1bd;
    }

    .grid-content {
        padding: 20px;
        border-radius: 8px;
        min-height: 36px;
        text-align: center;
    }


    /* here is for the table */
    table {
        width: 90%;
        margin: 10px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    th {
        background-color: #f2f2f2;
        color: #333;
        font-weight: bold;
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }


    td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }


    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-right {
        text-align: left;
    }

    /* the image style here */
    img {
        max-width: 100%;

    }

    .image-container {
        position: relative;
        overflow: hidden;
        max-width: 100%;
    }

    .image-container img {
        max-width: 100%;
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .image-container:hover img {
        transform: scale(1.06);
    }

    /* this is for service hint icon */
    .service-icon{
        max-width: 60%;
        height: auto;
    }
</style>
</body>

</html>