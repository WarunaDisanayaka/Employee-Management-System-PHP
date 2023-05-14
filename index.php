<?php
include "config/connection.php";
include "config/sweetalert.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Collect the form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if the email exists in the employees table
  $sql = "SELECT * FROM employees WHERE email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    // Verify the password
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
      // Login successful
      $_SESSION['email'] = $row['email'];
      $_SESSION['empid'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['company'] = $row['company'];

      // Redirect based on role
      if ($row['role'] == 'emp') {
        header('Location: emp/');
      } else if ($row['role'] == 'empl') {
        header('Location: empl/');
      } else if ($row['role'] == 'admin') {
        header('Location: admin/');
      } else {
        // Redirect back
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
      }
      exit;
    } else {
      // Incorrect password
      $error_message = 'Invalid email or password';
    }
  } else {
    // Email not found in employees table, check in company table
    $sql = "SELECT * FROM company WHERE email = '$email' AND status='Active'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password'])) {
        // Login successful
        $_SESSION['email'] = $row['email'];
        $_SESSION['emplid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['company'] = $row['company'];

        // Redirect based on role (assuming company has a role column)
        if ($row['role'] == 'empl') {
          header('Location: empl/');
        } else if ($row['role'] == 'admin') {
          header('Location: admin/');
        } else {
          // Redirect back
          header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit;
        }
        exit;
      } else {
        // Incorrect password
        $error_message = 'Your account is not activated';
      }
    } else {
      // Email not found in employees or company table
      $error_message = 'Invalid email or password';
    }
  }

  $conn->close();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
    <title>EMS</title>
  </head>
  <body>

  <section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Login to your account</h2>

              <form action="index.php" method="POST">
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example3cg">Your Email</label>
                  <input type="email" name="email" id="form3Example3cg" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4cg">Password</label>  
                  <input type="password" name="password" id="form3Example4cg" class="form-control form-control-lg" />
                  <span class="error"><?php echo $error_message; ?></span>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Haven't an account? <a href="register.php"
                    class="fw-bold text-body"><u>Register here</u></a></p>    
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>