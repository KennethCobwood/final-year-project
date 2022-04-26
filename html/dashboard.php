<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/config.php';
$role=$_SESSION['role'];

if($role==0){
    $sql = "SELECT * from containers";
}else{
    $sql = "SELECT * from containers where user_id=" . $_SESSION['id'];
}

$result = $conn->query($sql);
$error = '';
if (isset($_POST['ubuntu'])) {
    $user_id = $_SESSION['id'];
    $type = 'Ubuntu Container';
    $date_created = date('Y-m-d');
    $sql = "INSERT INTO containers
	(user_id, type, date_created) VALUES ('$user_id', '$type', '$date_created')";
    if ($conn->query($sql) === TRUE) {
        $insert_id = $conn->insert_id;
        $port=get_port($insert_id);
        $content = "sudo docker run -d -p " . $port . ":80 -v /dev/shm:/dev/shm dorowu/ubuntu-desktop-lxde-vnc";
        create_container($content, $insert_id,$port,'ubuntu');
        $error .= "<p class='alert alert-success'>New record created successfully</p>";
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if (isset($_POST['alpine'])) {
    $user_id = $_SESSION['id'];
    $type = 'Fedora Container';
    $date_created = date('Y-m-d');
    $sql = "INSERT INTO containers
	(user_id, type, date_created) VALUES ('$user_id', '$type', '$date_created')";
    if ($conn->query($sql) === TRUE) {
        $insert_id = $conn->insert_id;
        $port=get_port($insert_id);
        $content = "sudo docker run -d -p " . $port . ":6080 richxsl/fedora-vnc-desktop";
        create_container($content, $insert_id,$port,'fedora');
        $error .= "<p class='alert alert-success'>New record created successfully</p>";
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if (isset($_POST['linux'])) {
    $user_id = $_SESSION['id'];
    $type = 'Kali Linux container';
    $date_created = date('Y-m-d');
    $sql = "INSERT INTO containers
	(user_id, type, date_created) VALUES ('$user_id', '$type', '$date_created')";
    if ($conn->query($sql) === TRUE) {
        $insert_id = $conn->insert_id;
        $port=get_port($insert_id);
        $content = "sudo docker run -d -p " . $port . ":6080 --privileged lukaszlach/kali-desktop:xfce";
        create_container($content, $insert_id,$port,'linux');
        $error .= "<p class='alert alert-success'>New record created successfully</p>";
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function get_port($id)
{
    $port = "";
    if (strlen($id) == 1 || strlen($id) == 2) {
        $port = (rand(1, 10000));
    }
    if (strlen($id) == 3 | strlen($id) == 4) {
        $port = $id . (rand(1, 100));
    }
    if (strlen($id) == 5 | strlen($id) == 6) {
        $port = (rand(1, 100));
    }
    return $port;
}

function create_container($content, $id, $port,$type)
{
    $connection = ssh2_connect('139.162.198.212', 22);
    ssh2_auth_password($connection, 'moz', 'testbed');
    $stream = ssh2_exec($connection, $content);
    stream_set_blocking($stream, true);
    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
    $server_result = stream_get_contents($stream_out);
    //echo shell_exec("sh run_container.sh");
    include 'includes/config.php';
    if($type=='linux'){
        $url = 'http://139.162.198.212:' . $port.'/vnc_auto.html';
    }if($type=="fedora"){
    $url = 'http://139.162.198.212:' . $port.'/vnc.html';
    }else{
        $url = 'http://139.162.198.212:' . $port;
    }

    $u_sql = "update containers set output='" . $server_result . "',url='" . $url . "' where id=" . $id;
    $conn->query($u_sql);

}
if(isset($_GET['id'])){
    $conn->query("delete from containers where id=".$_GET['id']);
    header("Location: dashboard.php");
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
    <title>Dashboard!</title>
</head>
<body>
<?php include_once "includes/header.php";?>
<div class="container" style="margin-top: 40px !important;">
    <?php echo $error; ?>
    <div class="col-12">
        <table id="datatable" class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th>Sr #</th>
                <th>Type</th>
                <!--<th>Title</th>-->
                <th>URL</th>
                <th>Date</th>
                <?php if($role==0){?>
                <th>Action</th>
                <?php }?>
            </tr>
            </thead>
            <tbody>
            <?php
            $sr = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $sr; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <!--   <td><?php /*echo $row['title']; */ ?></td>-->
                    <td><?php echo $row['url'];
                    if($row['type']=='Fedora Container'){
                        echo "<br>Password:hieghai8At";
                    }
                    ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row['date_created'])); ?></td>
                    <?php if($role==0){?>
                    <td><a onclick="return confirm('are you sure?');" href="dashboard.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-primary">Delete</a></td>
                    <?php }?>
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