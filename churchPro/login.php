<?php
    session_start();
    include("connect.php");
    include("functions.php");
    
    if(isset($_SESSION["user_id"])){
        header("Location: index.php");
        die;
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!empty($_POST['mail']) && !empty($_POST['password'])){
            $query= $con->prepare("SELECT * FROM users WHERE mail = ? LIMIT 1");
            $query->bind_param("s", $_POST["mail"]);
            $query->execute();
            $result = $query->get_result();
            if($result){
                if($result && $result->num_rows > 0){
                    $user_data = $result->fetch_assoc();
                    if($user_data['password'] === $_POST['password']){
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: index.php");
                        die;
                    }
                }echo "wrong username or passord!";
            }else{
                echo "Please Enter valid information!";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="jquery-3.7.1.js"></script>
        <link rel="stylesheet" href="css\all.css">
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <title>Home Page</title>
    </head>
    <body>
        <div class="container">
            <div class="navbar">
                <img src="images/logo.png" class="logo">
                <nav>
                    <ul>
                        <li><a href="">HOME</a></li>
                        <li><a href="">REGION</a></li>
                        <li><a href="">Se connecte</a></li>
                    </ul>
                </nav>
                <i class="fa-solid fa-right-to-bracket fa-xl"></i>
            </div>
            <div class="row">
                <div class="col col1">
                    <h1>EMIFI</h1>
                    <p>Ny EMIFI na Emit Mikalo Fiderana dia 
                        vondrona iray na an-tokom-pihira (Chorale) iray 
                        mivoitra eo anivon'ny Oniversiten'ny Fianarantsoa, 
                        izay mitory sy midera ny filazantsaran'ny Tompo 
                        Andriamanitra amin'ny alalan'ny hira avy amin'ireo
                        mpandraharaha sy ireo mpianatra eo amin'ny sekoly 
                        EMIT na Ecole de Management et d'Innovation Technologique.</p>
                    <button type="button"><span></span>Devenir membre</button>
                </div>
                <div class="col col2">
                    <a href="nosmbrlogin.php">
                        <div class="card card1">
                            <h5>Nos Membres</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing 
                                elit.</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card card2">
                            <h5>Sahara Desert</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing 
                                elit.</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card card3">
                            <h5>Sahara Desert</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing 
                                elit.</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card card4">
                            <h5>Sahara Desert</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing 
                                elit..</p>
                        </div>
                    </a>
                </div>
                <div class="wrapper">
                    <i class="fa-solid fa-xmark"></i>
                    <div class="button-box">
                        <div id="btn"></div>
                        <button type="button" class="toggle-btn" onclick="toggleLog()">Login</button>
                        <button type="button" class="toggle-btn" onclick="toggleReg()">Register</button>
                    </div>
                    <div class="form-box login">
                        <!--<h2>Login</h2>-->
                        <form method="post">
                            <div class="input-box">
                                <i class="fa-solid fa-envelope"></i>
                                <input id="mail" name="mail" type="email" required>
                                <label for="mail">Email</label>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-lock" ></i>
                                <input id="password" name="password" type="password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="remember-forgot">
                                <label><input type="checkbox">Remember me</label>
                                <a href="#">Forgot Password?</a>
                            </div>
                            <button type="submit">Login</button>
                            <div  class="register-link">
                                <p>Don't have an account?<a href="#" class="register-link">Register</a></p>
                            </div>
                        </form>
                    </div>
                    <div class="form-box register">
                        <form action="#">
                            <!--<h2>Registration</h2>-->
                            <div class="input-box">
                                <i class="fa-solid fa-user"></i>
                                <input id="username" type="text" required>
                                <label for="mail">Username</label>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-envelope"></i>
                                <input id="mail" type="email" required>
                                <label for="mail">Email</label>
                            </div>
                            <div class="input-box">
                                <i class="fa-solid fa-lock" ></i>
                                <input id="password" type="password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="remember-forgot">
                                <label><input type="checkbox" required>I agree to the terms & conditions</label>
                            </div>
                            <button type="submit">Register</button>
                            <div  class="login-link">
                                <p>Already have an account?<a href="#" class="loginr-link">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>