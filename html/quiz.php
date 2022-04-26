<?php
include 'includes/config.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
if ($_SESSION['role']==1) {
    $sql = "SELECT * from quiz join users on users.id = quiz.user_id where quiz.user_id= ".$_SESSION['id'];
    $result = $conn->query($sql);
}
else{
    $sql = "SELECT * from quiz join users on users.id = quiz.user_id";
    $result = $conn->query($sql);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <title>Quiz</title>
</head>
<body>
<?php include_once "includes/header.php";?>
<div class="container" style="margin-top: 40px !important;">
    <div class="col-12">
            <div class="card-header">
                <a class="btn btn-primary" href="create.php">Start Quiz</a>
            </div>
        <table id="datatable" class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Name</th>
                <th>Module</th>
                <th>Task 1</th>
                <th>Task 2</th>
                <th>Task 3</th>
                <th>Task 4</th>
                <th>Task 5</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sr = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $sr; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['module']; ?></td>
                    <td><?php echo $row['task_1']; ?></td>
                    <td><?php echo $row['task_2']; ?></td>
                    <td><?php echo $row['task_3']; ?></td>
                    <td><?php echo $row['task_4']; ?></td>
                    <td><?php echo $row['task_5']; ?></td>
                    <td><?php echo $row['date_created']; ?></td>
                </tr>
                <?php
                $sr++;
            } ?>

            </tbody>
        </table>
    </div>
</div>

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/datatable/datatables.min.js"></script>
<script src="assets/datatable/datatables.bootstrap4.min.js"></script>
<script src="assets/datatable/pdfmake.min.js"></script>
<script src="assets/datatable/vfs_fonts.js"></script>
<script src="assets/datatable/datatables.buttons.min.js"></script>
<script src="assets/datatable/buttons.html5.min.js"></script>
<script src="assets/datatable/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            "responsive": true,
            "autoWidth": false,

        });
    });
</script>
</body>
</html>