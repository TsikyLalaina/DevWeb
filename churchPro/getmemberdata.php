<?php
    include("connect.php");

    if(isset($_POST['studentid'])) {
        $studentid = $_POST['studentid'];
        $stmt = $con->prepare("SELECT * FROM members WHERE studentid = ?");
        $stmt->bind_param("s", $studentid);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $memberData = $result->fetch_assoc();
            echo json_encode($memberData);
        }else {
            echo "No member found with that ID.";
        }

        $stmt->close();
        $con->close();
    }else {
        echo "Student ID not provided.";
    }