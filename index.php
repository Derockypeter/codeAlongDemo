<?php
    session_start();

    if(isset($_SESSION['loggedIn'])){
        //redirect to home page (index.php)
        $url = '/modules/dashboard.php';
        header('location:'.$url);
    } else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        
        body, html, .wrapper {
            height: 100%;
        }
        body {
            background-image: url('public/image/loginBkgrd.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .wrapper {
            background-color: rgba(0, 0, 0, 0.6);
        }
        
        
    </style>

    <link href="public/css/codeAlongDemo.css" rel="stylesheet">

</head>
<body>
    <div class="row">
        <nav>
            <div class="nav-wrapper pink">
                <a href="#" class="brand-logo center">Lete'Chat</a>
            </div>
        </nav>
        <div class="flexedForm">
            <div class="" id="loginDiv">
                <form class="col s12" id="loginForm">
                    <h2 class="center-align">Login</h2>
                    <p class="loginfdBack"></p>
                    <div class="row">
                        <div class="">
                            <input id="loginUsername" name="loginUsername" placeholder="Username" type="text" required class="validate">
                        </div>
                        <div class="">
                            <input id="pass" name="loginPassword" placeholder="Password" type="password" required class="validate">
                        </div>
                        <div class="col s12">
                            <p class="right">Not Yet Registered?
                                <a href="#" onclick="openForm()"><b>Register</b></a>
                            </p>
                        </div>
                        <div class=" center-align">
                            <button class="btn" type="submit" name="loginBtn" id="loginBtn">Login
                                <!-- <i class="material-icons right">lock_open</i> -->
                            </button>
                        </div>
                        <div class="col s12 center-align">
                            <p> Forgot Password? <a href="#">Recover Account</a></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="" id="regDiv">
                <!-- Register Form -->
                <form class="col s12" id="regForm">
                    <h2 class="center-align">Register</h2>
                    <p class="fdBack"></p>
                    <div class="">
                        <input type="text" id="fName" class="validate" name="fName" placeholder="First Name">
                    </div>
                    <div class="">
                        <input type="text" id="lName" class="validate" name="lName" placeholder="Last Name">
                    </div>
                    <div class="">
                        <input type="email" id="email" class="validate" name="email" placeholder="Email">
                    </div>
                    <div class="">
                        <input type="text" id="username" class="validate" name="username" placeholder="Username">
                    </div>
                    <div class="">
                        <input type="password" id="password" class="validate" name="password" placeholder="Password">
                    </div>
                    <div class="">
                        <input type="password" id="confirm_password" class="validate" name="confirm_password" placeholder="Password Confirmation">
                    </div>
                    <div class="">
                        <p class="right">Already Registered?
                            <a href="#" onclick="openForm()"><b>Login</b></a>
                        </p>
                    </div>
                    <div class="center-align">
                        <button class="btn waves-effect waves-light" type="submit" name="regBtn">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
           
    </div>
    <footer class="center-align">
        <small>&copy; Copyright 2021. Lete'chat</small>
    </footer>
    <script src="public/js/jquery-3.5.1.min.js"></script>
    <script src="public/js/codeAlongDemo.js"></script>
</body>
</html>
<?php
    }
?>