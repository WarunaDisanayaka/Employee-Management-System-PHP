<?php
include "../config/connection.php";

session_start();

if (isset($_GET['id'])) {
    $empid = $_GET['id'];
    // $emplname = $_SESSION['username'];
    $sql = "UPDATE employees SET status='Accepted' WHERE id = ?";
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empid);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Store deactivated successfully!');
        window.location.href = document.referrer;
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>