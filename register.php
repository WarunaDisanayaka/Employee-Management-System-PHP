<?php
include "config/connection.php";
include "config/sweetalert.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];
  $role = "emp";

  $nameerr = "";
  $emailerr = "";
  $passworderr = "";

  // Initialize an array to store error messages
  $errors = array();

  // Validate Name
  if (empty($name)) {
    $nameerr = "Name is required.";
  }

  // Validate Email
  if (empty($email)) {
    $emailerr = "Email is required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailerr = "Invalid email format.";
  }

  // Validate Password
  if (empty($password)) {
    $passworderr = "Password is required.";
  } elseif (strlen($password) < 6) {
    $passworderr = "Password should be at least 6 characters long.";
  }

  // Validate Confirm Password
  if (empty($cpassword)) {
    $errors['cpassword'] = "Confirm Password is required.";
  } elseif ($password !== $cpassword) {
    $errors['cpassword'] = "Passwords do not match.";
  }

  // Generate a secure hash of the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);


  // Check if there are any errors
  if (empty($nameerr) && empty($emailerr) && empty($passworderr)) {

    $sql = "INSERT INTO employees(email,username,password,role)VALUES(?,?,?,?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
      die('Database error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ssss', $email, $name, $hashed_password, $role);

    // Execute insert query
    if (mysqli_stmt_execute($stmt)) {
      // Redirect to success page
      echo '
      <script>
      swal({
        title: "Registration success!",
        text: "You can login now",
        icon: "success",
      });
      </script>';
    } else {
      die('Database error: ' . mysqli_error($conn));
    }

  } else {


  }
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
  <section class="vh-100 bg-image">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>
              
              <form action="register.php" method="POST">
                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1cg">Your Name</label>
                  <input type="text" id="form3Example1cg" name="name" class="form-control form-control-lg" />
                  <span class="error"><?php echo $nameerr; ?></span>
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example3cg">Your Email</label>
                  <input type="email" id="form3Example3cg" name="email" class="form-control form-control-lg" />
                  <span class="error"><?php echo $emailerr; ?></span>
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4cg">Password</label>
                  <input type="password" id="form3Example4cg" name="password" class="form-control form-control-lg" />
                  <span class="error"><?php echo $passworderr; ?></span>
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4cdg">Repeat your password</label>
                  <input type="password" id="form3Example4cdg" name="cpassword" class="form-control form-control-lg" />
                 
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="index.php"
                    class="fw-bold text-body"><u>Login here</u></a></p>
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