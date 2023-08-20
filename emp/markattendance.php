<?php
include "../config/connection.php";

session_start();

if (isset($_POST['id'])) {
    $empid = $_POST['id'];
    $date = $_POST['date'];
    $status = $_POST['action'];

    // Check if attendance is already marked for the given employee and date
    $existingSql = "SELECT COUNT(*) FROM attendance WHERE empid = ? AND date = ?";
    $existingStmt = mysqli_prepare($conn, $existingSql);
    mysqli_stmt_bind_param($existingStmt, 'ds', $empid, $date);
    mysqli_stmt_execute($existingStmt);
    mysqli_stmt_bind_result($existingStmt, $count);
    mysqli_stmt_fetch($existingStmt);
    mysqli_stmt_close($existingStmt);

    if ($count > 0) {
        echo "<script>
        alert('Attendance already marked for the selected employee and date.');
        window.location.href = document.referrer;
        </script>";
    } else {
        $sql = "INSERT INTO attendance (empid, date, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die('Database error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'dss', $empid, $date, $status);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
            alert('Attendance marked successfully!');
            window.location.href = document.referrer;
            </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        mysqli_stmt_close($stmt);
    }
}
?>
