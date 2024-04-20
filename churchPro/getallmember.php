<?php
include("connect.php");

$stmt = $con->prepare("SELECT * FROM members");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $allMembersData = array(); // Initialize an array to store all member data
    while ($memberData = $result->fetch_assoc()) {
        $allMembersData[] = $memberData; // Add each member's data to the array
    }
    echo json_encode($allMembersData); // Encode the array as JSON
} else {
    echo "No member found in the database.";
}

$stmt->close();
$con->close();
