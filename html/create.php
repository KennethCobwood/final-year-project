<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
/*if ($_SESSION['role'] == 1) {
    header("Location: dashboard.php");
}*/
include 'includes/config.php';

$error = '';
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['id'];
    $module = $_POST['module'];
    $task_1 = $_POST['task_1'] ?? null;
    $task_2 = $_POST['task_2'] ?? null;
    $task_3 = $_POST['task_3'] ?? null;
    $task_4 = $_POST['task_4'] ?? null;
    $task_5 = $_POST['task_5'] ?? null;
    $date_created = date('Y-m-d');
    if (empty($_POST['module'])) {
        $error .= "<p class='alert alert-danger'>Module Name is required.</p>";
    }
    if (empty($_POST['task_1']) && empty($_POST['task_2']) && empty($_POST['task_3']) && empty($_POST['task_4']) && empty($_POST['task_5'])) {
        $error .= "<p class='alert alert-danger'>Must Select 1 Answer</p>";
    }
    if (empty($error)) {

        $sql = "INSERT INTO quiz (user_id, module, task_1, task_2, task_3, task_4, task_5, date_created)
				VALUES ('$user_id', '$module', '$task_1','$task_2', '$task_3', '$task_4', '$task_5', '$date_created')";
        if ($conn->query($sql) === TRUE) {
            $error .= "<p class='alert alert-success'>Wow! Quiz Completed.</p>";
        } else {
            $error .= "<p class='alert alert-danger'>Wops! Something Wrong Went.</p>";
        }
    }
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
<?php include_once "includes/header.php"; ?>
<div class="container" style="margin-top: 40px !important;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a>Quiz</a>
            </div>
            <div class="card-body">
                <?php echo $error; ?>
                <form method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="module">Module</label>
                                <select onchange="show()" name="module" id="module" class="form-control">
                                    <option value=""> --Select --</option>
                                    <option value="SAD Secured Application development">SAD Secured Application
                                        development
                                    </option>
                                    <option value="FORENSICS">FORENSICS</option>
                                    <option value="REVERSE MALWARE">REVERSE MALWARE</option>
                                    <option value="NETWORKING">NETWORKING</option>
                                </select>
                            </div>
                        </div>
                        <div id="SAD" class="col-sm-12 d-none">
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_1"
                                           value="Create a folder with the name sad1: Command mkdir sad1 10%">
                                    Create a folder with the name sad1: Command mkdir sad1 10%
                                </label>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_2" value="Create another directory called sad2 10% and in that directory create a file called xss.txt
                            10%">
                                    Create another directory called sad2 10% and in that directory create a file called
                                    xss.txt
                                    10%
                                </label>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_3"
                                           value="Move the file from sad2 directory to sad1 directory. 10%">
                                    Move the file from sad2 directory to sad1 directory. 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_4"
                                           value="Delete xss.txt: Command sudo rm xss.txt 10%">
                                    Delete xss.txt: Command sudo rm xss.txt 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_5"
                                           value="Delete sad1 and sad2: Command sudo rmdir sad1 sad2 10%">
                                    Delete sad1 and sad2: Command sudo rmdir sad1 sad2 10%
                                </label>
                            </div>
                        </div>
                        <div id="FORENSICS" class="col-sm-12 d-none">
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_1"
                                           value="Create a directory called lab1: Command mkdir lab 10%">
                                    Create a directory called lab1: Command mkdir lab 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_2"
                                           value="Create a file called student1: Command nano student1.txt 10%">
                                    Create a file called student1: Command nano student1.txt 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_3"
                                           value="Do a list command to see all the file details r-w-x Command ls -l 10%">
                                    Do a list command to see all the file details r-w-x Command ls -l 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_4"
                                           value="Delete all files created: Command sudo rm student.txt 10%">
                                    Delete all files created: Command sudo rm student.txt 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_5" value="remove folder: sudo rmdir lab1 10%">
                                    remove folder: sudo rmdir lab1 10%
                                </label>
                            </div>
                        </div>
                        <div id="REVERSE" class="col-sm-12 d-none">
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_1"
                                           value="Create a directory called rev1 command mkdir lab 10%">
                                    Create a directory called rev1 command mkdir lab 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_2"
                                           value="Create a file called rev1.txt Command nano rev1.txt 10%">
                                    Create a file called rev1.txt Command nano rev1.txt 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_3"
                                           value="Do a list command to see all the file details r-w-x. Command ls -l 10%">
                                    Do a list command to see all the file details r-w-x. Command ls -l 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_4" value="Delete file 10% sudo rm rev1.txt 10%">
                                    Delete file 10% sudo rm rev1.txt 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_5" value="Delete and folder 10% sudo rmdir rev1 10%">
                                    Delete and folder 10% sudo rmdir rev1 10%
                                </label>
                            </div>
                        </div>
                        <div id="NETWORKING" class="col-sm-12 d-none">
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_1" value="Create a folder called network 10%">
                                    Create a folder called network 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_2"
                                           value="In the folder create a file called networklab.txt 10%">
                                    In the folder create a file called networklab.txt 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_3" value="Do an ipconfig to find the ip add 10%">
                                    Do an ipconfig to find the ip add 10%
                                </label><br>
                                <label class="radio-inline">
                                    <input type="checkbox" name="task_4"
                                           value="copy the ip address into the networklab.txt file. 10%">
                                    copy the ip address into the networklab.txt file. 10%
                                </label><br>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light mt-2">Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
<script src="assets/datatable/datatables.bootstrap4.min.js"></script>
<script src="assets/datatable/vfs_fonts.js"></script>
<script src="assets/datatable/buttons.html5.min.js"></script>
<script>
    function show() {
        var option = document.getElementById("module").value;
        if (option == "SAD Secured Application development") {
            $('#SAD').removeClass("d-none");
        }
        if (option == "FORENSICS") {
            $('#FORENSICS').removeClass("d-none");
        }
        if (option == "REVERSE MALWARE") {
            $('#REVERSE').removeClass("d-none");
        }
        if (option == "NETWORKING") {
            $('#NETWORKING').removeClass("d-none");
        }
    }
</script>
</body>
</html>