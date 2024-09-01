<?php include '../../view/header.php';
session_start();
?>


<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <h2>
                <?php
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    echo "welcome " . $_SESSION['username'];
                } else {
                    echo "Please Login to check more information";
                }
                ?>

            </h2>
        </div>
    </el-col>
</el-row>
<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <a href="../accesspoint">
            <div class="image-container"> <!-- this container is for transition animation -->
                <img src="../../static/image/home_background.png" alt="图片描述">
            </div>
            </a>
        </div>
    </el-col>
</el-row>

<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <p>Feel free to check the access points in our site😗</p>
            <br>
            <p>You could also view your subscription and usage from the pages left</p>
        </div>
    </el-col>
</el-row>

<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <p>If you have any issues during the subscription</p>
            <br>
            <p>Please leave a ticket for us</p>
        </div>
    </el-col>
</el-row>


<?php include '../../view/footer.php'; ?>