<?php
    session_start();
    include("connect.php");
    include("functions.php");
    $user_data = check_login_nosmbr($con);
?>
<!DOCTYPE html>
<html>
    <header>
        <script src="jquery-3.7.1.js"></script>
        <title>Nos membres</title>
        <link rel="stylesheet" href="nosmembres.css">
        <link rel="stylesheet" href="css\all.css">
    </header>
    <body>
        <div class="navbar">
            <a href="index.php"><img src="images/logo.png" class="logo"></a>
            <nav>
                <ul>
                    <li>
                        <form action="" class="top-search-bar">
                            <input type="text " placeholder="type to search..." name="q" class="livesearch">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass fa-2xl"></i></button>
                        </form>
                    </li>
                    <li><i class="fa-solid fa-user-plus fa-2xl"></i></li>
                    <li><i class="fa-solid fa-user-pen fa-2xl"></i></li>
                    <li><i class="fa-solid fa-user-minus fa-2xl" onclick="deleteCards()"></i></li>
                    <!--<li><i class="fa-solid fa-check fa-2xl"></i></li>-->
                </ul>
            </nav>
        </div>
        <section class="banner">
            <form action="" class="search-bar">
                <input type="text " placeholder="type to search..." name="q" class="livesearch">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
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
                        include("displaymembers.php");
                    ?>
                </div>
        </section>
        <h1>FORMULAIRE D'APPLICATION</h1>
        <section class="addmember">
            <form id="memberForm" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="studentid">Student ID:</label>
                    <input type="text" id="studentid" name="studentid" required>
                </div>
                <div class="form-group">
                    <label for="major">Major:</label>
                    <input type="text" id="major" name="major" required>
                </div>
                <div class="form-group">
                    <label for="grade">Grade:</label>
                    <input type="text" id="grade" name="grade" required>
                </div>
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="position">Position in Club:</label>
                    <input type="text" id="position" name="position">
                </div>
                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <textarea id="bio" name="bio" maxlength="200"></textarea>
                </div>
                <div class="form-group">
                    <label for="facebook">Facebook Link:</label>
                    <input type="url" id="facebook" name="facebook">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="picture">Profile Picture:</label>
                    <input type="file" id="picture" name="picture" accept="images/*" required>
                </div>
                <div class="form-group">
                    <button type="submit">Submit Application</button>
                </div>
            </form>
        </section>
        <script src="nosmembres.js"></script>
    </body>
</html>
