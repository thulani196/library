<?php 
    require_once '../core/init.config.php';
    include 'includes/header.php'; 
    include 'includes/navbar.php';
    include 'includes/right_bar.php'; 

    if(isset($_SESSION['USER_ID'])) {
        $userID = $_SESSION['USER_ID'];
    }

    if(isset($_POST['submit'])) {

        if(!empty($_FILES['book'])){
            $fileName = @$_FILES['book']['name'];
            $ext = strtolower(substr($fileName, strpos($fileName,'.') + 1));
            $fileName = md5(microtime()).'.'.$ext;
            $type = @$_Files['book']['type'];
            $tmp_name = @$_FILES['book']['tmp_name'];
             if(($ext == 'pdf') || ($ext == 'doc') || ($ext == 'docx')){
                $location = '../storage/books/';
                move_uploaded_file($tmp_name, $location.$fileName);
             } else {
               echo '<div style="color:red" class="w3-center">The file type must be jpg, jpeg, gif, or png.</div></br>';
             }
         }

        if(!empty($_FILES['thumbnail'])){
            $thumbnail = @$_FILES['thumbnail']['name'];
            $ext = strtolower(substr($thumbnail, strpos($thumbnail,'.') + 1));
            $thumbnail = md5(microtime()).'.'.$ext;
            $type = @$_Files['thumbnail']['type'];
            $tmp_name = @$_FILES['thumbnail']['tmp_name'];
            if(($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'png') || ($ext == 'gif')){
                $location = '../storage/thumbnails/';
                move_uploaded_file($tmp_name, $location.$thumbnail);
             } else {
               echo '<div style="color:red" class="w3-center">The file type must be jpg, jpeg, gif, or png.</div></br>';
             }
        }

        if(!empty($_POST['title']) && !empty($_POST['description'])) {

            $bookTitle = $_POST['title'];
            $description = $_POST['description'];

            $sql = "INSERT INTO books (`user_id`,`title`, `description`, `book`,`thumbnail`) VALUES ('$userID','$bookTitle', '$description', '$fileName', '$thumbnail') ";
            $db->query($sql);
        }

    }

    $getAllBooks = $db->query("SELECT * FROM books WHERE user_id = '$userID' ");
    $count = @mysqli_num_rows($getAllBooks);

?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Books
        <small>uploaded by you.</small>
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
                  <th>Book Title</th>
                  <th>Description</th>
                  <!-- <th>Platform(s)</th>
                  <th>Engine version</th> -->
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>

                <?php if($count > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($getAllBooks)): ?>
                        <tr>
                            <td><?= $row['title']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <!-- <td>Win 95+</td>
                            <td> 4</td> -->
                            <td>
                              <a href="books.php?delete=<?= $row['id']; ?>" class="btn btn-xs btn-danger">delete</a>
                              <a href="books.php?edit=<?= $row['id']; ?>" class="btn btn-xs btn-info">edit</a>
                            </td>
                        </tr>
                    <?php endwhile ?>
                <?php else: ?>
                    <div class="alert alert-info text-center"> You have not uploaded any books yet. </div>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Book</h4>
              </div>
              <div class="modal-body">
              <div class="box box-primary">
                <form role="form" enctype="multipart/form-data" method="POST" action="books.php">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Book Title:</label>
                            <input type="text" name="title" required class="form-control" placeholder="Book title...">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Book Description:</label>
                            <textarea class="form-control" required name="description" rows="3" placeholder="Description..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Book file:</label>
                            <input type="file" name="book" required id="exampleInputFile">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Book Thumbnail:</label>
                            <input type="file" name="thumbnail" required id="exampleInputFile">
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
  
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

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
