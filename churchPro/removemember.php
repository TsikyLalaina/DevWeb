<?php
    include("connect.php"); // Ensure you have included the database connection

    // Check if the memberIds data is set and is an array
    if(isset($_POST['memberIds']) && is_array($_POST['memberIds'])) {
        $memberIds = $_POST['memberIds'];

        // Prepare the SQL statement to avoid SQL injection
        $stmt = $con->prepare("delete from members where studentid = ?");

        // Iterate over each member ID and execute the delete query
        foreach($memberIds as $memberId) {
            // Bind the member ID to the query and execute
            $stmt->bind_param("s", $memberId);
            $stmt->execute();
        }

        // Check for successful deletion
        if($stmt->affected_rows > 0) {
            echo "Members deleted successfully.";
        } else {
            echo "No members were deleted.";
        }

        // Close the statement and the database connection
        $stmt->close();
        $con->close();
    } else {
        echo "No member IDs received.";
    }