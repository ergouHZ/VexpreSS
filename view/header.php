<!DOCTYPE html>
<html>

<head>
    <!-- HOW TO import the vue components without implementing Node.js
    I am using the CDN method
    https://element.eleme.io/#/en-US/component/installation -->
    <title>VexpreSS!</title>
    <meta charset="UTF-8">
    <!-- import CSS for VUE -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">

    <!-- this is the css file for each page's index -->
    <link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']) . '/index.css'; ?>">
    
</head>

<body>
    <!-- the navigation funtion is a template in element
    https://element.eleme.io/#/en-US/component/menu -->
    <div class="container"> <!--this is the container for all components -->
        <div class="header">
            <div class="header-left">NAVIGATION</div>
            <div class="header-right">
                <h2>VexpreSS!</h2>
            </div>
        </div>
        <!-- //add components for home page here -->
        <aside id="navMenu">
            <!-- the navigation menu on each page -->
            <el-col :span="24" class="aside-menu">
                <el-menu default-active="{{currentPage}}" class="el-menu-vertical" @select="onSelect">
                    <h5>Home</h5>
                    <el-menu-item index="1">
                        <i class="el-icon-menu"></i>
                        <span slot="title">DashBoard</span>
                    </el-menu-item>
                    
                    <el-menu-item index="2">
                        <i class="el-icon-coin"></i>
                        <span slot="title">Access Points</span>
                    </el-menu-item>
                    <h5>Billing</h5>
                    <el-menu-item index="3">
                        <i class="el-icon-shopping-cart-1"></i>
                        <span slot="title">Subscribe</span>
                    </el-menu-item>
                    <el-menu-item index="4">
                        <i class="el-icon-shopping-cart-full"></i>
                        <span slot="title">Orders</span>
                    </el-menu-item>
                    <h5>User</h5>
                    
                    <el-menu-item index="6">
                        <i class="el-icon-user"></i>
                        <span slot="title">Profile</span>
                    </el-menu-item>
                    <el-menu-item index="7">
                        <i class="el-icon-user"></i>
                        <span slot="title">My Tickets</span>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                    <el-menu-item>
                        <!-- the use of the button
                        https://element.eleme.io/#/en-US/component/button -->
                        <el-button type="info" plain @click="onLogout">Logout</el-button>
                        <el-button type="primary" @click="onSignIn">Sign in</el-button>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                    <el-menu-item>
                    </el-menu-item>
                </el-menu>

            </el-col>
        </aside>

        <main>
            <div id="app"> <!-- Vue intent starter for the subpage -->
                <!-- this is where the components starts -->