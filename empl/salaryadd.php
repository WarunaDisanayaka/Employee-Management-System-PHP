<?php
include "../config/connection.php";

session_start();

if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $emp = $_POST['emp'];
    $companyid = $_SESSION['emplid'];
    $month = $_POST['month'];
    $amount = $_POST['amount'];

    // Check if a salary record already exists for the given employee, company, and month
    $existingSql = "SELECT COUNT(*) FROM salary WHERE empid = ? AND companyid = ? AND `month` = ?";
    $existingStmt = mysqli_prepare($conn, $existingSql);
    mysqli_stmt_bind_param($existingStmt, 'dds', $emp, $companyid, $month);
    mysqli_stmt_execute($existingStmt);
    mysqli_stmt_bind_result($existingStmt, $count);
    mysqli_stmt_fetch($existingStmt);
    mysqli_stmt_close($existingStmt);

    if ($count > 0) {
        echo "<script>
        alert('Salary record already exists for the selected employee, company, and month.');
        window.location.href = document.referrer;
        </script>";
    } else {
        $sql = "INSERT INTO salary(empid, companyid, month, amount) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die('Database error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ddsd', $emp, $companyid, $month, $amount);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
            alert('Salary added successfully!');
            window.location.href = document.referrer;
            </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        mysqli_stmt_close($stmt);
    }
}
?>
