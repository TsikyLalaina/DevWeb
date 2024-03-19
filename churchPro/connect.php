<?php
    $dbhost = "127.0.0.1:3307";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "loginchurch";
    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("failed to connect!");
    }