<?php
    include "connect.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        // It's better to use prepared statements for all inputs, not just mysqli_real_escape_string
        $target_dir = "images/";
        $memberprofile = isset($_FILES['picture']['name']) ? $_FILES['picture']['name'] : '';
        $fullImagePath = $target_dir . basename($memberprofile);

        // Check if the required fields are not empty and the profile picture is set
        if(!empty($_POST['studentid']) && !empty($_POST['major']) && !empty($_POST['grade']) && !empty($_POST['name']) && !empty($_POST['fname']) && !empty($_POST['position']) && !empty($_POST['facebook']) && !empty($_POST['email'])){
            if(!empty($memberprofile)){
                if(move_uploaded_file($_FILES['picture']['tmp_name'], $fullImagePath)){
                    // Prepare an INSERT statement with placeholders
                    $stmt = $con->prepare("UPDATE `members` SET `major` = ?, `grade` = ?, `fname` = ?, `name` = ?, `position` = ?, `bio` = ?, `facebook` = ?, `email` = ?, `image` = ? WHERE `members`.`studentid` = ?");
                    if ($stmt === false) {
                        // Handle error
                        echo "Failed to prepare the statement.";
                        exit;
                    }
                    // Bind the parameters to the statement
                    $bindResult = $stmt->bind_param("ssssssssss", $_POST['major'], $_POST['grade'], $_POST['fname'], $_POST['name'], $_POST['position'], $_POST['bio'], $_POST['facebook'], $_POST['email'], $fullImagePath, $_POST['studentid']);
                    if ($bindResult === false) {
                        // Handle error
                        echo "Failed to bind parameters.";
                        exit;
                    }
                }else{
                    // Handle the error case where the file could not be moved
                    echo "Failed to upload the file.";
                }
            }else{
                $stmt = $con->prepare("UPDATE `members` SET `major` = ?, `grade` = ?, `fname` = ?, `name` = ?, `position` = ?, `bio` = ?, `facebook` = ?, `email` = ? WHERE `members`.`studentid` = ?");
                if ($stmt === false) {
                    // Handle error
                    echo "Failed to prepare the statement.";
                    exit;
                }                    // Bind the parameters to the statement
                $bindResult = $stmt->bind_param("sssssssss", $_POST['major'], $_POST['grade'], $_POST['fname'], $_POST['name'], $_POST['position'], $_POST['bio'], $_POST['facebook'], $_POST['email'], $_POST['studentid']);
                if ($bindResult === false) {
                    // Handle error
                    echo "Failed to bind parameters.";
                    exit;
                }
            }
                // Execute the statement
            $executeResult = $stmt->execute();
            if ($executeResult === false) {
                // Handle error
                echo "Failed to execute the statement.";
                exit;
            }
                // Prepare a SELECT statement to fetch the newly added member
            $stmt = $con->prepare("SELECT * FROM members WHERE studentid = ?");
            $stmt->bind_param("s", $_POST['studentid']);
            $stmt->execute();
                // Store the result so we can check the row count
            $result = $stmt->get_result();
            if($result && $result->num_rows > 0){
                // Fetch the associative array and encode it as JSON
                echo json_encode($result->fetch_assoc()); 
            }
            // Close the statement
            $stmt->close();
        }else{
            // Handle the error case where some fields are missing
            echo "Required fields are missing.";
        }
        // Close the database connection
        $con->close();
    }