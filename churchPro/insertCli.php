<?php
    $dbhost = "127.0.0.1:3307";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "order";
    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("failed to connect!");
    } 
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['numero']) && !empty($_POST['email'])){
            $stmt = $con->prepare("INSERT INTO client (nom, prenom, adresse, numero, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['numero'], $_POST['email']);
            $stmt->execute();
            echo $stmt->get_result();
        } else {
            echo "Required fields are missing.";
        }
        $con->close();
    }
