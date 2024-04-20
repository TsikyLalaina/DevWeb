<?php
    $dbhost = "127.0.0.1:3307";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "order";
    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("failed to connect!");
    } 
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!empty($_POST['prixLog']) && !empty($_POST['codeCite']) && !empty($_POST['codeCli']) && !empty($_POST['numTer'])){
            $stmt = $con->prepare("INSERT INTO logement (prixLog, codeCite, codeCli, numTer) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $_POST['prixLog'], $_POST['codeCite'], $_POST['codeCli'], $_POST['numTer']);
            $stmt->execute();
            echo $stmt->get_result();
        } else {
            echo "Required fields are missing.";
        }
        $con->close();
    }
