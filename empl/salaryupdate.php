<?php
include "../config/connection.php";

session_start();

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $emp = $_POST['emp'];
    $companyid = $_POST['companyid'];
    $month = $_POST['month'];
    $amount = $_POST['amount'];

    $sql = "UPDATE salary SET month = ?, amount = ? WHERE empid = ? AND companyid=? AND month=?";
    
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die('Database error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'sddds', $month, $amount, $id, $companyid, $month);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
        alert('Salary updated successfully!');
        window.location.href = document.referrer;
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    mysqli_stmt_close($stmt);
}
?>
