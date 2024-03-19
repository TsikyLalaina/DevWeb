<?php
    session_start();
    include("connect.php");
    include("functions.php");
    
    if(isset($_SESSION["user_id"])){
        header("Location: nosmembres.php");
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
                        header("Location: nosmembres.php");
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
    <header>
        <script src="jquery-3.7.1.js"></script>
        <title>Nos membres</title>
        <link rel="stylesheet" href="nosmbrlogin.css">
        <link rel="stylesheet" href="css\all.css">
    </header>
    <body>
        <div class="navbar">
            <a href="login.php"><img src="images/logo.png" class="logo"></a>
            <nav>
                <ul>
                    <li><a href="">HOME</a></li>
                    <li><a href="">REGION</a></li>
                    <li><a href="">Se connecte</a></li>
                </ul>
            </nav>
            <i class="fa-solid fa-right-to-bracket fa-xl"></i>
        </div>
        <section class="banner">
            <form action="" class="search-bar">
                <input type="text " placeholder="type to search..." name="q">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
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
                            <input id="username" type=text" required>
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
        </section>
        <section class="team">
            <div class="container">
                <div class="row row1">
                    <h1>Nos membres</h1>
                    <p>Lorem ipsum dolor sit amet consectetur 
                        adipisicing elit. Quisquam 
                        quibusdam itaque provident eveniet 
                        sapiente architecto minus praesentium earum 
                        optio maxime. Velit harum facere repellendus 
                        voluptas tempora, optio facilis consequatur 
                        ex?</p>
                </div>
                <div class="row row2">
                    <?php
                        $query = "select * from members";
                        $result = mysqli_query($con, $query);
                        if($result){
                            if($result && mysqli_num_rows($result) > 0){
                                while($member_data = mysqli_fetch_assoc($result)){
                                    echo '<div class="column">
                                            <input type="checkbox" class="select-card" data-memberid="' . $member_data['studentid'] . '">
                                            <div class="imgBox">
                                                <img src="' . $member_data['image'] . '" alt="profile">
                                            </div>
                                            <div class="details">
                                                <h3>' . $member_data['fname'] . '<br><span>' . $member_data['position'] . '</span></h3>
                                                <ul>
                                                    <li><a href="' . $member_data['facebook'] . '" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>';
                                }                                  
                            }else{echo '<h1>Aucun membre pour le moment</h1>';}
                        }else{
                            echo "Failed to fetch informations";
                        }
                    ?>
                </div>
        </section>
        <script src="script.js"></script>
    </body>
</html>