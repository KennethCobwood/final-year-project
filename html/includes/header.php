<?php $role=$_SESSION['role'];?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <h3 class="text-white mr-2">Container Maker</h3>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <?php if($role==0){?>
            <li class="nav-item">
                <a href="users.php" class="nav-link btn btn-outline-primary m-2">Users</a>
            </li>
            <?php }?>

            <li class="nav-item">
                <a href="dashboard.php" class="nav-link btn btn-outline-primary m-2">All Containers</a>
            </li>

            <form method="post" action="" style="display: contents">
                <li class="nav-item">
                    <button type="submit" name="ubuntu" class="nav-link btn btn-outline-primary m-2">Create Ubuntu
                        Container
                    </button>
                </li>
                <li class="nav-item ">
                    <button type="submit" name="alpine" class="nav-link btn btn-outline-primary m-2">Create Fedora
                        Container
                    </button>
                </li>
                <li class="nav-item ">
                    <button type="submit" name="linux" class="nav-link btn btn-outline-primary m-2">Create Kali Linux
                        container
                    </button>
                </li>
                <li class="nav-item ">
                  <a href="quiz.php" class="nav-link btn btn-outline-primary m-2">Quiz</a>

                </li>
            </form>
        </ul>
        <h4><a class="btn btn-primary text-white" href="logout.php">Logout</a></h4>
    </div>
</nav>