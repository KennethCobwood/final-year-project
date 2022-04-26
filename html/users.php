<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
if ($_SESSION['role']==1) {
    header("Location: dashboard.php");
}


include 'includes/config.php';
$sql = "SELECT * from users where role=1";
$result = $conn->query($sql);

if(isset($_GET['id'])){
    $conn->query("delete from users where id=".$_GET['id']);
    $conn->query("delete from containers where user_id=".$_GET['id']);
    header("Location: users.php");
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
    <title>Users</title>
</head>
<body>
<?php include_once "includes/header.php";?>
<div class="container" style="margin-top: 40px !important;">
    <div class="col-12">
        <table id="datatable" class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>

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
                    <td><?php echo $row['email']; ?></td>
                    <td><a onclick="return confirm('are you sure?');" href="users.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-primary">Delete</a></td>
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