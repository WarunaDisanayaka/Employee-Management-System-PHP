<?php
include "../config/connection.php";

session_start();

if (isset($_POST['add'])) {
    echo $task = $_POST['task'];
    echo $emp = $_POST['emp'];
    $companyid = $_SESSION['emplid'];
    $date = $_POST['date'];
    $status = "Pending";
    $sql = "INSERT INTO tasks(empid,companyid,date,task,status)VALUES(?,?,?,?,?)";
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die('Database error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ddsss', $emp, $companyid, $date, $task, $status);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Task added successfully!');
        window.location.href = document.referrer;
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>