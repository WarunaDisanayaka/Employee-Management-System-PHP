<?php
include "../config/connection.php";

session_start();

if (isset($_GET['id'])) {
    $empid = $_GET['id'];
    $emplid = $_SESSION['emplid'];
    $company = $_SESSION['company'];
    $status = "Requested";

    // Check if the status is already "Requested" for the specific empid in the database
    $checkSql = "SELECT COUNT(*) FROM requests WHERE empid = ? AND status = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, 'ds', $empid, $status);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_bind_result($checkStmt, $rowCount);
    mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);

    if ($rowCount > 0) {
        echo "<script>
            alert('Already requested!');
            window.location.href = document.referrer;
            </script>";
    } else {
        $sql = "INSERT INTO requests(empid,emplid,company,status)VALUES(?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die('Database error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ddss', $empid, $emplid, $company, $status);

        // Execute the SQL statement 
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
            alert('Requested added successfully!');
            window.location.href = document.referrer;
            </script>";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}



?>