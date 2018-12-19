<?php
    require_once '../core/init.config.php';
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/right_bar.php';

    if(isset($_SESSION['USER_ID'])) {
        $userID = $_SESSION['USER_ID'];
    }

    $lecturers = $db->query("SELECT * FROM users WHERE `role` = 1");
    $courses = $db->query("SELECT * FROM courses");

    $count = @mysqli_num_rows($lecturers);
    $courseCount = @mysqli_num_rows($courses);

    if(isset($_POST['submit'])) {

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $userName = $_POST['username'];
        $nrc = $_POST['first_name'];
        $password = $_POST['password'];
        $department = $_POST['department'];
        $status = $_POST['status'];
        $mobile = $_POST['phone'];

        if($_POST['password'] == $_POST['password2']){
            //HASHING THE PASSWORD FOR SECURITY
            $password = password_hash($password, PASSWORD_DEFAULT);
            //INSERT QUERY REGISTERING NEW ADMIN TO THE DATABASE
            $sql = "INSERT INTO users (`first_name`, `last_name`, `password`, `mobile_number`, `student_number`, `status`,`nrc_id`, `role`)
                                        VALUES('$firstName','$lastName','$password','$mobile','$userName', '$status', '$nrc', 1)";

            $insert = $db->query($sql);
            // $_SESSION['add_admin'] = 'New user successfully added!';
            // header("Location: users.php");

      } else {
            echo '<div class="w3-red w3-center"> Passwords do not match!</div> ';
      }

    }
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Lecturer Maintenance
            <!-- <small>uploaded by you.</small> -->
        </h1>
        <ol class="breadcrumb">
            <li>
                <button type="button" class="btn btn-default btn-info" data-toggle="modal" data-target="#modal-default">
                    Launch Default Modal
                </button>
            </li>
        </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Data Table With Full Features</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th>NRC #</th>
                  <th>Department</th>
                  <!-- <th>Engine version</th>  -->
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>

                  <?php if($count > 0): ?>
                      <?php while($row = mysqli_fetch_assoc($lecturers)): ?>
                          <tr>
                              <td><?= $row['first_name']; ?></td>
                              <td><?= $row['last_name']; ?></td>
                              <td><?= $row['student_number']; ?></td>
                              <td><?= $row['nrc_id']; ?></td>
                              <td></td>
                              <td>
                                <a href="books.php?delete=<?= $row['id']; ?>" class="btn btn-xs btn-danger">delete</a>
                                <!-- <a href="books.php?edit=<?= $row['id']; ?>" class="btn btn-xs btn-info">edit</a> -->
                              </td>
                          </tr>
                      <?php endwhile ?>
                  <?php else: ?>
                      <div class="alert alert-danger text-center"> You have not created any Lecturer accounts yet. </div>
                  <?php endif; ?>

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
        </section>
</div>
</div>

 <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add a lecturer</h4>
              </div>
              <div class="modal-body">
              <div class="box box-primary">
                <form role="form" enctype="multipart/form-data" method="POST" action="lecturers.php">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name:</label>
                            <input type="text" name="first_name" required class="form-control" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Last Name:</label>
                            <input class="form-control" required name="last_name" rows="3" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Username:</label>
                            <input class="form-control" required name="username" rows="3" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mobile:</label>
                            <input class="form-control" required name="phone" rows="3" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">NRC #:</label>
                            <input class="form-control" required name="nrc" rows="3" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Password:</label>
                            <input type="password" name="password" class="form-control" required id="exampleInputFile">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Confirm Password:</label>
                            <input type="password" name="password2" class="form-control" required id="exampleInputFile">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Department:</label>
                            <!-- <input type="file" name="thumbnail" required id="exampleInputFile"> -->
                            <select class="form-control" required name="department">
                                <?php while($row = mysqli_fetch_assoc($courses)): ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['name'];?></option>
                                <?php endwhile; ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Account Status:</label>
                            <!-- <input type="file" name="thumbnail" required id="exampleInputFile"> -->
                            <select class="form-control" required name="status">
                                <option value="1">Active</option>
                                <option value="0">Suspended</option>
                            </select>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                    </div>

                </form>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
