<?php
include_once 'config.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizzical - Logged In</title>
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/loggedin.css">
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading"><img src="img/Qlogo.png" width="60" height="60"></div>
        <div class="list-group list-group-flush">
            <a href="welcome.php?page=1" class="list-group-item list-group-item-action bg-light">Dashboard</a>
            <a href="welcome.php?page=2" class="list-group-item list-group-item-action bg-light">Create Quiz</a>
            <a href="welcome.php?page=3" class="list-group-item list-group-item-action bg-light">View Quizzes</a>
        </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">Show/Hide Menu</button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <div class="container">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. </container>
                </li>
                <li>
                    <a href="logout.php" class="nav-item">Log Out</a>
                </li>
            </ul>
            </div>
        </nav>

        <?php
        if (@$_GET['page'] == 1 || !(@$_GET['page'])) {

            echo '
                <div class="container-fluid">
                    <h1 class="mt-4"><b>Welcome</b>!</h1>
                    <p>This is your dashboard.</p>
                </div>
            ';
                    
        }


        if (@$_GET['page'] == 2 && !(@$_GET['step'])) {
            
            echo ' 
                <div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Quiz Details</b></span><br /><br />
                    <div class="col-md-3"></div><div class="col-md-6">   
                        <form class="form-horizontal title1" name="form" action="update.php?page=addquiz" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="name"></label>  
                                    <div class="col-md-12">
                                        <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="total"></label>  
                                <div class="col-md-12">
                                    <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for="time"></label>  
                                    <div class="col-md-12">
                                        <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 control-label" for=""></label>
                                    <div class="col-md-12"> 
                                        <input type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                                    </div>
                            </div>
                        </fieldset>
                        </form>
                    </div>
            ';                       
        }


        if (@$_GET['page'] == 2 && (@$_GET['step']) == 2) {
   
            echo ' 
                <div class="row">
                    <span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
                    <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <form class="form-horizontal title1" name="form" action="update.php?page=addqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '&ch=4" method="POST">
                            <fieldset>
            ';
                        
            for ($i = 1; $i <= @$_GET['n']; $i++) {
                
                echo '
                    <b>Question number&nbsp;' . $i . '&nbsp;:</><br />
                    <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
                                <div class="col-md-12">
                                    <textarea rows="3" cols="5" name="qns' . $i . '" class="form-control" placeholder="Write question number ' . $i . ' here..."></textarea>  
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '1"></label>  
                                <div class="col-md-12">
                                    <input id="' . $i . '1" name="' . $i . '1" placeholder="Enter option a" class="form-control input-md" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '2"></label>  
                            <div class="col-md-12">
                                <input id="' . $i . '2" name="' . $i . '2" placeholder="Enter option b" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '3"></label>  
                            <div class="col-md-12">
                                <input id="' . $i . '3" name="' . $i . '3" placeholder="Enter option c" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="' . $i . '4"></label>  
                            <div class="col-md-12">
                                <input id="' . $i . '4" name="' . $i . '4" placeholder="Enter option d" class="form-control input-md" type="text">
                            </div>
                        </div>
                        <br /><b>Correct answer</b>:<br />
                        <select id="ans' . $i . '" name="ans' . $i . '" placeholder="Choose correct answer " class="form-control input-md" >
                            <option value="a">option a</option>
                            <option value="b">option b</option>
                            <option value="c">option c</option>
                            <option value="d">option d</option>
                        </select><br /><br />
                ';
            }
                        
            echo '
                    <div class="form-group">
                        <label class="col-md-12 control-label" for=""></label>
                        <div class="col-md-12"> 
                            <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
                        </div>
                    </div>
                    </fieldset>
                    </form>
                </div>
            ';
                        
        }


        if (@$_GET['page'] == 3) {
    
            $result = mysqli_query($link, "SELECT * FROM quiz ORDER BY date DESC") or die('Error');
            
            echo '
                <div class="panel"><table class="table table-striped title1"  style="vertical-align:middle">
                <tr>
                <td style="vertical-align:middle"><b>Name</b></td>
                <td style="vertical-align:middle"><b>Created By</b></td>
                <td style="vertical-align:middle"><b>Total Questions</b></td>
                <td style="vertical-align:middle"><b>Time limit</b></td>
                <td style="vertical-align:middle"><b>Action</b></td>
                </tr>
            ';
            
            $c = 1;
            
            while ($row = mysqli_fetch_array($result)) {
                $title   = $row['title'];
                $owner   = $row['owner'];
                $total   = $row['total'];
                $time    = $row['time'];
                $eid     = $row['eid'];
                            
                echo '
                    <tr>
                    <td style="vertical-align:middle">' . $title . '</td>
                    <td style="vertical-align:middle">' . $owner . '</td>
                    <td style="vertical-align:middle">' . $total . '</td>
                    <td style="vertical-align:middle">' . $time . '&nbsp;min</td>
                    <td style="vertical-align:middle"><b><a href="quiz.php?page=quiz&eid=' . $eid . '" class="btn logb" style="color:#FFFFFF;background:#ff0000;font-size:12px;padding:5px;">&nbsp;<span><b>Take Quiz</b></span></a></b></td>
                    </tr>
                ';
                            
            }
        }
        ?>

            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        });
    </script>

</body>
</html>