<?php
session_start();

include "../config/connection.php";

$empid = $_SESSION['empid'];

// Pending tasks
$pending = "SELECT tasks.id, tasks.empid, tasks.task, tasks.date,tasks.status, employees.email, employees.username
   FROM tasks JOIN employees ON tasks.empid = employees.id WHERE tasks.status='Pending' AND tasks.empid = $empid;";

$resultpending = mysqli_query($conn, $pending);

// Processing tasks
$processing = "SELECT tasks.id, tasks.empid, tasks.task,tasks.date, tasks.status, employees.email, employees.username
   FROM tasks JOIN employees ON tasks.empid = employees.id WHERE tasks.status='Processing' AND tasks.empid = $empid;";

$resultprocessing = mysqli_query($conn, $processing);

// Completed tasks
$completed = "SELECT tasks.id, tasks.empid, tasks.task, tasks.date,tasks.status, employees.email, employees.username
   FROM tasks JOIN employees ON tasks.empid = employees.id WHERE tasks.status='Completed' AND tasks.empid = $empid;";

$resultcompleted = mysqli_query($conn, $completed);

// Reviewed tasks
$reviewed = "SELECT tasks.id, tasks.empid, tasks.task,tasks.date, tasks.status, employees.email, employees.username
   FROM tasks JOIN employees ON tasks.empid = employees.id WHERE tasks.status='To be reviewed' AND tasks.empid = $empid;";

$resultreviewed = mysqli_query($conn, $reviewed);

// echo $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>My Tasks</title>
      <!-- Custom fonts for this template -->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link
         href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
         rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="css/sb-admin-2.min.css" rel="stylesheet">
      <!-- Custom styles for this page -->
      <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
   </head>
   <body id="page-top">
      <!-- Page Wrapper -->
      <div id="wrapper">
         <!-- Side bar -->
         <?php
         include 'sidebar.php'
            ?>
         <!-- End side bar -->
         <!-- Content Wrapper -->
         <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
               <!-- Topbar -->
               <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                  <!-- Sidebar Toggle (Topbar) -->
                  <form class="form-inline">
                     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                     <i class="fa fa-bars"></i>
                     </button>
                  </form>
                  
                  
                  <!-- Topbar Navbar -->
                  <ul class="navbar-nav ml-auto">
                     
                     
                  
                    
                     <!-- Nav Item - Messages -->
                     
                     <div class="topbar-divider d-none d-sm-block"></div>
                     <!-- Nav Item - User Information -->
                     <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username'] ?></span>
                        <img class="img-profile rounded-circle"
                           src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                           aria-labelledby="userDropdown">
                           <a class="dropdown-item" href="#">
                           <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                           Profile
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                           Settings
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                           Activity Log
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                           <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                           Logout
                           </a>
                        </div>
                     </li>
                  </ul>
               </nav>
               <!-- End of Topbar -->
               <!-- Begin Page Content -->
               <div class="container-fluid">
                  <!-- Page Heading -->
                  <h1 class="h3 mb-2 text-gray-800">My Tasks</h1>
                 
                  <!-- DataTales Example -->
                  <div class="container mt-5">
                     <div class="row">
                     
                            <div class="col-md-3 border-right">
                               <h4>Pending</h4>
                               <?php
                               foreach ($resultpending as $r) {
                                  ?>
                                                                     <div class="card mt-3">
                                                                        <div class="card-body">
                                                                           <h5 class="card-title"><?php echo $r['task'] ?></h5>
                                                                        
                                                                           <p class="card-text">Date: <?php echo $r['date'] ?></p>
                                                                           <a href="processing.php?id=<?php echo $r['id'] ?>" class="btn btn-primary">Set Processing</a>
                                                                        </div>
                                                                     </div>
                                                                     <?php
                               }
                               ?>
                            </div>
                           
                        <div class="col-md-3  border-right">
                           <h4>Processing</h4>
                           <?php
                           foreach ($resultprocessing as $r) {
                              ?>
                                                                     <div class="card mt-3">
                                                                        <div class="card-body">
                                                                           <h5 class="card-title"><?php echo $r['task'] ?></h5>
                                                                        
                                                                           <p class="card-text">Date: <?php echo $r['date'] ?></p>
                                                                           <a href="completed.php?id=<?php echo $r['id'] ?>" class="btn btn-primary">Set Completed</a>
                                                                        </div>
                                                                     </div>
                                                                     <?php
                           }
                           ?>
                        </div>
                        <div class="col-md-3  border-right">
                           <h4>Completed</h4>
                           <?php
                           foreach ($resultcompleted as $r) {
                              ?>
                                                                     <div class="card mt-3">
                                                                        <div class="card-body">
                                                                           <h5 class="card-title"><?php echo $r['task'] ?></h5>
                                                                       
                                                                           <p class="card-text">Status: <?php echo $r['status'] ?></p>
                                                                           <a href="processing.php?id=<?php echo $r['id'] ?>" class="btn btn-primary">Set Processing</a>
                                                                        </div>
                                                                     </div>
                                                                     <?php
                           }
                           ?>
                        </div>
                        <div class="col-md-3 border-right">
                           <h4>To be reviewed</h4>
                           <?php
                           foreach ($resultreviewed as $r) {
                              ?>
                                                                     <div class="card mt-3">
                                                                        <div class="card-body">
                                                                           <h5 class="card-title"><?php echo $r['task'] ?></h5>
                                                                        
                                                                           <p class="card-text">Status: <?php echo $r['status'] ?></p>
                                                                           <a href="processing.php?id=<?php echo $r['id'] ?>" class="btn btn-primary">Set Processing</a>
                                                                        </div>
                                                                     </div>
                                                                     <?php
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
               <div class="container my-auto">
                  <div class="copyright text-center my-auto">
                     <span>Copyright &copy; Your Website 2020</span>
                  </div>
               </div>
            </footer>
            <!-- End of Footer -->
         </div>
         <!-- End of Content Wrapper -->
      </div>
      <!-- End of Page Wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="logout.php">Logout</a>
               </div>
            </div>
         </div>
      </div>
      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="js/sb-admin-2.min.js"></script>
      <!-- Page level plugins -->
      <script src="vendor/datatables/jquery.dataTables.min.js"></script>
      <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
      <!-- Page level custom scripts -->
      <script src="js/demo/datatables-demo.js"></script>
   </body>
</html>