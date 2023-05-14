<?php
include "../config/connection.php";

session_start();

if (isset($_GET['id'])) {
    $task = $_GET['id'];
    $sql = "UPDATE tasks SET status='Completed', points=+1 WHERE id = ?";
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Task set to completed successfully!');
        window.location.href = document.referrer;
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>