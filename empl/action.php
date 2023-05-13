<?php
include "../config/connection.php";

session_start();

if (isset($_POST['status'])) {
    $task = $_POST['id'];
    echo $status = $_POST['action'];
    $sql = "UPDATE tasks SET status='$status' WHERE id = ?";
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Task status updated!');
        window.location.href = document.referrer;
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>