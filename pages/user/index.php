<?php include '../../view/header.php';
?> <!-- import database and the account method -->




<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <p>Please register or login here</p>
            <br>
            <p>And start the further function😘</p>
        </div>
    </el-col>
</el-row>

<el-row>
    <el-col :span="22" :offset="1">
        <div class="grid-content bg-white">
            <form @submit.prevent="handleSubmit">
                <label for="username">username:</label>
                <input type="text" id="username" v-model="username" required><br><br><br>
                <label for="password">password:</label>
                <input type="password" id="password" v-model="password" required><br><br><br>
                
                
                <el-button type="info" @click="registerUser" plain>Register</el-button>
                <el-button type="primary" @click="loginUser">Logn</el-button>
            </form>
        </div>
    </el-col>
</el-row>



<?php include '../../view/footer.php'; ?>